<?php

namespace HelloPlus\Modules\TemplateParts\Components;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Core\Documents_Manager;
use HelloPlus\Includes\Utils;

/**
 * class Document
 **/
class Document {

	public function get_documents_list(): array {
		return [
			'Ehp_Header',
			'Ehp_Footer',
		];
	}

	public function get_documents_namespace(): string {
		return 'HelloPlus\\Modules\\TemplateParts\\Documents\\';
	}

	/**
	 * Add Hello+ documents
	 *
	 * @param Documents_Manager $documents_manager
	 *
	 * @return void
	 */
	public function register( Documents_Manager $documents_manager ) {
		$documents = $this->get_documents_list();
		$namespace = $this->get_documents_namespace();

		foreach ( $documents as $document ) {
			/** @var \HelloPlus\Modules\TemplateParts\Documents\Ehp_Document_Base $doc_class */
			$doc_class = $namespace . $document;

			// add the doc type to Elementor documents:
			$documents_manager->register_document_type( $doc_class::get_type(), $doc_class );

			$doc_class::register_hooks();
		}
	}

	public function register_remote_source() {
		Utils::elementor()->templates_manager->register_source(
			'HelloPlus\\Modules\\TemplateParts\\Classes\\Sources\\Source_Remote_Ehp'
		);
	}

	public function maybe_set_as_entire_site() {
		$action = isset( $_GET['action'] ) ? sanitize_key( wp_unslash( (string) $_GET['action'] ) ) : '';

		switch ( $action ) {
			case 'hello_plus_set_as_entire_site':
				$post = isset( $_GET['post'] ) ? absint( wp_unslash( $_GET['post'] ) ) : 0;
				check_admin_referer( 'hello_plus_set_as_entire_site_' . $post );

				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'hello-plus' ), '', [ 'response' => 403 ] );
				}

				$redirect_to = isset( $_GET['redirect_to'] ) ? sanitize_url( wp_unslash( $_GET['redirect_to'] ) ) : '';

				$document = Utils::elementor()->documents->get( $post );

				if ( ! $document instanceof \HelloPlus\Modules\TemplateParts\Documents\Ehp_Document_Base ) {
					return;
				}

				$class_name = get_class( $document );
				$post_ids = $class_name::get_all_document_posts( [ 'posts_per_page' => -1 ] );

				foreach ( $post_ids as $post_id ) {
					wp_update_post( [
						'ID' => $post_id,
						'post_status' => 'draft',
					] );
				}

				wp_update_post( [
					'ID' => $post,
					'post_status' => 'publish',
				] );

				wp_safe_redirect( $redirect_to );

				exit;
			default:
				break;
		}
	}

	public function __construct() {
		add_action( 'elementor/documents/register', [ $this, 'register' ] );
		add_action( 'elementor/init', [ $this, 'register_remote_source' ] );
		add_action( 'admin_init', [ $this, 'maybe_set_as_entire_site' ] );
	}
}
