<?php
/**
 * Architecture Building functions and definitions
 *
 * @subpackage Architecture Building
 * @since 1.0
 */


// theme setup
function architecture_building_setup() {
	add_theme_support( 'woocommerce' );
	add_theme_support( "align-wide" );
	add_theme_support( "wp-block-styles" );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( "responsive-embeds" );
	add_theme_support( 'title-tag' );
	add_theme_support('custom-background',array(
		'default-color' => 'ffffff',
	));
	add_image_size( 'architecture-building-featured-image', 2000, 1200, true );
	add_image_size( 'architecture-building-thumbnail-avatar', 100, 100, true );

	define( 'THEME_DIR', dirname( __FILE__ ) );

	load_theme_textdomain( 'architecture-building', get_template_directory() . '/languages' );

	$GLOBALS['content_width'] = 525;
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'architecture-building' ),
	) );

	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
		'flex-height' => true,
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array('image','video','gallery','audio','quote',) );
	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( array( 'assets/css/editor-style.css' ) );

		if ( ! defined( 'ARCHITECTURE_BUILDING_SUPPORT' ) ) {
	define('ARCHITECTURE_BUILDING_SUPPORT',__('https://wordpress.org/support/theme/architecture-building/','architecture-building'));
	}
	if ( ! defined( 'ARCHITECTURE_BUILDING_REVIEW' ) ) {
	define('ARCHITECTURE_BUILDING_REVIEW',__('https://wordpress.org/support/theme/architecture-building/reviews/','architecture-building'));
	}
	if ( ! defined( 'ARCHITECTURE_BUILDING_LIVE_DEMO' ) ) {
	define('ARCHITECTURE_BUILDING_LIVE_DEMO',__('https://trial.ovationthemes.com/architecture-building/','architecture-building'));
	}
	if ( ! defined( 'ARCHITECTURE_BUILDING_BUY_PRO' ) ) {
	define('ARCHITECTURE_BUILDING_BUY_PRO',__('https://www.ovationthemes.com/products/architecture-building-wordpress-theme','architecture-building'));
	}
	if ( ! defined( 'ARCHITECTURE_BUILDING_PRO_DOC' ) ) {
	define('ARCHITECTURE_BUILDING_PRO_DOC',__('https://trial.ovationthemes.com/docs/ot-architecture-building-pro-doc/','architecture-building'));
	}
	if ( ! defined( 'ARCHITECTURE_BUILDING_FREE_DOC' ) ) {
	define('ARCHITECTURE_BUILDING_FREE_DOC',__('https://trial.ovationthemes.com/docs/ot-architecture-building-free-doc/','architecture-building'));
	}
	if ( ! defined( 'ARCHITECTURE_BUILDING_THEME_NAME' ) ) {
	define('ARCHITECTURE_BUILDING_THEME_NAME',__('Premium Architecture Theme','architecture-building'));
	}
	if ( ! defined( 'ARCHITECTURE_BUILDING_BUNDLE_LINK' ) ) {
	define('ARCHITECTURE_BUILDING_BUNDLE_LINK',__('https://www.ovationthemes.com/products/wordpress-bundle','architecture-building'));
	}
	require get_template_directory() . '/inc/dashboard/dashboard-settings.php';
	require get_template_directory() . '/inc/admin/theme-upsell.php';
}
add_action( 'after_setup_theme', 'architecture_building_setup' );

//woocommerce//
//shop page no of columns
function architecture_building_woocommerce_loop_columns() {
	
	$retrun = get_theme_mod( 'architecture_building_archieve_item_columns', 3 );
    
    return $retrun;
}
add_filter( 'loop_shop_columns', 'architecture_building_woocommerce_loop_columns' );
function architecture_building_woocommerce_products_per_page() {

		$retrun = get_theme_mod( 'architecture_building_archieve_shop_perpage', 6 );
    
    return $retrun;
}
add_filter( 'loop_shop_per_page', 'architecture_building_woocommerce_products_per_page' );
// related products
function architecture_building_related_products_args( $args ) {
    $defaults = array(
        'posts_per_page' => get_theme_mod( 'architecture_building_related_shop_perpage', 3 ),
        'columns'        => get_theme_mod( 'architecture_building_related_item_columns', 3),
    );

    $args = wp_parse_args( $defaults, $args );

    return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'architecture_building_related_products_args' );

