import { parallelTest as test } from '../../../../parallelTest';
import { expect, type BrowserContext, type Page } from '@playwright/test';
import WpAdminPage from '../../../../pages/wp-admin-page';
import { viewportSize } from '../../../../enums/viewport-sizes';
import { getVideoConfig } from '../../../../assets/video-config';
import { ensureHeaderExists, updateHeaderStickyBehavior, updateHeaderConfiguration } from './ehp-header.helper';

const WIDGET_CSS_CLASS = '.ehp-header';

const CONTROL_VALUES = {
	layoutPreset: [ 'connect', 'identity', 'navigate' ],
	menuItemSpacing: [ '16', '32', '48' ],
	submenuLayout: [ 'horizontal', 'vertical' ],
	alternateBackgroundColors: [ '#E8F4FD', '#FFF3E0', '#F6F7F8' ],
};

let globalContext: BrowserContext;
let globalPage: Page;
let globalWpAdmin: any;
let globalEditor: any;

async function runHeaderConfigurationtest( loopIndex: number, headerPostId: number ) {
	const config: {
		layoutPreset?: string;
		contactButtonsShowConnect?: boolean;
		contactButtonsShow?: boolean;
		menuItemSpacing?: string;
		submenuLayout?: string;
		backgroundColor?: string;
	} = {
		layoutPreset: globalEditor.getControlValueByIndex( CONTROL_VALUES.layoutPreset, loopIndex ),
		menuItemSpacing: globalEditor.getControlValueByIndex( CONTROL_VALUES.menuItemSpacing, loopIndex ),
		submenuLayout: globalEditor.getControlValueByIndex( CONTROL_VALUES.submenuLayout, loopIndex ),
		backgroundColor: globalEditor.getControlValueByIndex( CONTROL_VALUES.alternateBackgroundColors, loopIndex ),
	};

	if ( 0 === loopIndex ) {
		config.contactButtonsShowConnect = true;
	} else {
		config.contactButtonsShow = true;
	}

	await updateHeaderConfiguration( globalEditor, headerPostId, config );

	await globalEditor.page.goto( '/' );

	const frontendWidget = globalEditor.page.locator( WIDGET_CSS_CLASS );
	await expect( frontendWidget ).toBeVisible();

	await expect
		.soft( frontendWidget )
		.toHaveScreenshot( `header-config-${ loopIndex + 1 }-frontend.png`, {
			animations: 'disabled',
			caret: 'hide',
		} );

	await globalEditor.page.setViewportSize( viewportSize.tablet );
	await globalEditor.stabilizeForScreenshot( globalEditor.page, globalEditor );
	await expect
		.soft( frontendWidget )
		.toHaveScreenshot( `header-config-${ loopIndex + 1 }-frontend-tablet.png`, {
			animations: 'disabled',
			caret: 'hide',
		} );

	await globalEditor.page.setViewportSize( viewportSize.mobile );
	await globalEditor.stabilizeForScreenshot( globalEditor.page, globalEditor );
	await expect
		.soft( frontendWidget )
		.toHaveScreenshot( `header-config-${ loopIndex + 1 }-frontend-mobile.png`, {
			animations: 'disabled',
			caret: 'hide',
		} );

	await globalEditor.page.setViewportSize( viewportSize.desktop );
}

