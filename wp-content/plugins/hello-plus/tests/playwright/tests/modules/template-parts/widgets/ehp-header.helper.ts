import _path from 'path';
import { readFile } from 'fs/promises';
import type EditorPage from '../../../../pages/editor-page';
import type WpAdminPage from '../../../../pages/wp-admin-page';
import { expect } from '@playwright/test';
import { WindowType } from '../../../../types/types';

type ElementorLibraryPost = {
	id?: number;
	title?: {
		rendered?: string;
	};
};

type FloatingBarMeta = {
	meta?: {
		_elementor_conditions?: string[];
	};
};

const HEADER_TITLE = 'Elementor Hello+ Header #9';
const FLOATING_BAR_TITLE = 'Elementor Floating Element #64535';

const NONCE_CACHE: Map<string, { nonce: string; timestamp: number }> = new Map();
const NONCE_CACHE_TTL = 300000;
const NONCE_CACHE_KEY = 'default';

function generateElementId(): string {
	return Math.random().toString( 36 ).substring( 2, 9 );
}

function getCacheKey( editor: EditorPage ): string {
	try {
		return editor.page.url();
	} catch {
		return NONCE_CACHE_KEY;
	}
}

function getCachedNonce( cacheKey: string ): string | null {
	const cached = NONCE_CACHE.get( cacheKey );
	if ( ! cached ) {
		return null;
	}
	const age = Date.now() - cached.timestamp;
	if ( age > NONCE_CACHE_TTL ) {
		NONCE_CACHE.delete( cacheKey );
		return null;
	}
	return cached.nonce;
}

function setCachedNonce( cacheKey: string, nonce: string ): void {
	NONCE_CACHE.set( cacheKey, {
		nonce,
		timestamp: Date.now(),
	} );
}

export function clearNonceCache(): void {
	NONCE_CACHE.clear();
}

async function createHeaderElementData() {
	const filePath = _path.resolve( __dirname, '../../../../templates/ehp-header-widget-data.json' );
	const rawFileData = await readFile( filePath );
	const templateData = JSON.parse( rawFileData.toString() );

	const containerId = generateElementId();
	const widgetId = generateElementId();

	const elementData = templateData[ 0 ];
	elementData.id = containerId;
	elementData.elements[ 0 ].id = widgetId;

	return [ elementData ];
}

async function createHeaderTemplate( request: any, nonce: string, elementData: any[] ): Promise<number> {
	const createResponse = await request.post( '/index.php', {
		params: {
			rest_route: '/elementor/v1/template-library/templates',
		},
		headers: {
			'X-WP-Nonce': nonce,
			'Content-Type': 'application/json',
		},
		data: {
			title: HEADER_TITLE,
			type: 'ehp-header',
			content: elementData,
		},
	} );

	if ( ! createResponse.ok() ) {
		const errorText = await createResponse.text();
		throw new Error( `Failed to create header via API: ${ createResponse.status() }. ${ errorText }` );
	}

	const createResponseData = await createResponse.json();

	if ( ! createResponseData ) {
		throw new Error( `Failed to create header: Empty API response` );
	}

	const headerId = createResponseData.id || createResponseData.data?.id || createResponseData.template_id;

	if ( ! headerId ) {
		throw new Error( `Failed to create header: API response missing id field. Response: ${ JSON.stringify( createResponseData ) }` );
	}

	return headerId;
}