// breadcrumb seperator
function architecture_building_woocommerce_breadcrumb_separator($architecture_building_defaults) {
    $architecture_building_separator = get_theme_mod('woocommerce_breadcrumb_separator', ' / ');

    // Update the separator
    $architecture_building_defaults['delimiter'] = $architecture_building_separator;

    return $architecture_building_defaults;
}
add_filter('woocommerce_breadcrumb_defaults', 'architecture_building_woocommerce_breadcrumb_separator');

//add animation class
if ( class_exists( 'WooCommerce' ) ) { 
	add_filter('post_class', function($architecture_building_classes, $class, $product_id) {
	    if( is_shop() || is_product_category() ){
	        
	        $architecture_building_classes = array_merge(['wow','zoomIn'], $architecture_building_classes);
	    }
	    return $architecture_building_classes;
	},10,3);
}
//woocommerce-end//

// Admin scripts and styles
function architecture_building_enqueue_admin_script( $hook ) {
	wp_enqueue_style(
		'architecture-building-admin-style',
		get_template_directory_uri() . '/assets/css/admin-style.css'
	);
	wp_enqueue_script(
		'architecture-building-admin-js',
		get_theme_file_uri( '/assets/js/architecture-building-admin.js' ),
		array( 'jquery' ),
		'1.0.0',
		true
	);
	wp_localize_script(
		'architecture-building-admin-js',
		'architecture_building_localize',
		array(
			'ajax_url'      => admin_url( 'admin-ajax.php' ),
			'nonce'         => wp_create_nonce( 'architecture_building_dismissed_notice_nonce' ),
			'dismiss_nonce' => wp_create_nonce( 'architecture_building_dismissed_notice_nonce' ),
		)
	);
}
add_action( 'admin_enqueue_scripts', 'architecture_building_enqueue_admin_script' );

// tag count
function architecture_building_display_post_tag_count() {
    $architecture_building_tags = get_the_tags();
    $architecture_building_tag_count = ($architecture_building_tags) ? count($architecture_building_tags) : 0;
    $architecture_building_tag_text = ($architecture_building_tag_count === 1) ? 'tag' : 'tags';
    echo $architecture_building_tag_count . ' ' . $architecture_building_tag_text;
}

// Date formatting
function architecture_building_display_shop_date() {
    // Get the date type option
    $architecture_building_date_type = get_theme_mod( 'architecture_building_date_type', 'published' );

    // Determine the date to display based on the type
    if ( $architecture_building_date_type === 'modified' && get_the_modified_time( 'U' ) !== get_the_time( 'U' ) ) {
        $architecture_building_date_to_display = get_the_modified_date( get_option( 'date_format' ) );
    } else {
        $architecture_building_date_to_display = get_the_date( get_option( 'date_format' ) );
    }

    // Output the date HTML

    echo esc_html( $architecture_building_date_to_display );
}

//media post format
function architecture_building_get_media($architecture_building_type = array()){
	$architecture_building_content = apply_filters( 'the_content', get_the_content() );
  	$output = false;

  // Only get media from the content if a playlist isn't present.
  if ( false === strpos( $architecture_building_content, 'wp-playlist-script' ) ) {
    $output = get_media_embedded_in_content( $architecture_building_content, $architecture_building_type );
    return $output;
  }
}

// front page template
function architecture_building_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template',  'architecture_building_front_page_template' );

// excerpt function
function architecture_building_custom_excerpt() {
    $architecture_building_excerpt = get_the_excerpt();
    $architecture_building_plain_text_excerpt = wp_strip_all_tags($architecture_building_excerpt);
    
    // Get dynamic word limit from theme mod
    $architecture_building_word_limit = esc_attr(get_theme_mod('architecture_building_post_excerpt', '30'));
    
    // Limit the number of words
    $architecture_building_limited_excerpt = implode(' ', array_slice(explode(' ', $architecture_building_plain_text_excerpt), 0, $architecture_building_word_limit));

    echo esc_html($architecture_building_limited_excerpt);
}

// typography
function architecture_building_fonts_scripts() {
	$architecture_building_headings_font = esc_html(get_theme_mod('architecture_building_headings_text'));
	$architecture_building_body_font = esc_html(get_theme_mod('architecture_building_body_text'));

	if( $architecture_building_headings_font ) {
		wp_enqueue_style( 'architecture-building-headings-fonts', '//fonts.googleapis.com/css?family='. $architecture_building_headings_font );
	} else {
		wp_enqueue_style( 'architecture-building-playfair-sans', '//fonts.googleapis.com/css?family=Playfair Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900');
	}
	if( $architecture_building_body_font ) {
		wp_enqueue_style( 'architecture-building-body-fonts', '//fonts.googleapis.com/css?family='. $architecture_building_body_font );
	} else {
		wp_enqueue_style( 'architecture-building-jost-body', '//fonts.googleapis.com/css?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900');
	}
}
add_action( 'wp_enqueue_scripts', 'architecture_building_fonts_scripts' );

