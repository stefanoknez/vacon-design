<?php
/**
 * Theme functions and definitions
 *
 * @package HelloBiz
 */

use HelloBiz\Theme;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_BIZ_ELEMENTOR_VERSION', '1.2.1' );
define( 'EHP_THEME_SLUG', 'hello-biz' );

define( 'HELLO_BIZ_PATH', get_template_directory() );
define( 'HELLO_BIZ_URL', get_template_directory_uri() );
define( 'HELLO_BIZ_ASSETS_PATH', HELLO_BIZ_PATH . '/assets/' );
define( 'HELLO_BIZ_ASSETS_URL', HELLO_BIZ_URL . '/assets/' );
define( 'HELLO_BIZ_SCRIPTS_PATH', HELLO_BIZ_ASSETS_PATH . 'js/' );
define( 'HELLO_BIZ_SCRIPTS_URL', HELLO_BIZ_ASSETS_URL . 'js/' );
define( 'HELLO_BIZ_STYLE_PATH', HELLO_BIZ_ASSETS_PATH . 'css/' );
define( 'HELLO_BIZ_STYLE_URL', HELLO_BIZ_ASSETS_URL . 'css/' );
define( 'HELLO_BIZ_IMAGES_PATH', HELLO_BIZ_ASSETS_PATH . 'images/' );
define( 'HELLO_BIZ_IMAGES_URL', HELLO_BIZ_ASSETS_URL . 'images/' );
define( 'HELLO_BIZ_STARTER_IMAGES_PATH', HELLO_BIZ_IMAGES_PATH . 'starter-content/' );
define( 'HELLO_BIZ_STARTER_IMAGES_URL', HELLO_BIZ_IMAGES_URL . 'starter-content/' );

if ( ! isset( $content_width ) ) {
	$content_width = 800; // Pixels.
}

// Init the Theme class
require HELLO_BIZ_PATH . '/theme.php';

Theme::instance();

// ===== SECURITY HARDENING =====

// 1. Sakrij WP verziju iz <head> i RSS feeda
remove_action('wp_head', 'wp_generator');
add_filter('the_generator', '__return_empty_string');

// 2. Sakrij Elementor verziju iz HTML-a
add_filter('elementor/frontend/print_google_fonts', '__return_false');
add_action('wp_head', function() {
    remove_action('wp_head', 'elementor_add_version_to_head', 1);
}, 0);

// 3. Zatvori REST API user enumeration
add_filter('rest_endpoints', function($endpoints) {
    if (isset($endpoints['/wp/v2/users'])) {
        unset($endpoints['/wp/v2/users']);
    }
    if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
        unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
    }
    return $endpoints;
});

// 4. Blokiraj author enumeration (?author=1)
add_action('init', function() {
    if (!is_admin() && isset($_GET['author'])) {
        wp_redirect(home_url(), 301);
        exit;
    }
});

// 5. Ukloni nepotrebne <link> tagove iz <head>
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_resource_hints', 2);

// ===== VACON ELITE VISUAL IDENTITY =====

/**
 * Load Google Fonts (Oswald, Inter, Montserrat) and our elite CSS override.
 * Priority 100 ensures we load AFTER Elementor's generated stylesheets.
 */
add_action('wp_enqueue_scripts', function() {
    // Google Fonts — preconnect hints first
    wp_enqueue_style(
        'vacon-google-fonts-preconnect',
        'https://fonts.googleapis.com',
        [],
        null
    );

    // Single combined Google Fonts request (display=swap for performance)
    wp_enqueue_style(
        'vacon-elite-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&family=Oswald:wght@400;500;600&family=Montserrat:wght@300;400;500&display=swap',
        [],
        null
    );

    // Elite CSS override — loaded last (highest cascade priority)
    wp_enqueue_style(
        'vacon-elite',
        HELLO_BIZ_ASSETS_URL . 'css/vacon-elite.css',
        [ 'elementor-frontend' ],
        '4.0.4'
    );

    // Scroll animation JS — deferred, no jQuery dependency
    wp_enqueue_script(
        'vacon-animations',
        HELLO_BIZ_ASSETS_URL . 'js/vacon-animations.js',
        [],
        '4.0.4',
        true  // load in footer
    );

    // Language switcher EN ↔ CG — injected after animations script
    wp_enqueue_script(
        'vacon-lang',
        HELLO_BIZ_ASSETS_URL . 'js/vacon-lang.js',
        [],
        '4.0.4',
        true  // load in footer
    );
}, 100 );

/**
 * Add preconnect for Google Fonts (performance).
 */
add_action('wp_head', function() {
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}, 1);