async function getNonce( editor: EditorPage, request: any ): Promise<string> {
	const cacheKey = getCacheKey( editor );

	const cachedNonce = getCachedNonce( cacheKey );
	if ( cachedNonce ) {
		return cachedNonce;
	}

	try {
		const nonce = await editor.page.evaluate( () => {
			return ( window as WindowType ).wpApiSettings?.nonce || '';
		} );

		if ( nonce ) {
			setCachedNonce( cacheKey, nonce );
			return nonce;
		}
	} catch ( error ) {
	}

	const baseUrl = editor.page.url().split( '/wp-admin' )[ 0 ] || editor.page.url().split( '/wp' )[ 0 ];

	try {
		const response = await request.get( `${ baseUrl }/wp-admin/post-new.php` );

		if ( ! response.ok() ) {
			throw new Error( `API request failed: ${ response.status() }` );
		}
		const pageText = await response.text();
		const nonceMatch = pageText.match( /var wpApiSettings = .*;/ );

		if ( nonceMatch ) {
			const nonce = nonceMatch[ 0 ].replace( /^.*"nonce":"([^"]*)".*$/, '$1' );
			setCachedNonce( cacheKey, nonce );
			return nonce;
		}
	} catch ( error ) {
	}

	await editor.page.goto( '/wp-admin/post-new.php' );
	await editor.page.waitForLoadState( 'load' );
	await editor.page.waitForFunction( () => {
		return typeof ( window as WindowType ).wpApiSettings !== 'undefined';
	}, { timeout: 10000 } );

	const nonce = await editor.page.evaluate( () => {
		return ( window as WindowType ).wpApiSettings?.nonce || '';
	} );

	if ( ! nonce ) {
		throw new Error( 'Failed to get WordPress REST API nonce. Make sure you are authenticated.' );
	}

	setCachedNonce( cacheKey, nonce );
	return nonce;
}

async function deleteHeaderTemplate( request: any, nonce: string, headerId: number ): Promise<void> {
	const deleteResponse = await request.delete( '/index.php', {
		params: {
			rest_route: `/wp/v2/elementor_library/${ headerId }`,
			force: 'true',
		},
		headers: {
			'X-WP-Nonce': nonce,
		},
	} );

	if ( ! deleteResponse.ok() ) {
		const errorText = await deleteResponse.text();
		throw new Error( `Failed to delete header via API: ${ deleteResponse.status() }. ${ errorText }` );
	}
}

export async function ensureHeaderExists( editor: EditorPage, _forceRecreate = false ): Promise<number> {
	const request = editor.page.context().request;

	const nonce = await getNonce( editor, request );

	const existingHeadersResponse = await request.get( '/index.php', {
		params: {
			rest_route: '/wp/v2/elementor_library',
			elementor_library_type: 'ehp-header',
			search: HEADER_TITLE,
		},
		headers: {
			'X-WP-Nonce': nonce,
		},
	} );

	const existingHeaders = await existingHeadersResponse.json() as ElementorLibraryPost[];
	const matchingHeaders = Array.isArray( existingHeaders )
		? existingHeaders.filter( ( header: ElementorLibraryPost ) => header.title?.rendered === HEADER_TITLE )
		: [];

	if ( matchingHeaders.length > 0 ) {
		for ( const header of matchingHeaders ) {
			if ( header.id ) {
				try {
					await deleteHeaderTemplate( request, nonce, header.id );
				} catch ( error ) {
				}
			}
		}
	}

	const elementData = await createHeaderElementData();
	const headerId = await createHeaderTemplate( request, nonce, elementData );

	return headerId;
}

export async function importFloatingBar( editor: EditorPage, wpAdmin: WpAdminPage ): Promise<void> {
	await editor.page.goto( '/wp-admin/edit.php?post_type=e-floating-buttons' );
	await editor.page.waitForLoadState( 'load' );

	const floatingBarLink = editor.page.getByRole( 'link', { name: FLOATING_BAR_TITLE } );
	const floatingBarCount = await floatingBarLink.count();

	if ( 0 === floatingBarCount ) {
		const filePath = _path.resolve(
			__dirname,
			`../../../../sample-data/floating-bar-export.xml`,
		);
		await wpAdmin.importWordPressXml( filePath, editor.page );
	}
}

export async function deactivateAllFloatingBars( page: any ): Promise<void> {
	await page.goto( '/wp-admin/edit.php?post_type=e-floating-buttons' );
	await page.waitForLoadState( 'load' );

	const listTable = page.locator( '.wp-list-table' ).first();
	const checkbox = listTable.locator( '[type="checkbox"]' ).first();

	if ( ! await checkbox.isVisible() ) {
		return;
	}

	await checkbox.check();

	const bulkActionSelector = page.locator( '#bulk-action-selector-top' );
	const trashOptionExists = await bulkActionSelector.locator( 'option[value="trash"]' ).count() > 0;

	if ( ! trashOptionExists ) {
		return;
	}

	await bulkActionSelector.selectOption( 'trash' );
	await page.locator( '#doaction' ).click();
	await page.waitForLoadState( 'load' );
}