// Footer Text
function architecture_building_copyright_link() {
    $architecture_building_footer_text = get_theme_mod('architecture_building_footer_text', esc_html__('Architecture Building WordPress Theme', 'architecture-building'));
    $architecture_building_credit_link = esc_url('https://www.ovationthemes.com/products/free-architecture-wordpress-theme');

    echo '<a href="' . $architecture_building_credit_link . '" target="_blank">' . esc_html($architecture_building_footer_text) . '<span class="footer-copyright">' . esc_html__(' By Ovation Themes', 'architecture-building') . '</span></a>';
}

// custom sanitizations
// dropdown
function architecture_building_sanitize_dropdown_pages( $page_id, $setting ) {
	$page_id = absint( $page_id );
	return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}
// slider custom control
if ( ! function_exists( 'architecture_building_sanitize_integer' ) ) {
	function architecture_building_sanitize_integer( $input ) {
		return (int) $input;
	}
}
// range contol
function architecture_building_sanitize_number_absint( $number, $setting ) {

	// Ensure input is an absolute integer.
	$number = absint( $number );

	// Get the input attributes associated with the setting.
	$atts = $setting->manager->get_control( $setting->id )->input_attrs;

	// Get minimum number in the range.
	$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );

	// Get maximum number in the range.
	$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );

	// Get step.
	$step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );

	// If the number is within the valid range, return it; otherwise, return the default
	return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
}
// select post page
function architecture_building_sanitize_select( $input, $setting ){
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control( $setting->id )->choices;
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}
// toggle switch
function architecture_building_callback_sanitize_switch( $value ) {
	// Switch values must be equal to 1 of off. Off is indicator and should not be translated.
	return ( ( isset( $value ) && $value == 1 ) ? 1 : 'off' );
}
//choices control
function architecture_building_sanitize_choices( $input, $setting ) {
    global $wp_customize;
    $control = $wp_customize->get_control( $setting->id );
    if ( array_key_exists( $input, $control->choices ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}
// phone number
function architecture_building_sanitize_phone_number( $phone ) {
  return preg_replace( '/[^\d+]/', '', $phone );
}
// Sanitize Sortable control.
function architecture_building_sanitize_sortable( $val, $setting ) {
	if ( is_string( $val ) || is_numeric( $val ) ) {
		return array(
			esc_attr( $val ),
		);
	}
	$sanitized_value = array();
	foreach ( $val as $item ) {
		if ( isset( $setting->manager->get_control( $setting->id )->choices[ $item ] ) ) {
			$sanitized_value[] = esc_attr( $item );
		}
	}
	return $sanitized_value;
}

// widgets
function architecture_building_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'architecture-building' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'architecture-building' ),
		'before_widget' => '<section id="%1$s" class="widget wow zoomIn %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget_container"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Page Sidebar', 'architecture-building' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your pages and posts', 'architecture-building' ),
		'before_widget' => '<section id="%1$s" class="widget wow zoomIn %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget_container"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Sidebar 3', 'architecture-building' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'architecture-building' ),
		'before_widget' => '<section id="%1$s" class="widget wow zoomIn %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget_container"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'architecture-building' ),
		'id'            => 'footer-1',
		'description'   => __( 'Add widgets here to appear in your footer.', 'architecture-building' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'architecture-building' ),
		'id'            => 'footer-2',
		'description'   => __( 'Add widgets here to appear in your footer.', 'architecture-building' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 3', 'architecture-building' ),
		'id'            => 'footer-3',
		'description'   => __( 'Add widgets here to appear in your footer.', 'architecture-building' ),
		'before_widget' => '<section id="%1$s" class="widget wow %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 4', 'architecture-building' ),
		'id'            => 'footer-4',
		'description'   => __( 'Add widgets here to appear in your footer.', 'architecture-building' ),
		'before_widget' => '<section id="%1$s" class="widget wow %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'architecture_building_widgets_init' );

