<?php
/**
 * Theme functions and definitions
 *
 * @package civil_engineering
 */

// enque files
if ( ! function_exists( 'civil_engineering_enqueue_styles' ) ) :
	/**
	 * Load assets.
	 *
	 * @since 1.0.0
	 */
	function civil_engineering_enqueue_styles() {
		wp_enqueue_style( 'architecture-building-style-parent', get_template_directory_uri() . '/style.css' );
		wp_enqueue_style( 'civil-engineering-style', get_stylesheet_directory_uri() . '/style.css', array( 'architecture-building-style-parent' ), '1.0.0' );
		wp_enqueue_script( 'civil-engineering-custom-js', get_stylesheet_directory_uri() . '/assets/js/theme-script.js', array('jquery'), true);
		
		require get_parent_theme_file_path( 'inc/extra_customization.php' );
		wp_add_inline_style( 'civil-engineering-style',$architecture_building_custom_style );
		require get_theme_file_path( 'inc/extra_customization.php' );
		wp_add_inline_style( 'civil-engineering-style',$architecture_building_custom_style );

		// blocks css
        wp_enqueue_style( 'civil-engineering-block-style', get_theme_file_uri( '/assets/css/blocks.css' ), array( 'civil-engineering-style' ), '1.0' );
	}
endif;
add_action( 'wp_enqueue_scripts', 'civil_engineering_enqueue_styles', 99 );

// theme setup
function civil_engineering_setup() {
	load_theme_textdomain( 'civil-engineering', get_template_directory() . '/languages' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( "responsive-embeds" );
	add_theme_support( "wp-block-styles" );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support('custom-background',array(
		'default-color' => 'ffffff',
	));
	add_image_size( 'civil-engineering-featured-image', 2000, 1200, true );
	add_image_size( 'civil-engineering-thumbnail-avatar', 100, 100, true );

	$GLOBALS['content_width'] = 525;
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'civil-engineering' ),
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
	
}
add_action( 'after_setup_theme', 'civil_engineering_setup' );

// custom header setup
function civil_engineering_custom_header_setup() {
    add_theme_support( 'custom-header', apply_filters( 'civil_engineering_custom_header_args', array(
        'default-image'          => get_parent_theme_file_uri( '/assets/images/header-img-1.png' ),
        'default-text-color'     => 'fff',
        'header-text'            => false,
        'width'                  => 1200,
        'height'                 => 80,
        'flex-width'             => true,
        'flex-height'            => true,
        'wp-head-callback'       => 'architecture_building_header_style',
    ) ) );
}
add_action( 'after_setup_theme', 'civil_engineering_custom_header_setup' );