export async function setFloatingBarAsEntireSite( editor: EditorPage, wpAdmin: WpAdminPage ): Promise<void> {
	await wpAdmin.gotoDashboard();
	await editor.page.goto( '/wp-admin/edit.php?post_type=e-floating-buttons' );
	await editor.page.waitForLoadState( 'load' );

	const floatingBarRow = editor.page.locator( '.wp-list-table tr:has-text("Elementor Floating Element")' ).first();
	await floatingBarRow.locator( 'a.row-title' ).hover();

	const postId = await floatingBarRow.getAttribute( 'id' );
	const postIdMatch = postId.match( /post-(\d+)/ );
	const floatingBarPostId = postIdMatch[ 1 ];

	const request = editor.page.context().request;
	const baseUrl = editor.page.url().split( '/wp-admin' )[ 0 ];
	const conditionsResponse = await request.get( `${ baseUrl }/index.php`, {
		params: { rest_route: `/wp/v2/e-floating-buttons/${ floatingBarPostId }` },
	} );
	const conditionsMeta = await conditionsResponse.json() as FloatingBarMeta;
	const elementorConditions = conditionsMeta.meta?._elementor_conditions;

	if ( ! elementorConditions || ! Array.isArray( elementorConditions ) || ! elementorConditions.includes( 'include/general' ) ) {
		const nonce = await editor.page.evaluate( () => {
			return ( window as any ).wpApiSettings?.nonce || '';
		} );

		const updateResponse = await request.post( `${ baseUrl }/index.php`, {
			params: { rest_route: `/wp/v2/e-floating-buttons/${ floatingBarPostId }` },
			headers: {
				'X-WP-Nonce': nonce,
				'Content-Type': 'application/json',
			},
			data: {
				meta: {
					_elementor_conditions: [ 'include/general' ],
				},
			},
		} );

		expect( updateResponse.ok() ).toBeTruthy();
	}
}

export async function updateHeaderStickyBehavior( editor: EditorPage, headerPostId: number, behavior: 'scroll-up' | 'always' | 'none' ): Promise<void> {
	const request = editor.page.context().request;
	const baseUrl = editor.page.url().split( '/wp-admin' )[ 0 ] || editor.page.url().split( '/wp' )[ 0 ];

	const nonce = await getNonce( editor, request );

	const getResponse = await request.get( `${ baseUrl }/index.php`, {
		params: {
			rest_route: `/wp/v2/elementor_library/${ headerPostId }`,
			context: 'edit',
		},
		headers: {
			'X-WP-Nonce': nonce,
		},
	} );

	if ( ! getResponse.ok() ) {
		const errorText = await getResponse.text();
		throw new Error( `Failed to get header data via API: ${ getResponse.status() }. ${ errorText }` );
	}

	const headerData = await getResponse.json() as any;

	const elementorDataString = ( () => {
		if ( headerData.meta?._elementor_data ) {
			if ( 'string' === typeof headerData.meta._elementor_data ) {
				return headerData.meta._elementor_data;
			}
			return JSON.stringify( headerData.meta._elementor_data );
		}
		if ( headerData._elementor_data ) {
			if ( 'string' === typeof headerData._elementor_data ) {
				return headerData._elementor_data;
			}
			return JSON.stringify( headerData._elementor_data );
		}
		throw new Error( `Header data missing _elementor_data meta field. Post ID: ${ headerPostId }. Response structure: ${ JSON.stringify( Object.keys( headerData ) ) }` );
	} )();

	const elementorData = ( () => {
		try {
			return JSON.parse( elementorDataString ) as any[];
		} catch ( error ) {
			throw new Error( `Failed to parse _elementor_data JSON: ${ error }` );
		}
	} )();

	if ( 0 === elementorData.length || ! Array.isArray( elementorData ) ) {
		throw new Error( `Invalid elementor_data structure: expected array with at least one element` );
	}

	const container = elementorData[ 0 ];
	if ( 0 === container.elements.length || ! Array.isArray( container.elements ) || ! container?.elements ) {
		throw new Error( `Invalid elementor_data structure: container missing elements array` );
	}

	const widget = container.elements[ 0 ];
	if ( 'ehp-header' !== widget.widgetType || ! widget ) {
		throw new Error( `Header widget not found or incorrect widgetType. Found: ${ widget?.widgetType || 'undefined' }` );
	}

	if ( ! widget.settings ) {
		widget.settings = {};
	}

	const oldBehavior = widget.settings.behavior_onscroll_select;

	if ( behavior === oldBehavior ) {
		return;
	}

	widget.settings.behavior_onscroll_select = behavior;

	const updateResponse = await request.put( `${ baseUrl }/index.php`, {
		params: {
			rest_route: `/wp/v2/elementor_library/${ headerPostId }`,
		},
		headers: {
			'X-WP-Nonce': nonce,
			'Content-Type': 'application/json',
		},
		data: {
			meta: {
				_elementor_data: JSON.stringify( elementorData ),
			},
		},
	} );

	if ( ! updateResponse.ok() ) {
		const errorText = await updateResponse.text();
		throw new Error( `Failed to update header via API: ${ updateResponse.status() }. ${ errorText }` );
	}

	try {
		await request.delete( `${ baseUrl }/index.php`, {
			params: {
				rest_route: '/elementor/v1/cache',
			},
			headers: {
				'X-WP-Nonce': nonce,
			},
		} );
	} catch ( error ) {
	}
}