//Enqueue scripts and styles.
function architecture_building_scripts() {

	require_once get_theme_file_path( 'inc/wptt-webfont-loader.php' );

	wp_enqueue_style(
		'roboto',
		wptt_get_webfont_url( 'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap' ),
		array(),
		'1.0'
	);

	wp_enqueue_style(
		'raleway',
		wptt_get_webfont_url( 'https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap' ),
		array(),
		'1.0'
	);

	//Bootstarp
	wp_enqueue_style( 'bootstrap-style', get_template_directory_uri().'/assets/css/bootstrap.css' );

	// Theme stylesheet.
	wp_enqueue_style( 'architecture-building-style', get_stylesheet_uri() );

	//rtl-support
	wp_style_add_data( 'architecture-building-style', 'rtl', 'replace' );

	// Theme Customize CSS.
	require get_parent_theme_file_path( 'inc/extra_customization.php' );
	wp_add_inline_style( 'architecture-building-style',$architecture_building_custom_style );

	//font-awesome
	wp_enqueue_style( 'font-awesome-style', get_template_directory_uri().'/assets/css/fontawesome-all.css' );

	//Owl Carousel CSS
	wp_enqueue_style( 'owl.carousel-style', get_template_directory_uri().'/assets/css/owl.carousel.css' );

	// Block Style
	wp_enqueue_style( 'architecture-building-block-style', get_template_directory_uri().'/assets/css/blocks.css' );

	//Custom JS
	wp_enqueue_script( 'architecture-building-custom.js', get_theme_file_uri( '/assets/js/theme-script.js' ), array( 'jquery' ), true );

	//Nav Focus JS
	wp_enqueue_script( 'architecture-building-navigation-focus', get_theme_file_uri( '/assets/js/navigation-focus.js' ), array( 'jquery' ), true );

	//Bootstarp JS
	wp_enqueue_script( 'bootstrap-js', get_theme_file_uri( '/assets/js/bootstrap.js' ), array( 'jquery' ),true );

	//Owl Carousel JS
	wp_enqueue_script( 'owl.carousel-js', get_theme_file_uri( '/assets/js/owl.carousel.js' ), array( 'jquery' ),true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if (get_option('architecture_building_animation_enable', false) !== 'off') {
		//wow.js
		wp_enqueue_script( 'architecture-building-wow-js', get_theme_file_uri( '/assets/js/wow.js' ), array( 'jquery' ), true );

		//animate.css
		wp_enqueue_style( 'architecture-building-animate-css', get_template_directory_uri().'/assets/css/animate.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'architecture_building_scripts' );

// Enqueue editor styles for Gutenberg
function architecture_building_block_editor_styles() {
	// Block styles.
	wp_enqueue_style( 'architecture-building-block-editor-style', trailingslashit( get_template_directory_uri() ) . '/assets/css/editor-blocks.css' );
}
add_action( 'enqueue_block_editor_assets', 'architecture_building_block_editor_styles' );

# Load scripts and styles.(fontawesome)
add_action( 'customize_controls_enqueue_scripts', 'architecture_building_customize_controls_register_scripts' );
function architecture_building_customize_controls_register_scripts() {
	wp_enqueue_style( 'architecture-building-ctypo-customize-controls-style', trailingslashit( esc_url(get_template_directory_uri()) ) . '/assets/css/customize-controls.css' );
}

// enque files
require get_parent_theme_file_path( '/inc/custom-header.php' );
require get_parent_theme_file_path( '/inc/template-tags.php' );
require get_parent_theme_file_path( '/inc/template-functions.php' );
require get_parent_theme_file_path( '/inc/customizer.php' );
require get_parent_theme_file_path( '/inc/typography.php' );
require get_parent_theme_file_path( '/inc/breadcrumb.php' );
require_once get_template_directory() . '/inc/admin/welcome-notice.php';
require get_parent_theme_file_path( 'inc/sortable/sortable_control.php' );

add_action( 'admin_bar_menu', 'architecture_building_add_upgrade_button', 100 );

function architecture_building_add_upgrade_button( $architecture_building_wp_admin_bar ) {

    $architecture_building_theme_name = wp_get_theme()->get( 'Name' );

    $architecture_building_args = array(
        'id'    => 'architecture_building_upgrade',
        'title' => '<span style="color:#fff;font-weight:600;">
            🚀 Upgrade to ' . esc_html( $architecture_building_theme_name ) . ' Pro - 20% OFF 
            <span style="background:#ff5722;color:#fff;padding:2px 8px;border-radius:3px;margin-left:6px;">
                Buy Now
            </span>
        </span>',
        'href'  => esc_url( ARCHITECTURE_BUILDING_BUY_PRO ),
        'meta'  => array(
            'class'  => 'architecture-building-upgrade-btn',
            'title'  => 'Upgrade to Pro',
            'target' => '_blank'
        )
    );

    $architecture_building_wp_admin_bar->add_node( $architecture_building_args );
}