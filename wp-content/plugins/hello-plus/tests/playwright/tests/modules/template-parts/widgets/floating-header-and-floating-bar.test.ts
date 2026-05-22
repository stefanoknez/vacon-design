import { parallelTest as test } from '../../../../parallelTest';
import { expect, type BrowserContext, type Page } from '@playwright/test';
import WpAdminPage from '../../../../pages/wp-admin-page';
import { viewportSize } from '../../../../enums/viewport-sizes';
import { getVideoConfig } from '../../../../assets/video-config';
import { ensureHeaderExists, importFloatingBar, setFloatingBarAsEntireSite, getHeadingsHtmlContent, updateHeaderStickyBehavior, updateHeaderConfiguration } from './ehp-header.helper';

let globalContext: BrowserContext;
let globalPage: Page;
let globalWpAdmin: any;
let globalEditor: any;

test.describe( 'Hello Plus Floating Header with Floating Bar', () => {
	test.beforeEach( async ( { browser, apiRequests, storageState }, testInfo ) => {
		globalContext = await browser.newContext( {
			storageState,
			recordVideo: getVideoConfig( testInfo ),
		} );
		globalPage = await globalContext.newPage();
		globalWpAdmin = new WpAdminPage( globalPage, testInfo, apiRequests );
		await globalWpAdmin.hideAdminBar();
	} );

	test.afterEach( async () => {
		if ( globalContext ) {
			await globalContext.close();
			globalContext = null as any;
			globalPage = null as any;
			globalWpAdmin = null as any;
			globalEditor = null as any;
		}
	} );

	test( 'Hello Plus Floating Header with Floating Bar', async () => {
		const pageEditor = await globalWpAdmin.openNewPage();
		await pageEditor.closeNavigatorIfOpen();
		globalEditor = pageEditor;

		let testPageUrl: string;

		await test.step( 'Create test page with content', async () => {
			const container = await pageEditor.addElement( { elType: 'container' }, 'document' );
			await pageEditor.addWidget( 'html', container );
			await pageEditor.setTextareaControlValue( 'type-code', getHeadingsHtmlContent() );

			await pageEditor.publishAndViewPage();
			testPageUrl = pageEditor.page.url();
		} );

		let headerPostId: number;

		await test.step( 'Test page with floating bar and Hello Plus floating header', async () => {
			await test.step( 'Ensure header exists', async () => {
				headerPostId = await ensureHeaderExists( globalEditor );
			} );

			await test.step( 'Enable floating behavior with offset and width', async () => {
				await updateHeaderConfiguration( globalEditor, headerPostId, {
					behaviorFloat: true,
					behaviorFloatOffset: { size: 10, unit: 'px' },
					behaviorFloatWidth: { size: 90, unit: '%' },
				} );
			} );

			await test.step( 'Import floating bar', async () => {
				await importFloatingBar( globalEditor, globalWpAdmin );
			} );

			await test.step( 'Set floating bar as entire site', async () => {
				await setFloatingBarAsEntireSite( globalEditor, globalWpAdmin );
			} );
		} );

		await test.step( 'Header sticky behavior (advanced tab) test', async () => {
			const behaviors = [ 'none', 'scroll-up', 'always' ] as const;

			for ( const behavior of behaviors ) {
				await test.step( `Test sticky behavior: ${ behavior }`, async () => {
					await globalWpAdmin.gotoDashboard();
					await updateHeaderStickyBehavior( globalEditor, headerPostId, behavior );
					await pageEditor.page.goto( testPageUrl );

					await pageEditor.page.setViewportSize( viewportSize.desktop );
					const headerSelector = 'header.ehp-header';
					await expect( pageEditor.page.locator( headerSelector ) ).toBeVisible();

					const viewport = pageEditor.page.viewportSize();
					const clipHeight = 500;
					const screenshotOptions = {
						clip: { x: 0, y: 0, width: viewport!.width, height: clipHeight },
						animations: 'disabled' as const,
						caret: 'hide' as const,
					};

					const screenshotName = `float-bar-header-sticky-${ behavior }-initial.png`;
					await expect.soft( pageEditor.page ).toHaveScreenshot( screenshotName, screenshotOptions );

					await pageEditor.page.mouse.wheel( 0, 90 );
					await pageEditor.page.waitForTimeout( 1000 );

					const screenshotNameScrolled = `float-bar-header-sticky-${ behavior }-scrolled.png`;
					await expect.soft( pageEditor.page ).toHaveScreenshot( screenshotNameScrolled, screenshotOptions );

					if ( 'scroll-up' === behavior ) {
						await pageEditor.page.mouse.wheel( 0, -300 );
						await pageEditor.page.waitForTimeout( 800 );
						const screenshotNameScrolledUp = `float-bar-header-sticky-${ behavior }-scrolled-up.png`;
						await expect.soft( pageEditor.page ).toHaveScreenshot( screenshotNameScrolledUp, screenshotOptions );
					}
				} );
			}
		} );

		await test.step( 'Show admin bar', async () => {
			await globalWpAdmin.showAdminBar();
		} );
	} );
} );