export async function updateHeaderConfiguration(
	editor: EditorPage,
	headerPostId: number,
	config: {
		layoutPreset?: string;
		contactButtonsShowConnect?: boolean;
		contactButtonsShow?: boolean;
		menuItemSpacing?: string;
		submenuLayout?: string;
		backgroundColor?: string;
		behaviorFloat?: boolean;
		behaviorFloatOffset?: { size: number; unit: string };
		behaviorFloatWidth?: { size: number; unit: string };
	},
): Promise<void> {
	const request = editor.page.context().request;
	const baseUrl = editor.page.url().split( '/wp-admin' )[ 0 ] || editor.page.url().split( '/wp' )[ 0 ];

	const nonce = await getNonce( editor, request );

	const getResponse = await request.get( `${ baseUrl }/index.php`, {
		params: {
			rest_route: `/wp/v2/elementor_library/${ headerPostId }`,
			context: 'edit',
		},
		headers: {
			'X-WP-Nonce': nonce,
		},
	} );

	if ( ! getResponse.ok() ) {
		const errorText = await getResponse.text();
		throw new Error( `Failed to get header data via API: ${ getResponse.status() }. ${ errorText }` );
	}

	const headerData = await getResponse.json() as any;

	const elementorDataString = ( () => {
		if ( headerData.meta?._elementor_data ) {
			if ( 'string' === typeof headerData.meta._elementor_data ) {
				return headerData.meta._elementor_data;
			}
			return JSON.stringify( headerData.meta._elementor_data );
		}
		if ( headerData._elementor_data ) {
			if ( 'string' === typeof headerData._elementor_data ) {
				return headerData._elementor_data;
			}
			return JSON.stringify( headerData._elementor_data );
		}
		throw new Error( `Header data missing _elementor_data meta field. Post ID: ${ headerPostId }. Response structure: ${ JSON.stringify( Object.keys( headerData ) ) }` );
	} )();

	const elementorData = ( () => {
		try {
			return JSON.parse( elementorDataString ) as any[];
		} catch ( error ) {
			throw new Error( `Failed to parse _elementor_data JSON: ${ error }` );
		}
	} )();

	if ( 0 === elementorData.length || ! Array.isArray( elementorData ) ) {
		throw new Error( `Invalid elementor_data structure: expected array with at least one element` );
	}

	const container = elementorData[ 0 ];
	if ( 0 === container.elements.length || ! Array.isArray( container.elements ) || ! container?.elements ) {
		throw new Error( `Invalid elementor_data structure: container missing elements array` );
	}

	const widget = container.elements[ 0 ];
	if ( 'ehp-header' !== widget.widgetType || ! widget ) {
		throw new Error( `Header widget not found or incorrect widgetType. Found: ${ widget?.widgetType || 'undefined' }` );
	}

	if ( ! widget.settings ) {
		widget.settings = {};
	}

	if ( config.layoutPreset ) {
		widget.settings.layout_preset_select = config.layoutPreset;
	}

	if ( undefined !== config.contactButtonsShowConnect ) {
		widget.settings.contact_buttons_show_connect = config.contactButtonsShowConnect;
	}

	if ( undefined !== config.contactButtonsShow ) {
		widget.settings.contact_buttons_show = config.contactButtonsShow;
	}

	if ( config.menuItemSpacing ) {
		widget.settings.menu_item_spacing = {
			size: parseInt( config.menuItemSpacing, 10 ),
			unit: 'px',
		};
	}

	if ( config.submenuLayout ) {
		widget.settings.style_submenu_layout = config.submenuLayout;
	}

	if ( config.backgroundColor ) {
		if ( ! widget.settings.background_background ) {
			widget.settings.background_background = 'classic';
		}
		widget.settings.background_color = config.backgroundColor;
	}

	if ( undefined !== config.behaviorFloat ) {
		widget.settings.behavior_float = config.behaviorFloat ? 'yes' : 'no';
	}

	if ( config.behaviorFloatOffset ) {
		widget.settings.behavior_float_offset = config.behaviorFloatOffset;
	}

	if ( config.behaviorFloatWidth ) {
		widget.settings.behavior_float_width = config.behaviorFloatWidth;
	}

	const updateResponse = await request.put( `${ baseUrl }/index.php`, {
		params: {
			rest_route: `/wp/v2/elementor_library/${ headerPostId }`,
		},
		headers: {
			'X-WP-Nonce': nonce,
			'Content-Type': 'application/json',
		},
		data: {
			meta: {
				_elementor_data: JSON.stringify( elementorData ),
			},
		},
	} );

	if ( ! updateResponse.ok() ) {
		const errorText = await updateResponse.text();
		throw new Error( `Failed to update header via API: ${ updateResponse.status() }. ${ errorText }` );
	}

	try {
		await request.delete( `${ baseUrl }/index.php`, {
			params: {
				rest_route: '/elementor/v1/cache',
			},
			headers: {
				'X-WP-Nonce': nonce,
			},
		} );
	} catch ( error ) {
	}
}

