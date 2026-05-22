import { expect } from '@playwright/test';
import { parallelTest as test } from '../../../parallelTest';
import WpAdminPage from '../../../pages/wp-admin-page';
import Form from '../../../helpers/elementor-pro-form-helper';
import { type Field } from '../../../types/types';

let context;
let page;
let wpAdmin;
let editor;
const elementorProAvailable = 'false' !== process.env.ELEMENTOR_PRO_AVAILABLE;

test.describe( 'Elementor Pro form', () => {
	test.beforeAll( async ( { browser, apiRequests, request }, testInfo ) => {
		context = await browser.newContext();
		page = await context.newPage();
		wpAdmin = new WpAdminPage( page, testInfo, apiRequests );

		if ( elementorProAvailable ) {
			await apiRequests.activatePlugin( request, 'elementor-pro/elementor-pro' );
		}
	} );

	test.afterAll( async ( { apiRequests, request } ) => {
		if ( elementorProAvailable ) {
			await apiRequests.deactivatePlugin( request, 'elementor-pro/elementor-pro' );
		}

		if ( context ) {
			await context.close();
		}
	} );

	test( 'Form with MailChimp integration test', async () => {
		test.skip( ! elementorProAvailable, 'Elementor Pro is not available' );
		await page.goto( '/wp-admin/plugins.php' );
		await page.waitForLoadState( 'load' );

		const elementorProRow = page.locator( 'tr[data-slug="elementor-pro"]' ).first();
		await expect( elementorProRow ).toHaveClass( /active/ );

		try {
			editor = await wpAdmin.openNewPage();
		} catch {
			editor = await wpAdmin.openNewPage();
		}

		const form = new Form( page );
		const field: Field = {
			type: 'email',
			placeholder: 'enter email',
			text: 'someone@gmail.com',
		};

		await editor.closeNavigatorIfOpen();
		await editor.addWidget( 'form' );
		await form.removeColumns();
		await form.mockIntegrations();
		await form.addNewField();
		await form.setContentFieldData( field );
		await form.setActionAfterSubmission( [ 'Collect Submissions', 'MailChimp' ] );
		await editor.openSection( 'section_mailchimp' );
		await page.waitForResponse( /wp-admin\/admin-ajax.php/ );
		await editor.setSelectControlValue( 'mailchimp_list', 'Elementor' );
		await editor.setTextControlValue( 'mailchimp_tags', 'test' );
		await page.getByRole( 'list' ).last().click();
		await page.getByText( '+', { exact: true } ).click();
		await expect( page.getByRole( 'treeitem', { name: 'GROUP CAT 1 - A' } ) ).toBeVisible();
		await editor.publishAndViewPage();
		await page.locator( 'input[placeholder="Email"]' ).first().fill( 'test@test.com' );
		await form.submitForm();

		const dangerMessage = page.locator( '.elementor-message-danger' );
		await dangerMessage.waitFor();
		await expect( dangerMessage ).toContainText( 'MailChimp' );
	} );
} );
