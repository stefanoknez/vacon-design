<?php

namespace HelloPlus\Modules\Admin\Components;

use HelloPlus\Includes\Utils;
use HelloPlus\Modules\Admin\Classes\Ajax\Blank_Canvas_Option;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Blank_Canvas_Page_Creator {

	const ACTION_PARAM = 'helloplus_create_blank_canvas_page';

	public function handle_blank_canvas_request() {
		$action = filter_input( INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS );

		if ( self::ACTION_PARAM !== $action ) {
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Insufficient permissions.', 'hello-plus' ), 403 );
		}

		if ( ! Blank_Canvas_Option::has_chosen_blank_canvas() ) {
			wp_safe_redirect( self_admin_url() );
			exit;
		}

		try {
			$page_id = Utils::create_home_page();

			$redirect_url = add_query_arg(
				[
					'post' => $page_id,
					'action' => 'elementor',
				],
				admin_url( 'post.php' )
			);

			wp_safe_redirect( $redirect_url );
			exit;
		} catch ( \Exception $e ) {
			wp_die( esc_html( $e->getMessage() ), 500 );
		}
	}

	public function __construct() {
		add_action( 'admin_init', [ $this, 'handle_blank_canvas_request' ] );
	}
}