// widgets
function civil_engineering_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'civil-engineering' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'civil-engineering' ),
		'before_widget' => '<section id="%1$s" class="widget wow zoomIn %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget_container"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Page Sidebar', 'civil-engineering' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your pages and posts', 'civil-engineering' ),
		'before_widget' => '<section id="%1$s" class="widget wow zoomIn %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget_container"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Sidebar 3', 'civil-engineering' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'civil-engineering' ),
		'before_widget' => '<section id="%1$s" class="widget wow zoomIn %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget_container"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'civil-engineering' ),
		'id'            => 'footer-1',
		'description'   => __( 'Add widgets here to appear in your footer.', 'civil-engineering' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'civil-engineering' ),
		'id'            => 'footer-2',
		'description'   => __( 'Add widgets here to appear in your footer.', 'civil-engineering' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 3', 'civil-engineering' ),
		'id'            => 'footer-3',
		'description'   => __( 'Add widgets here to appear in your footer.', 'civil-engineering' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 4', 'civil-engineering' ),
		'id'            => 'footer-4',
		'description'   => __( 'Add widgets here to appear in your footer.', 'civil-engineering' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'civil_engineering_widgets_init' );

// remove sections
function civil_engineering_customize_register() {
  	global $wp_customize;
	$wp_customize->remove_section( 'architecture_building_pro' );
	$wp_customize->remove_setting('architecture_building_slider_content_alignment');
	$wp_customize->remove_control('architecture_building_slider_content_alignment');
	$wp_customize->remove_setting('architecture_building_footer_text');
	$wp_customize->remove_control('architecture_building_footer_text');

	$wp_customize->remove_setting('architecture_building_primary_color');
	$wp_customize->remove_control('architecture_building_primary_color');

	$wp_customize->remove_setting('architecture_building_heading_color');
	$wp_customize->remove_control('architecture_building_heading_color');

	$wp_customize->remove_setting('architecture_building_text_color');
	$wp_customize->remove_control('architecture_building_text_color');

	$wp_customize->remove_setting('architecture_building_footer_bg');
	$wp_customize->remove_control('architecture_building_footer_bg');

	$wp_customize->remove_setting('architecture_building_slider_opacity');
	$wp_customize->remove_control('architecture_building_slider_opacity');

	$wp_customize->remove_setting('architecture_building_slider_overlay');
	$wp_customize->remove_control('architecture_building_slider_overlay');
}
add_action( 'customize_register', 'civil_engineering_customize_register', 11 );

// customizer
function civil_engineering_customize( $wp_customize ) {

	wp_enqueue_style('customizercustom_css', esc_url( get_stylesheet_directory_uri() ). '/assets/css/customizer.css');

	require get_theme_file_path( 'inc/custom-control.php' );

	// pro section
	$wp_customize->add_section('civil_engineering_pro', array(
		'title'    => __('🔒 Unlock Premium Features', 'civil-engineering'),
		'priority' => 1,
	));
	$wp_customize->add_setting('civil_engineering_pro', array(
		'default'           => null,
		'sanitize_callback' => 'sanitize_text_field',
	));
	$wp_customize->add_control(new Civil_Engineering_Pro_Control($wp_customize, 'civil_engineering_pro', array(
		'label'    => __('ENGINEERING PREMIUM', 'civil-engineering'),
		'section'  => 'civil_engineering_pro',
		'settings' => 'civil_engineering_pro',
		'priority' => 1,
	)));

	// slider content alignment
	$wp_customize->add_setting('civil_engineering_slider_content_alignment',array(
        'default' => 'CENTER-ALIGN',
        'sanitize_callback' => 'architecture_building_sanitize_choices'
	));
	$wp_customize->add_control('civil_engineering_slider_content_alignment',array(
		'type' => 'radio',
		'label'     => __('Slider Content Alignment', 'civil-engineering'),
		'section' => 'architecture_building_slider_section',
		'type' => 'select',
		'choices' => array(
			'LEFT-ALIGN' => __('LEFT','civil-engineering'),
            'CENTER-ALIGN' => __('CENTER','civil-engineering'),
            'RIGHT-ALIGN' => __('RIGHT','civil-engineering'),
		),
		'priority'    => 6,
	) );

	$wp_customize->add_setting('civil_engineering_slider_overlay', array(
	    'default' => '#000000',
	    'sanitize_callback' => 'sanitize_hex_color',
	    'transport' => 'refresh',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'civil_engineering_slider_overlay', array(
	    'section' => 'architecture_building_slider_section',
	    'label' => esc_html__('Slider Overlay Color', 'civil-engineering'),
	 	'priority'    => 7,
	)));

	$wp_customize->add_setting('civil_engineering_slider_opacity',array(
        'default' => '0.5',
        'sanitize_callback' => 'architecture_building_sanitize_choices'
	));
	$wp_customize->add_control('civil_engineering_slider_opacity',array(
		'type' => 'radio',
		'label'     => __('Slider Opacity', 'civil-engineering'),
		'section' => 'architecture_building_slider_section',
		'type' => 'select',
		'choices' => array(
			'0' => __('0','civil-engineering'),
			'0.1' => __('0.1','civil-engineering'),
			'0.2' => __('0.2','civil-engineering'),
			'0.3' => __('0.3','civil-engineering'),
			'0.4' => __('0.4','civil-engineering'),
			'0.5' => __('0.5','civil-engineering'),
			'0.6' => __('0.6','civil-engineering'),
			'0.7' => __('0.7','civil-engineering'),
			'0.8' => __('0.8','civil-engineering'),
			'0.9' => __('0.9','civil-engineering'),
			'1' => __('1','civil-engineering')
		),
	) );

	// Contact Us
    $wp_customize->add_section('civil_engineering_contact_us',array(
        'title' => __('Information Section', 'civil-engineering'),
        'priority' => 4,
        'panel' => 'architecture_building_custompage_panel',
    ) );
    $wp_customize->add_setting( 'civil_engineering_contact_heading', array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Civil_Engineering_Customizer_Customcontrol_Section_Heading( $wp_customize, 'civil_engineering_contact_heading', array(
		'label'       => esc_html__( 'Information Section Settings', 'civil-engineering' ),	
		'section'     => 'civil_engineering_contact_us',
		'settings'    => 'civil_engineering_contact_heading',
		'priority'    => 1,
	) ) );
	$wp_customize->add_setting(
		'civil_engineering_contact_enable',
		array(
			'type'                 => 'option',
			'capability'           => 'edit_theme_options',
			'theme_supports'       => '',
			'default'              => '1',
			'transport'            => 'refresh',
			'sanitize_callback'    => 'architecture_building_callback_sanitize_switch',
		)
	);
	$wp_customize->add_control(
		new Civil_Engineering_Customizer_Customcontrol_Switch(
			$wp_customize,
			'civil_engineering_contact_enable',
			array(
				'settings'        => 'civil_engineering_contact_enable',
				'section'         => 'civil_engineering_contact_us',
				'label'           => __( 'Check To show Section', 'civil-engineering' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'civil-engineering' ),
					'off'    => __( 'Off', 'civil-engineering' ),
				),
				'active_callback' => '',
				'priority'   => 1,
			)
		)
	);
	$wp_customize->add_setting('civil_engineering_contact_us_heading',array(
		'default' => '',
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('civil_engineering_contact_us_heading',array(
		'label' => esc_html__('Section Heading','civil-engineering'),
		'section' => 'civil_engineering_contact_us',
		'setting' => 'civil_engineering_contact_us_heading',
		'type'    => 'text',
	));
	$wp_customize->add_setting('civil_engineering_contact_us_text',array(
		'default' => '',
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('civil_engineering_contact_us_text',array(
		'label' => esc_html__('Section Text','civil-engineering'),
		'section' => 'civil_engineering_contact_us',
		'setting' => 'civil_engineering_contact_us_text',
		'type'    => 'text',
	));
	$wp_customize->add_setting('civil_engineering_contact_us_btn_text',array(
		'default' => '',
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('civil_engineering_contact_us_btn_text',array(
		'label' => esc_html__('Button Text','civil-engineering'),
		'section' => 'civil_engineering_contact_us',
		'setting' => 'civil_engineering_contact_us_btn_text',
		'type'    => 'text',
	));
	$wp_customize->add_setting('civil_engineering_contact_us_btn_url',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw'
	));
	$wp_customize->add_control('civil_engineering_contact_us_btn_url',array(
		'label' => esc_html__('Button URL','civil-engineering'),
		'section' => 'civil_engineering_contact_us',
		'setting' => 'civil_engineering_contact_us_btn_url',
		'type'    => 'url',
	));

	// About Us Section
	$wp_customize->add_section( 'civil_engineering_about_us_section' , array(
    	'title'      => __( 'About Us Settings', 'civil-engineering' ),
		'priority'   => 5,
		'panel' => 'architecture_building_custompage_panel',
	) );
	$wp_customize->add_setting( 'civil_engineering_about_heading', array(
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Civil_Engineering_Customizer_Customcontrol_Section_Heading( $wp_customize, 'civil_engineering_about_heading', array(
		'label'       => esc_html__( 'About Us Settings', 'civil-engineering' ),	
		'section'     => 'civil_engineering_about_us_section',
		'settings'    => 'civil_engineering_about_heading',
		'priority'    => 1,
	) ) );
	$wp_customize->add_setting(
		'civil_engineering_about_us_enable',
		array(
			'type'                 => 'option',
			'capability'           => 'edit_theme_options',
			'theme_supports'       => '',
			'default'              => '1',
			'transport'            => 'refresh',
			'sanitize_callback'    => 'architecture_building_callback_sanitize_switch',
		)
	);
	$wp_customize->add_control(
		new Civil_Engineering_Customizer_Customcontrol_Switch(
			$wp_customize,
			'civil_engineering_about_us_enable',
			array(
				'settings'        => 'civil_engineering_about_us_enable',
				'section'         => 'civil_engineering_about_us_section',
				'label'           => __( 'Check To show Section', 'civil-engineering' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'civil-engineering' ),
					'off'    => __( 'Off', 'civil-engineering' ),
				),
				'active_callback' => '',
				'priority'   => 1,
			)
		)
	);
	$wp_customize->add_setting('civil_engineering_about_us_title',array(
		'default' => '',
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('civil_engineering_about_us_title',array(
		'label' => esc_html__('Section Title','civil-engineering'),
		'section' => 'civil_engineering_about_us_section',
		'setting' => 'civil_engineering_about_us_title',
		'type'    => 'text',
	));
	$wp_customize->add_setting('civil_engineering_about_us_settigs',array(
		'sanitize_callback' => 'architecture_building_sanitize_dropdown_pages',
	));
	$wp_customize->add_control('civil_engineering_about_us_settigs',array(
		'type'    => 'dropdown-pages',
		'label' => __('Select Page','civil-engineering'),
		'section' => 'civil_engineering_about_us_section',
	));

	$wp_customize->add_setting('civil_engineering_footer_text',array(
		'default'	=> 'Civil Engineering WordPress Theme',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('civil_engineering_footer_text',array(
		'label'	=> esc_html__('Copyright Text','civil-engineering'),
		'section'	=> 'architecture_building_footer_copyright',
		'type'		=> 'textarea'
	));

	$wp_customize->add_setting('civil_engineering_primary_color', array(
	    'default' => '#fab915',
	    'sanitize_callback' => 'sanitize_hex_color',
	    'transport' => 'refresh',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'civil_engineering_primary_color', array(
	    'section' => 'colors',
	    'label' => esc_html__('Theme Color', 'civil-engineering'),
	 
	)));

	$wp_customize->add_setting('civil_engineering_heading_color', array(
	    'default' => '#000000',
	    'sanitize_callback' => 'sanitize_hex_color',
	    'transport' => 'refresh',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'civil_engineering_heading_color', array(
	    'section' => 'colors',
	    'label' => esc_html__('Theme Heading Color', 'civil-engineering'),
	 
	)));

	$wp_customize->add_setting('civil_engineering_text_color', array(
	    'default' => '#666666',
	    'sanitize_callback' => 'sanitize_hex_color',
	    'transport' => 'refresh',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'civil_engineering_text_color', array(
	    'section' => 'colors',
	    'label' => esc_html__('Theme Text Color', 'civil-engineering'),
	 
	)));

	$wp_customize->add_setting('civil_engineering_footer_bg', array(
	    'default' => '#000000',
	    'sanitize_callback' => 'sanitize_hex_color',
	    'transport' => 'refresh',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'civil_engineering_footer_bg', array(
	    'section' => 'colors',
	    'label' => esc_html__('Header/Footer Bg color', 'civil-engineering'),
	)));
}
add_action( 'customize_register', 'civil_engineering_customize' );

// comments
function civil_engineering_enqueue_comments_reply() {
  if( is_singular() && comments_open() && ( get_option( 'thread_comments' ) == 1) ) {
    // Load comment-reply.js (into footer)
    wp_enqueue_script( 'comment-reply', '/wp-includes/js/comment-reply.min.js', array(), false, true );
  }
}
add_action(  'wp_enqueue_scripts', 'civil_engineering_enqueue_comments_reply' );

// Footer Text
function civil_engineering_copyright_link() {
    $civil_engineering_footer_text = get_theme_mod('civil_engineering_footer_text', esc_html__('Civil Engineering WordPress Theme', 'civil-engineering'));
    $civil_engineering_credit_link = esc_url('https://www.ovationthemes.com/products/free-engineering-wordpress-theme');

    echo '<a href="' . $civil_engineering_credit_link . '" target="_blank">' . esc_html($civil_engineering_footer_text) . '<span class="footer-copyright">' . esc_html__(' By Ovation Themes', 'civil-engineering') . '</span></a>';
}

/* Pro control */
if (class_exists('WP_Customize_Control') && !class_exists('Civil_Engineering_Pro_Control')):
    class Civil_Engineering_Pro_Control extends WP_Customize_Control{

    public function render_content(){?>
        <div style="background: linear-gradient(135deg, #2B136B 0%, #A47AE2 100%); padding: 20px; border-radius: 8px; text-align: center; color: #fff;">
			
			<h3 style="margin-top: 0; color: #fff;">
				<?php esc_html_e('Unlock Advanced Features', 'architecture-building'); ?>
			</h3>
	
			<p style="margin: 15px 0;">
				<?php esc_html_e('Upgrade to Pro to get:', 'architecture-building'); ?>
			</p>
	
			<ul style="list-style: none; padding: 0; text-align: left; max-width: 300px; margin: 20px auto;">
				<li>✓ <?php esc_html_e('12+ Premium Header Layouts', 'architecture-building'); ?></li>
				<li>✓ <?php esc_html_e('Advanced Footer Builder', 'architecture-building'); ?></li>
				<li>✓ <?php esc_html_e('Typography Controls', 'architecture-building'); ?></li>
				<li>✓ <?php esc_html_e('WooCommerce Styling Options', 'architecture-building'); ?></li>
				<li>✓ <?php esc_html_e('Priority Support', 'architecture-building'); ?></li>
				<li>✓ <?php esc_html_e('One-Click Demo Import', 'architecture-building'); ?></li>
			</ul>
	
			<a href="<?php echo esc_url(admin_url('themes.php?page=architecture-building-pro')); ?>"
				style="display:inline-block;background:#fff;color:#667eea;padding:12px 30px;text-decoration:none;border-radius:4px;font-weight:600;margin:10px 5px;">
				<?php esc_html_e('View All Features', 'architecture-building'); ?>
			</a>
	
			<a href="<?php echo esc_url( ARCHITECTURE_BUILDING_BUY_PRO ); ?>" target="_blank"
				style="display:inline-block;background:#ffc107;color:#333;padding:12px 30px;text-decoration:none;border-radius:4px;font-weight:600;margin:10px 5px;">
				<?php esc_html_e('Upgrade Now 🚀', 'architecture-building'); ?>
			</a>

			<a href="<?php echo esc_url( ARCHITECTURE_BUILDING_BUNDLE_LINK ); ?>" target="_blank"
				style="display: inline-block; background: #28a745; color: #fff; padding: 12px 30px; text-decoration: none; border-radius: 4px; font-weight: 600; margin: 10px 5px;">
				<?php esc_html_e('WordPress Bundle 🎁', 'architecture-building'); ?>
			</a>
	
		</div>
    <?php } }
endif;