test.describe.serial( 'Hello Plus Header', () => {
	let menuImported = false;

	test.beforeEach( async ( { browser, apiRequests, storageState }, testInfo ) => {
		globalContext = await browser.newContext( {
			storageState,
			recordVideo: getVideoConfig( testInfo ),
		} );
		globalPage = await globalContext.newPage();
		globalWpAdmin = new WpAdminPage( globalPage, testInfo, apiRequests );

		if ( ! menuImported ) {
			await globalWpAdmin.deleteAllMenus();
			await globalWpAdmin.importMenu();
			menuImported = true;
		}

		globalEditor = await globalWpAdmin.openNewPage();
		await globalEditor.closeNavigatorIfOpen();
	} );

	test.afterEach( async () => {
		if ( globalEditor ) {
			globalEditor = null as any;
		}
	} );

	test.afterAll( async () => {
		if ( globalContext ) {
			await globalContext.close();
			globalContext = null as any;
			globalPage = null as any;
			globalWpAdmin = null as any;
			globalEditor = null as any;
		}
	} );

	test( 'Assert that the dropdown button does not inherit the background color from the theme settings', async () => {
		await test.step( 'Update Hello Commerce style settings', async () => {
			await globalEditor.openSiteSettings( 'theme-style-buttons' );
			await globalEditor.setBackgroundColorControlValue(
				'button_background_color_background',
				'button_background_color',
				'#3bc7b6',
			);
			await globalEditor.saveSiteSettingsWithTopBar( false );
		} );

		await test.step( 'Ensure header exists', async () => {
			await ensureHeaderExists( globalEditor );
		} );

		await test.step( 'Verify header on frontend', async () => {
			await globalEditor.page.waitForTimeout( 200 );
			await globalEditor.page.goto( '/' );
			const parentItem = globalEditor.page
				.getByRole( 'button', { name: 'Parent menu item' } )
				.locator( '..' );
			await globalEditor.stabilizeForScreenshot( globalEditor.page, globalEditor );
			await expect( parentItem ).toBeVisible();
			await expect
				.soft( parentItem )
				.toHaveScreenshot( 'header-parent-menu-item.png', {
					animations: 'disabled',
					caret: 'hide',
				} );
		} );
	} );

	test( 'Header randomized configuration test', async () => {
		await globalEditor.page.goto( '/wp-admin/' );
		await globalEditor.page.waitForLoadState( 'networkidle' );

		const headerPostId = await ensureHeaderExists( globalEditor );

		await runHeaderConfigurationtest( 0, headerPostId );
		await runHeaderConfigurationtest( 1, headerPostId );
		await runHeaderConfigurationtest( 2, headerPostId );
	} );

	test( 'Header sticky behavior (advanced tab) test', async () => {
		const headerPostId = await ensureHeaderExists( globalEditor );
		const behaviors = [ 'scroll-up', 'always', 'none' ] as const;

		const pageEditor = await globalWpAdmin.openNewPage();
		await pageEditor.closeNavigatorIfOpen();
		for ( let i = 0; i < 3; i++ ) {
			await pageEditor.addWidget( 'zigzag' );
		}
		await pageEditor.publishAndViewPage();

		const testPageUrl = pageEditor.page.url();

		for ( const behavior of behaviors ) {
			await test.step( `Test sticky behavior: ${ behavior }`, async () => {
				await globalWpAdmin.gotoDashboard();
				await updateHeaderStickyBehavior( globalEditor, headerPostId, behavior );
				await pageEditor.page.goto( testPageUrl );

				await pageEditor.page.setViewportSize( viewportSize.desktop );
				const headerSelector = 'header.ehp-header';
				await expect( pageEditor.page.locator( headerSelector ) ).toBeVisible();

				await pageEditor.page.mouse.wheel( 0, 600 );
				await pageEditor.page.waitForTimeout( 800 );

				if ( 'always' === behavior ) {
					expect
						.soft( await pageEditor.isItemInViewport( headerSelector ) )
						.toBeTruthy();
				} else if ( 'none' === behavior ) {
					expect
						.soft( await pageEditor.isItemInViewport( headerSelector ) )
						.toBeFalsy();
				} else if ( 'scroll-up' === behavior ) {
					expect
						.soft( await pageEditor.isItemInViewport( headerSelector ) )
						.toBeFalsy();
					await pageEditor.page.mouse.wheel( 0, -300 );
					await pageEditor.page.waitForTimeout( 800 );
					expect
						.soft( await pageEditor.isItemInViewport( headerSelector ) )
						.toBeTruthy();
				}
			} );
		}
	} );
} );