export function getHeadingsHtmlContent(): string {
	return `
<style>
	h1 { background-color: #FF0000; color: #FFFFFF; width: 100%; }
	h2 { background-color: #FF6600; color: #FFFFFF; width: 100%; }
	h3 { background-color: #FFCC00; color: #FFFFFF; width: 100%; }
	h4 { background-color: #66FF00; color: #FFFFFF; width: 100%; }
	h5 { background-color: #0066FF; color: #FFFFFF; width: 100%; }
	h6 { background-color: #6600FF; color: #FFFFFF; width: 100%; }
</style>
<h1>Heading 1 - First - Test heading widget number 1</h1>
<h2>Heading 2 - First - Test heading widget number 2</h2>
<h3>Heading 3 - First - Test heading widget number 3</h3>
<h4>Heading 4 - First - Test heading widget number 4</h4>
<h5>Heading 5 - First - Test heading widget number 5</h5>
<h6>Heading 6 - First - Test heading widget number 6</h6>
<h1>Heading 1 - Second - Test heading widget number 7</h1>
<h2>Heading 2 - Second - Test heading widget number 7</h2>
<h3>Heading 3 - Second - Test heading widget number 8</h3>
<h4>Heading 4 - Second - Test heading widget number 9</h4>
<h5>Heading 5 - Second - Test heading widget number 10</h5>
<h6>Heading 6 - Second - Test heading widget number 11</h6>
<h1>Heading 1 - Third - Test heading widget number 12</h1>
<h2>Heading 2 - Third - Test heading widget number 12</h2>
<h3>Heading 3 - Third - Test heading widget number 13</h3>
<h4>Heading 4 - Third - Test heading widget number 14</h4>
<h5>Heading 5 - Third - Test heading widget number 15</h5>
<h6>Heading 6 - Third - Test heading widget number 16</h6>
`;
}
