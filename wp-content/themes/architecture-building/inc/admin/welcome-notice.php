<?php
/**
 * Admin notice for Architecture Building theme.
 *
 * @package ARCHITECTURE_BUILDING
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AJAX handler for dismissing the admin notice.
 */
add_action( 'wp_ajax_architecture_building_dismissed_notice_handler', 'architecture_building_ajax_notice_dismiss_function' );

function architecture_building_ajax_notice_dismiss_function() {
	$nonce = isset( $_POST['wpnonce'] ) ? sanitize_text_field( wp_unslash( $_POST['wpnonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'architecture_building_dismissed_notice_nonce' ) ) {
		wp_send_json_error( 'Invalid nonce' );
		exit;
	}

	if ( isset( $_POST['type'] ) ) {
		$type = sanitize_text_field( wp_unslash( $_POST['type'] ) );
		update_option( 'dismissed-' . $type, true );
		wp_send_json_success( 'Notice dismissed' );
	} else {
		wp_send_json_error( 'Type not set' );
	}
}

/**
 * Display the admin notice.
 */
function architecture_building_custom_admin_notice() {
	if ( ! get_option( 'dismissed-get_started_notice', false ) ) {
		$current_screen   = get_current_screen();
		$theme            = wp_get_theme();
		$theme_name_clean = strtolower( preg_replace( '#[^a-zA-Z]#', '', $theme->get( 'Name' ) ) );
		$wizard_slug      = apply_filters( $theme_name_clean . '_theme_setup_wizard_architecture_building_page_slug', $theme_name_clean . '-wizard' );
		$wizard_screen    = 'appearance_page_' . $wizard_slug;
		$upsell_screen    = 'appearance_page_architecture-building-pro';

		if ( $current_screen && $current_screen->id !== $wizard_screen && $current_screen->id !== $upsell_screen ) {
			?>
			<div class="architecture-building-admin-notice notice notice-info is-dismissible content-install-plugin theme-info-notice" id="architecture-building-dismiss-notice" data-notice="get_started_notice">
				<div class="notice-div">
					<div>
						<p class="theme-name"><?php echo esc_html( $theme->get( 'Name' ) ); ?></p>
						<p><?php esc_html_e( 'For information and detailed instructions, check out our theme documentation.', 'architecture-building' ); ?></p>
					</div>
					<div class="notice-buttons-box">
						<a class="button-primary getstarted" href="<?php echo esc_url( admin_url( 'themes.php?page=architecture-building-pro' ) ); ?>"><?php esc_html_e( 'Theme Information', 'architecture-building' ); ?></a>
						<a class="button-primary livedemo" href="<?php echo esc_url( ARCHITECTURE_BUILDING_LIVE_DEMO ); ?>" target="_blank"><?php esc_html_e( 'Live Demo', 'architecture-building' ); ?></a>
						<a class="button-primary buynow" href="<?php echo esc_url( ARCHITECTURE_BUILDING_BUY_PRO ); ?>" target="_blank"><?php esc_html_e( 'Get Pro Theme', 'architecture-building' ); ?></a>
						<a class="button-primary theme-install" href="<?php echo esc_url( admin_url( 'themes.php?page=' . $wizard_slug ) ); ?>"><?php esc_html_e( 'Demo Importer', 'architecture-building' ); ?></a>
					</div>
				</div>
			</div>
			<?php
		}
	}
}
add_action( 'admin_notices', 'architecture_building_custom_admin_notice' );

/**
 * Reset dismissed notice on theme switch.
 */
add_action( 'after_switch_theme', 'architecture_building_after_switch_theme' );
function architecture_building_after_switch_theme() {
	update_option( 'dismissed-get_started_notice', false );
}

/**
 * Set a transient on theme activation so we can redirect safely on admin_init.
 */
add_action( 'after_switch_theme', 'architecture_building_set_activation_redirect' );
function architecture_building_set_activation_redirect() {
	set_transient( 'architecture_building_activation_redirect', true, 30 );
}

/**
 * Redirect to Get Started page after theme activation.
 * Uses admin_init to ensure headers have not been sent yet.
 */
add_action( 'admin_init', 'architecture_building_redirect_after_activation' );
function architecture_building_redirect_after_activation() {
	if ( ! get_transient( 'architecture_building_activation_redirect' ) ) {
		return;
	}
	delete_transient( 'architecture_building_activation_redirect' );

	// Do not redirect during bulk activations or AJAX requests.
	if ( is_network_admin() || isset( $_GET['activate-multi'] ) || wp_doing_ajax() ) {
		return;
	}

	wp_safe_redirect( admin_url( 'themes.php?page=architecture-building-pro' ) );
	exit;
}
