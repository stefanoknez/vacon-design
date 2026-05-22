<?php

namespace HelloPlus\Tests\Modules\TemplateParts\Documents;

use HelloPlus\Modules\TemplateParts\Components\Document;
use HelloPlus\Modules\TemplateParts\Documents\Ehp_Header;
use HelloPlus\Includes\Utils;
use ElementorEditorTesting\Elementor_Test_Base;

class Test_Document_Security extends Elementor_Test_Base {

	public function test_maybe_set_as_entire_site_unauthorized() {
		$user_id = $this->factory->user->create( [ 'role' => 'author' ] );
		wp_set_current_user( $user_id );

		$_GET['action'] = 'hello_plus_set_as_entire_site';
		$_GET['post'] = 123;
		$_GET['_wpnonce'] = wp_create_nonce( 'hello_plus_set_as_entire_site_123' );

		$document_component = new Document();

		if ( class_exists( 'WPDieException' ) ) {
			$this->expectException( 'WPDieException' );
		}

		$document_component->maybe_set_as_entire_site();
	}

	public function test_set_as_entire_site_row_action_visibility() {
		$post_id = $this->factory->post->create( [ 'post_type' => 'elementor_library' ] );
		$ehp_header = new Ehp_Header( [ 'post_id' => $post_id ] );

		$admin_id = $this->factory->user->create( [ 'role' => 'administrator' ] );
		wp_set_current_user( $admin_id );

		$actions = [ 'edit' => 'Edit' ];
		$updated_actions = $ehp_header->set_as_entire_site( $actions );
		$this->assertArrayHasKey( 'set_as_entire_site', $updated_actions );

		$author_id = $this->factory->user->create( [ 'role' => 'author' ] );
		wp_set_current_user( $author_id );

		$updated_actions = $ehp_header->set_as_entire_site( $actions );
		$this->assertArrayNotHasKey( 'set_as_entire_site', $updated_actions );
	}
}
