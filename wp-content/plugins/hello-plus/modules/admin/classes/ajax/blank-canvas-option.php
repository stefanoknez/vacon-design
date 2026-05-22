<?php

namespace HelloPlus\Modules\Admin\Classes\Ajax;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Blank_Canvas_Option {

	const OPTION_NAME = '_helloplus_choose_blank_canvas';

	public static function has_chosen_blank_canvas(): bool {
		static $has_chosen_blank_canvas = null;

		if ( null === $has_chosen_blank_canvas ) {
			$has_chosen_blank_canvas = (bool) get_option( self::OPTION_NAME, false );
		}

		return $has_chosen_blank_canvas;
	}

	public function ajax_set_blank_canvas_option() {
		check_ajax_referer( 'blank-canvas-option', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( [ 'message' => __( 'Insufficient permissions.', 'hello-plus' ) ], 403 );
		}

		$value = filter_input( INPUT_POST, 'value', FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE );

		if ( null === $value ) {
			wp_send_json_error( [ 'message' => __( 'Invalid value provided.', 'hello-plus' ) ], 400 );
		}

		update_option( self::OPTION_NAME, $value );

		wp_send_json_success( [ 'message' => __( 'Option updated successfully.', 'hello-plus' ) ] );
	}

	public function __construct() {
		add_action( 'wp_ajax_helloplus_set_blank_canvas_option', [ $this, 'ajax_set_blank_canvas_option' ] );
	}
}
