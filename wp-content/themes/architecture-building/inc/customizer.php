<?php
/**
 * Architecture Building: Customizer
 *
 * @subpackage Architecture Building
 * @since 1.0
 */

function architecture_building_customize_register( $wp_customize ) {

	wp_enqueue_style('customizercustom_css', esc_url( get_template_directory_uri() ). '/assets/css/customizer.css');

	// fontawesome icon-picker

	load_template( trailingslashit( get_template_directory() ) . '/inc/icon-picker.php' );

	// Add custom control.
  	require get_parent_theme_file_path( 'inc/switch/control_switch.php' );

  	require get_parent_theme_file_path( 'inc/custom-control.php' );

  	//Register the sortable control type.
	$wp_customize->register_control_type( 'Architecture_Building_Control_Sortable' );

  	// Add homepage customizer file
  	require get_template_directory() . '/inc/customizer-home-page.php';

  	add_action( 'customize_controls_enqueue_scripts', function() {
    	wp_enqueue_script(
	        'architecture-building-customizer-reset',
	        get_theme_file_uri() . '/assets/js/color-reset.js', // Ensure the JS file exists in your theme
	        array( 'customize-controls', 'jquery' ),
	        '1.0',
	        true
    	);
	} );

  		//pro section
 	$wp_customize->add_section('architecture_building_pro', array(
        'title'    => __('🔒 Unlock Premium Features', 'architecture-building'),
        'priority' => 1,
    ));
    $wp_customize->add_setting('architecture_building_pro', array(
        'default'           => null,
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control(new Architecture_Building_Pro_Control($wp_customize, 'architecture_building_pro', array(
        'label'    => __('ARCHITECTURE BUILDING PREMIUM', 'architecture-building'),
        'section'  => 'architecture_building_pro',
        'settings' => 'architecture_building_pro',
        'priority' => 1,
    )));

    //logo
    $wp_customize->add_setting('architecture_building_logo_title',
		array(
			'type'                 => 'option',
			'capability'           => 'edit_theme_options',
			'theme_supports'       => '',
			'default'              => '1',
			'transport'            => 'refresh',
			'sanitize_callback'    => 'architecture_building_callback_sanitize_switch',
		)
	);
	$wp_customize->add_control(new Architecture_Building_Customizer_Customcontrol_Switch(
			$wp_customize,
			'architecture_building_logo_title',
			array(
				'settings'        => 'architecture_building_logo_title',
				'section'         => 'title_tagline',
				'label'           => __( 'Show Site Title', 'architecture-building' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
			)
		)
	);
	$wp_customize->add_setting('architecture_building_site_title_fontsize',array(
		'default'=> 25,
		'transport' => 'refresh',
		'sanitize_callback' => 'architecture_building_sanitize_integer'
	));
	$wp_customize->add_control(new Architecture_Building_Slider_Custom_Control( $wp_customize, 'architecture_building_site_title_fontsize',array(
		'label' => esc_html__( 'Site Title font size','architecture-building' ),
		'section'=> 'title_tagline',
		'settings'=>'architecture_building_site_title_fontsize',
		'input_attrs' => array(
			'reset'			   => 25,
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
	)));
	$wp_customize->add_setting('architecture_building_logo_text',
		array(
			'type'                 => 'option',
			'capability'           => 'edit_theme_options',
			'theme_supports'       => '',
			'default'              => 'off',
			'transport'            => 'refresh',
			'sanitize_callback'    => 'architecture_building_callback_sanitize_switch',
		)
	);
	$wp_customize->add_control(new Architecture_Building_Customizer_Customcontrol_Switch(
			$wp_customize,
			'architecture_building_logo_text',
			array(
				'settings'        => 'architecture_building_logo_text',
				'section'         => 'title_tagline',
				'label'           => __( 'Show Site Tagline', 'architecture-building' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
			)
		)
	);
	$wp_customize->add_setting('architecture_building_site_tagline_fontsize',array(
		'default'=> 15,
		'transport' => 'refresh',
		'sanitize_callback' => 'architecture_building_sanitize_integer'
	));
	$wp_customize->add_control(new Architecture_Building_Slider_Custom_Control( $wp_customize, 'architecture_building_site_tagline_fontsize',array(
		'label' => esc_html__( 'Site Tagline font size','architecture-building' ),
		'section'=> 'title_tagline',
		'settings'=>'architecture_building_site_tagline_fontsize',
		'input_attrs' => array(
			'reset'			   => 15,
            'step'             => 1,
			'min'              => 0,
			'max'              => 30,
        ),
	)));
    $wp_customize->add_setting('architecture_building_logo_max_height',array(
		'default'=> '100',
		'transport' => 'refresh',
		'sanitize_callback' => 'architecture_building_sanitize_integer'
	));
	$wp_customize->add_control(new Architecture_Building_Slider_Custom_Control( $wp_customize, 'architecture_building_logo_max_height',array(
		'label'	=> esc_html__('Logo Width','architecture-building'),
		'section'=> 'title_tagline',
		'settings'=>'architecture_building_logo_max_height',
		'input_attrs' => array(
			'reset' 		   =>100,
            'step'             => 1,
			'min'              => 0,
			'max'              => 250,
        ),
        'priority'=> 9,
	)));

	//colors
	if ( $wp_customize->get_section( 'colors' ) ) {
        $wp_customize->get_section( 'colors' )->title = __( 'Global Colors', 'architecture-building' );
        $wp_customize->get_section( 'colors' )->priority = 2;
    }

    $wp_customize->add_setting( 'architecture_building_global_color_heading', array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_global_color_heading', array(
			'label'       => esc_html__( 'Global Colors', 'architecture-building' ),
			'section'     => 'colors',
			'settings'    => 'architecture_building_global_color_heading',
			'priority'       => 1,

	) ) );

	$wp_customize->add_setting( 'architecture_building_reset_colors', array(
	    'default'           => '',
	    'sanitize_callback' => 'sanitize_text_field',
	    'transport'         => 'postMessage', 
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'architecture_building_reset_colors', array(
	    'label'       => esc_html__( 'Reset Colors', 'architecture-building' ),
	    'section'     => 'colors',
	    'settings'    => 'architecture_building_reset_colors',
	    'type'        => 'button',
	    'input_attrs' => array(
	        'class' => 'button color-reset-btn',
	        'onclick' => 'resetColorsToDefault();', // Attach custom JS function
	    ),
	    'priority' => '2'
	) ) );

    $wp_customize->add_setting('architecture_building_primary_color', array(
	    'default' => '#fbb908',
	    'sanitize_callback' => 'sanitize_hex_color',
	    'transport' => 'refresh',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'architecture_building_primary_color', array(
	    'section' => 'colors',
	    'label' => esc_html__('Theme Color', 'architecture-building'),
	 
	)));

	$wp_customize->add_setting('architecture_building_heading_color', array(
	    'default' => '#042038',
	    'sanitize_callback' => 'sanitize_hex_color',
	    'transport' => 'refresh',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'architecture_building_heading_color', array(
	    'section' => 'colors',
	    'label' => esc_html__('Theme Heading Color', 'architecture-building'),
	 
	)));

	$wp_customize->add_setting('architecture_building_text_color', array(
	    'default' => '#8b8b8b',
	    'sanitize_callback' => 'sanitize_hex_color',
	    'transport' => 'refresh',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'architecture_building_text_color', array(
	    'section' => 'colors',
	    'label' => esc_html__('Theme Text Color', 'architecture-building'),
	 
	)));

	$wp_customize->add_setting('architecture_building_primary_fade', array(
	    'default' => '#fff9e8',
	    'sanitize_callback' => 'sanitize_hex_color',
	    'transport' => 'refresh',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'architecture_building_primary_fade', array(
	    'section' => 'colors',
	    'label' => esc_html__('theme Color Light', 'architecture-building'),
	 
	)));

	$wp_customize->add_setting('architecture_building_footer_bg', array(
	    'default' => '#042038',
	    'sanitize_callback' => 'sanitize_hex_color',
	    'transport' => 'refresh',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'architecture_building_footer_bg', array(
	    'section' => 'colors',
	    'label' => esc_html__('Header/Footer Bg color', 'architecture-building'),
	)));

	$wp_customize->add_setting('architecture_building_post_bg', array(
	    'default' => '#ffffff',
	    'sanitize_callback' => 'sanitize_hex_color',
	    'transport' => 'refresh',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'architecture_building_post_bg', array(
	    'section' => 'colors',
	    'label' => esc_html__('sidebar/Blog Post Bg color', 'architecture-building'),
	)));

	// typography
	$wp_customize->add_section( 'architecture_building_typography_settings', array(
		'title'       => __( 'Typography Settings', 'architecture-building' ),
		'priority'       => 3,
	) );
	$font_choices = array(
		'' => 'Select',
		'Source Sans Pro:400,700,400italic,700italic' => 'Source Sans Pro',
		'Open Sans:400italic,700italic,400,700' => 'Open Sans',
		'Oswald:400,700' => 'Oswald',
		'Playfair Display:400,700,400italic' => 'Playfair Display',
		'Montserrat:400,700' => 'Montserrat',
		'Raleway:400,700' => 'Raleway',
		'Droid Sans:400,700' => 'Droid Sans',
		'Lato:400,700,400italic,700italic' => 'Lato',
		'Arvo:400,700,400italic,700italic' => 'Arvo',
		'Lora:400,700,400italic,700italic' => 'Lora',
		'Merriweather:400,300italic,300,400italic,700,700italic' => 'Merriweather',
		'Oxygen:400,300,700' => 'Oxygen',
		'PT Serif:400,700' => 'PT Serif',
		'PT Sans:400,700,400italic,700italic' => 'PT Sans',
		'PT Sans Narrow:400,700' => 'PT Sans Narrow',
		'Cabin:400,700,400italic' => 'Cabin',
		'Fjalla One:400' => 'Fjalla One',
		'Francois One:400' => 'Francois One',
		'Josefin Sans:400,300,600,700' => 'Josefin Sans',
		'Libre Baskerville:400,400italic,700' => 'Libre Baskerville',
		'Arimo:400,700,400italic,700italic' => 'Arimo',
		'Ubuntu:400,700,400italic,700italic' => 'Ubuntu',
		'Bitter:400,700,400italic' => 'Bitter',
		'Droid Serif:400,700,400italic,700italic' => 'Droid Serif',
		'Roboto:400,400italic,700,700italic' => 'Roboto',
		'Open Sans Condensed:700,300italic,300' => 'Open Sans Condensed',
		'Roboto Condensed:400italic,700italic,400,700' => 'Roboto Condensed',
		'Roboto Slab:400,700' => 'Roboto Slab',
		'Yanone Kaffeesatz:400,700' => 'Yanone Kaffeesatz',
		'Rokkitt:400' => 'Rokkitt',
	);
	$wp_customize->add_setting( 'architecture_building_section_typo_heading', array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_section_typo_heading', array(
		'label'       => esc_html__( 'Typography Settings', 'architecture-building' ),
		'section'     => 'architecture_building_typography_settings',
		'settings'    => 'architecture_building_section_typo_heading',
	) ) );
	$wp_customize->add_setting( 'architecture_building_headings_text', array(
		'sanitize_callback' => 'architecture_building_sanitize_fonts',
	));
	$wp_customize->add_control( 'architecture_building_headings_text', array(
		'type' => 'select',
		'description' => __('Select your suitable font for the headings.', 'architecture-building'),
		'section' => 'architecture_building_typography_settings',
		'choices' => $font_choices
	));
	$wp_customize->add_setting( 'architecture_building_body_text', array(
		'sanitize_callback' => 'architecture_building_sanitize_fonts'
	));
	$wp_customize->add_control( 'architecture_building_body_text', array(
		'type' => 'select',
		'description' => __( 'Select your suitable font for the body.', 'architecture-building' ),
		'section' => 'architecture_building_typography_settings',
		'choices' => $font_choices
	) );

	// Theme General Settings
    $wp_customize->add_section('architecture_building_theme_settings',array(
        'title' => __('Theme General Settings', 'architecture-building'),
        'priority' => 3,
    ) );
    $wp_customize->add_setting( 'architecture_building_section_sticky_heading', array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_section_sticky_heading', array(
		'label'       => esc_html__( 'Sticky Header Settings', 'architecture-building' ),
		'section'     => 'architecture_building_theme_settings',
		'settings'    => 'architecture_building_section_sticky_heading',
	) ) );
    $wp_customize->add_setting(
		'architecture_building_sticky_header',
		array(
			'type'                 => 'option',
			'capability'           => 'edit_theme_options',
			'theme_supports'       => '',
			'default'              => 'off',
			'transport'            => 'refresh',
			'sanitize_callback'    => 'architecture_building_callback_sanitize_switch',
		)
	);
    $wp_customize->add_control(
		new Architecture_Building_Customizer_Customcontrol_Switch(
			$wp_customize,
			'architecture_building_sticky_header',
			array(
				'settings'        => 'architecture_building_sticky_header',
				'section'         => 'architecture_building_theme_settings',
				'label'           => __( 'Show Sticky Header', 'architecture-building' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
			)
		)
	);
	$wp_customize->add_setting( 'architecture_building_section_loader_heading', array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_section_loader_heading', array(
		'label'       => esc_html__( 'Loader Settings', 'architecture-building' ),
		'section'     => 'architecture_building_theme_settings',
		'settings'    => 'architecture_building_section_loader_heading',
	) ) );
	$wp_customize->add_setting(
		'architecture_building_theme_loader',
		array(
			'type'                 => 'option',
			'capability'           => 'edit_theme_options',
			'theme_supports'       => '',
			'default'              => 'off',
			'transport'            => 'refresh',
			'sanitize_callback'    => 'architecture_building_callback_sanitize_switch',
		)
	);
	$wp_customize->add_control(
		new Architecture_Building_Customizer_Customcontrol_Switch(
			$wp_customize,
			'architecture_building_theme_loader',
			array(
				'settings'        => 'architecture_building_theme_loader',
				'section'         => 'architecture_building_theme_settings',
				'label'           => __( 'Show Site Loader', 'architecture-building' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
			)
		)
	);

	$wp_customize->add_setting('architecture_building_loader_style',array(
        'default' => 'style_one',
        'sanitize_callback' => 'architecture_building_sanitize_choices'
	));
	$wp_customize->add_control('architecture_building_loader_style',array(
        'type' => 'select',
        'label' => __('Select Loader Design','architecture-building'),
        'section' => 'architecture_building_theme_settings',
        'choices' => array(
            'style_one' => __('Circle','architecture-building'),
            'style_two' => __('Bar','architecture-building'),
        ),
	) );


	$wp_customize->add_setting( 'architecture_building_section_theme_width_heading', array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_section_theme_width_heading', array(
		'label'       => esc_html__( 'Theme Width Setting', 'architecture-building' ),
		'section'     => 'architecture_building_theme_settings',
		'settings'    => 'architecture_building_section_theme_width_heading',
	) ) );
	$wp_customize->add_setting('architecture_building_width_options',array(
        'default' => 'full_width',
        'sanitize_callback' => 'architecture_building_sanitize_choices'
	));
	$wp_customize->add_control('architecture_building_width_options',array(
        'type' => 'select',
        'label' => __('Theme Width Option','architecture-building'),
        'section' => 'architecture_building_theme_settings',
        'choices' => array(
            'full_width' => __('fullwidth','architecture-building'),
            'container' => __('container','architecture-building'),
            'container_fluid' => __('container fluid','architecture-building'),
        ),
	) );
	
	$wp_customize->add_setting( 'architecture_building_section_menu_heading', array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_section_menu_heading', array(
		'label'       => esc_html__( 'Menu Settings', 'architecture-building' ),
		'section'     => 'architecture_building_theme_settings',
		'settings'    => 'architecture_building_section_menu_heading',
	) ) );
	$wp_customize->add_setting('architecture_building_menu_text_transform',array(
        'default' => 'CAPITALISE',
        'sanitize_callback' => 'architecture_building_sanitize_choices'
	));
	$wp_customize->add_control('architecture_building_menu_text_transform',array(
        'type' => 'select',
        'label' => __('Menus Text Transform','architecture-building'),
        'section' => 'architecture_building_theme_settings',
        'choices' => array(
            'CAPITALISE' => __('CAPITALISE','architecture-building'),
            'UPPERCASE' => __('UPPERCASE','architecture-building'),
            'LOWERCASE' => __('LOWERCASE','architecture-building'),
        ),
	) );
	$wp_customize->add_setting('architecture_building_menu_fontsize',array(
		'default'=> 13,
		'transport' => 'refresh',
		'sanitize_callback' => 'architecture_building_sanitize_integer'
	));
	$wp_customize->add_control(new Architecture_Building_Slider_Custom_Control( $wp_customize, 'architecture_building_menu_fontsize',array(
		'label' => esc_html__( 'menu font size','architecture-building' ),
		'section'=> 'architecture_building_theme_settings',
		'settings'=>'architecture_building_menu_fontsize',
		'input_attrs' => array(
			'reset'			   => 13,
            'step'             => 1,
			'min'              => 0,
			'max'              => 20,
        ),
	)));
	$wp_customize->add_setting( 'architecture_building_section_scroll_heading', array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_section_scroll_heading', array(
		'label'       => esc_html__( 'Scroll Top Settings', 'architecture-building' ),
		'section'     => 'architecture_building_theme_settings',
		'settings'    => 'architecture_building_section_scroll_heading',
	) ) );
	$wp_customize->add_setting(
		'architecture_building_scroll_enable',
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
		new Architecture_Building_Customizer_Customcontrol_Switch(
			$wp_customize,
			'architecture_building_scroll_enable',
			array(
				'settings'        => 'architecture_building_scroll_enable',
				'section'         => 'architecture_building_theme_settings',
				'label'           => __( 'show Scroll Top', 'architecture-building' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
			)
		)
	);
	$wp_customize->add_setting('architecture_building_scroll_options',array(
        'default' => 'right_align',
        'sanitize_callback' => 'architecture_building_sanitize_choices'
	));
	$wp_customize->add_control('architecture_building_scroll_options',array(
		'type' => 'radio',
		'label'     => __('Scroll Top Alignment', 'architecture-building'),
		'section' => 'architecture_building_theme_settings',
		'type' => 'select',
		'choices' => array(
			'left_align' => __('LEFT','architecture-building'),
			'center_align' => __('CENTER','architecture-building'),
			'right_align' => __('RIGHT','architecture-building'),
		)
	) );
	$wp_customize->add_setting('architecture_building_scroll_top_icon',array(
		'default'	=> 'fas fa-chevron-up',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Architecture_Building_Fontawesome_Icon_Chooser(
        $wp_customize,'architecture_building_scroll_top_icon',array(
		'label'	=> __('Add Scroll Top Icon','architecture-building'),
		'transport' => 'refresh',
		'section'	=> 'architecture_building_theme_settings',
		'setting'	=> 'architecture_building_scroll_top_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'architecture_building_section_cursor_heading', array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_section_cursor_heading', array(
		'label'       => esc_html__( 'Cursor Setting', 'architecture-building' ),
		'section'     => 'architecture_building_theme_settings',
		'settings'    => 'architecture_building_section_cursor_heading',
	) ) );

	$wp_customize->add_setting(
		'architecture_building_enable_custom_cursor',
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
		new Architecture_Building_Customizer_Customcontrol_Switch(
			$wp_customize,
			'architecture_building_enable_custom_cursor',
			array(
				'settings'        => 'architecture_building_enable_custom_cursor',
				'section'         => 'architecture_building_theme_settings',
				'label'           => __( 'show custom cursor', 'architecture-building' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
			)
		)
	);

	$wp_customize->add_setting( 'architecture_building_section_animation_heading', array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_section_animation_heading', array(
		'label'       => esc_html__( 'Animation Setting', 'architecture-building' ),
		'section'     => 'architecture_building_theme_settings',
		'settings'    => 'architecture_building_section_animation_heading',
	) ) );

	$wp_customize->add_setting(
		'architecture_building_animation_enable',
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
		new Architecture_Building_Customizer_Customcontrol_Switch(
			$wp_customize,
			'architecture_building_animation_enable',
			array(
				'settings'        => 'architecture_building_animation_enable',
				'section'         => 'architecture_building_theme_settings',
				'label'           => __( 'show/Hide Animation', 'architecture-building' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
			)
		)
	);

	$wp_customize->add_setting( 'architecture_building_section_description_first_letter', array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_section_description_first_letter', array(
		'label'       => esc_html__( 'First Letter Capital Settings', 'architecture-building' ),
		'section'     => 'architecture_building_theme_settings',
		'settings'    => 'architecture_building_section_description_first_letter',
	) ) );
	$wp_customize->add_setting(
		'architecture_building_first_letter_capital_enable',
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
		new Architecture_Building_Customizer_Customcontrol_Switch(
			$wp_customize,
			'architecture_building_first_letter_capital_enable',
			array(
				'settings'        => 'architecture_building_first_letter_capital_enable',
				'section'         => 'architecture_building_theme_settings',
				'label'           => __( 'Show/Hide First Letter Capital', 'architecture-building' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
			)
		)
	);

	// Post Layouts
	$wp_customize->add_panel( 'architecture_building_post_panel', array(
		'title' => esc_html__( 'Post Layout', 'architecture-building' ),
		'priority' => 4,
	));
	$wp_customize->add_section('architecture_building_blog_meta',array(
        'title' => __('Blog Meta', 'architecture-building'), 
        'panel' => 'architecture_building_post_panel',       
    ) );

    $wp_customize->add_setting( 'architecture_building_section_blog_meta_heading', array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_section_blog_meta_heading', array(
		'label'       => esc_html__( 'Blog Meta Settings', 'architecture-building' ),
		'section'     => 'architecture_building_blog_meta',
		'settings'    => 'architecture_building_section_blog_meta_heading',
	) ) );

	$wp_customize->add_setting('architecture_building_date',
		array(
			'type'                 => 'option',
			'capability'           => 'edit_theme_options',
			'theme_supports'       => '',
			'default'              => '1',
			'transport'            => 'refresh',
			'sanitize_callback'    => 'architecture_building_callback_sanitize_switch',
		)
	);
	$wp_customize->add_control(new Architecture_Building_Customizer_Customcontrol_Switch(
			$wp_customize,
			'architecture_building_date',
			array(
				'settings'        => 'architecture_building_date',
				'section'         => 'architecture_building_blog_meta',
				'label'           => __( 'Show Date', 'architecture-building' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
			)
		)
	);
	$wp_customize->selective_refresh->add_partial( 'architecture_building_date', array(
		'selector' => '.date-box',
		'render_callback' => 'architecture_building_customize_partial_architecture_building_date',
	) );
	$wp_customize->add_setting('architecture_building_date_icon',array(
		'default'	=> 'far fa-calendar-alt',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Architecture_Building_Fontawesome_Icon_Chooser(
        $wp_customize,'architecture_building_date_icon',array(
		'label'	=> __('date Icon','architecture-building'),
		'transport' => 'refresh',
		'section'	=> 'architecture_building_blog_meta',
		'setting'	=> 'architecture_building_date_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('architecture_building_date_type',array(
        'default' => 'published',
        'sanitize_callback' => 'architecture_building_sanitize_choices'
	));
	$wp_customize->add_control('architecture_building_date_type',array(
		'type' => 'radio',
		'label'     => __('Date Format', 'architecture-building'),
		'section' => 'architecture_building_blog_meta',
		'type' => 'select',
		'choices' => array(
			'published' => __('published date','architecture-building'),
            'modified' => __('modified date','architecture-building'),
		),
	) );



	$wp_customize->add_setting('architecture_building_sticky_icon',array(
		'default'	=> 'fas fa-thumb-tack',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Architecture_Building_Fontawesome_Icon_Chooser(
        $wp_customize,'architecture_building_sticky_icon',array(
		'label'	=> __('Sticky Post Icon','architecture-building'),
		'transport' => 'refresh',
		'section'	=> 'architecture_building_blog_meta',
		'setting'	=> 'architecture_building_sticky_icon',
		'type'		=> 'icon'
	)));
	$wp_customize->add_setting('architecture_building_admin',
		array(
			'type'                 => 'option',
			'capability'           => 'edit_theme_options',
			'theme_supports'       => '',
			'default'              => '1',
			'transport'            => 'refresh',
			'sanitize_callback'    => 'architecture_building_callback_sanitize_switch',
		)
	);
	$wp_customize->add_control(new Architecture_Building_Customizer_Customcontrol_Switch(
			$wp_customize,
			'architecture_building_admin',
			array(
				'settings'        => 'architecture_building_admin',
				'section'         => 'architecture_building_blog_meta',
				'label'           => __( 'Show Author/Admin', 'architecture-building' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
			)
		)
	);
	$wp_customize->selective_refresh->add_partial( 'architecture_building_admin', array(
		'selector' => '.entry-author',
		'render_callback' => 'architecture_building_customize_partial_architecture_building_admin',
	) );
	$wp_customize->add_setting('architecture_building_author_icon',array(
		'default'	=> 'fas fa-user',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Architecture_Building_Fontawesome_Icon_Chooser(
        $wp_customize,'architecture_building_author_icon',array(
		'label'	=> __('Author Icon','architecture-building'),
		'transport' => 'refresh',
		'section'	=> 'architecture_building_blog_meta',
		'setting'	=> 'architecture_building_author_icon',
		'type'		=> 'icon'
	)));
	$wp_customize->add_setting('architecture_building_comment',
		array(
			'type'                 => 'option',
			'capability'           => 'edit_theme_options',
			'theme_supports'       => '',
			'default'              => '1',
			'transport'            => 'refresh',
			'sanitize_callback'    => 'architecture_building_callback_sanitize_switch',
		)
	);
	$wp_customize->add_control(new Architecture_Building_Customizer_Customcontrol_Switch(
			$wp_customize,
			'architecture_building_comment',
			array(
				'settings'        => 'architecture_building_comment',
				'section'         => 'architecture_building_blog_meta',
				'label'           => __( 'Show Comment', 'architecture-building' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
			)
		)
	);
	$wp_customize->selective_refresh->add_partial( 'architecture_building_comment', array(
		'selector' => '.entry-comments',
		'render_callback' => 'architecture_building_customize_partial_architecture_building_comment',
	) );
	$wp_customize->add_setting('architecture_building_comment_icon',array(
		'default'	=> 'fas fa-comments',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Architecture_Building_Fontawesome_Icon_Chooser(
        $wp_customize,'architecture_building_comment_icon',array(
		'label'	=> __('comment Icon','architecture-building'),
		'transport' => 'refresh',
		'section'	=> 'architecture_building_blog_meta',
		'setting'	=> 'architecture_building_comment_icon',
		'type'		=> 'icon'
	)));
	$wp_customize->add_setting('architecture_building_tag',
		array(
			'type'                 => 'option',
			'capability'           => 'edit_theme_options',
			'theme_supports'       => '',
			'default'              => '1',
			'transport'            => 'refresh',
			'sanitize_callback'    => 'architecture_building_callback_sanitize_switch',
		)
	);
	$wp_customize->add_control(new Architecture_Building_Customizer_Customcontrol_Switch(
			$wp_customize,
			'architecture_building_tag',
			array(
				'settings'        => 'architecture_building_tag',
				'section'         => 'architecture_building_blog_meta',
				'label'           => __( 'Show tag count', 'architecture-building' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
			)
		)
	);
	$wp_customize->selective_refresh->add_partial( 'architecture_building_tag', array(
		'selector' => '.tags',
		'render_callback' => 'architecture_building_customize_partial_architecture_building_tag',
	) );
	$wp_customize->add_setting('architecture_building_tag_icon',array(
		'default'	=> 'fas fa-tags',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Architecture_Building_Fontawesome_Icon_Chooser(
        $wp_customize,'architecture_building_tag_icon',array(
		'label'	=> __('tag Icon','architecture-building'),
		'transport' => 'refresh',
		'section'	=> 'architecture_building_blog_meta',
		'setting'	=> 'architecture_building_tag_icon',
		'type'		=> 'icon'
	)));
    $wp_customize->add_section('architecture_building_layout',array(
        'title' => __('Single-Post Layout', 'architecture-building'),
        'panel' => 'architecture_building_post_panel',
    ) );
    $wp_customize->add_setting( 'architecture_building_section_post_heading', array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_section_post_heading', array(
		'label'       => esc_html__( 'Single Post Structure', 'architecture-building' ),
		'section'     => 'architecture_building_layout',
		'settings'    => 'architecture_building_section_post_heading',
	) ) );
	$wp_customize->add_setting( 'architecture_building_single_post_option',
		array(
			'default' => 'single_right_sidebar',
			'transport' => 'refresh',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( new Architecture_Building_Radio_Image_Control( $wp_customize, 'architecture_building_single_post_option',
		array(
			'type'=>'select',
			'label' => __( 'select Single Post Page Layout', 'architecture-building' ),
			'section' => 'architecture_building_layout',
			'choices' => array(

				'single_right_sidebar' => array(
					'image' => get_template_directory_uri().'/assets/images/2column.jpg',
					'name' => __( 'Right Sidebar', 'architecture-building' )
				),
				'single_left_sidebar' => array(
					'image' => get_template_directory_uri().'/assets/images/left.png',
					'name' => __( 'Left Sidebar', 'architecture-building' )
				),
				'single_full_width' => array(
					'image' => get_template_directory_uri().'/assets/images/1column.jpg',
					'name' => __( 'One Column', 'architecture-building' )
				),
			)
		)
	) );
	$wp_customize->add_setting('architecture_building_single_post_tag',
		array(
			'type'                 => 'option',
			'capability'           => 'edit_theme_options',
			'theme_supports'       => '',
			'default'              => '1',
			'transport'            => 'refresh',
			'sanitize_callback'    => 'architecture_building_callback_sanitize_switch',
		)
	);
	$wp_customize->add_control(new Architecture_Building_Customizer_Customcontrol_Switch(
			$wp_customize,
			'architecture_building_single_post_tag',
			array(
				'settings'        => 'architecture_building_single_post_tag',
				'section'         => 'architecture_building_layout',
				'label'           => __( 'Show Tags', 'architecture-building' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
			)
		)
	);
	$wp_customize->selective_refresh->add_partial( 'architecture_building_single_post_tag', array(
		'selector' => '.single-tags',
		'render_callback' => 'architecture_building_customize_partial_architecture_building_single_post_tag',
	) );
	$wp_customize->add_setting('architecture_building_similar_post',
		array(
			'type'                 => 'option',
			'capability'           => 'edit_theme_options',
			'theme_supports'       => '',
			'default'              => '1',
			'transport'            => 'refresh',
			'sanitize_callback'    => 'architecture_building_callback_sanitize_switch',
		)
	);
	$wp_customize->add_control(new Architecture_Building_Customizer_Customcontrol_Switch(
			$wp_customize,
			'architecture_building_similar_post',
			array(
				'settings'        => 'architecture_building_similar_post',
				'section'         => 'architecture_building_layout',
				'label'           => __( 'Show Similar post', 'architecture-building' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
			)
		)
	);
	$wp_customize->add_setting('architecture_building_similar_text',array(
		'default' => 'Explore More',
		'sanitize_callback' => 'sanitize_text_field'
	)); 
	$wp_customize->add_control('architecture_building_similar_text',array(
		'label' => esc_html__('Similar Post Heading','architecture-building'),
		'section' => 'architecture_building_layout',
		'setting' => 'architecture_building_similar_text',
		'type'    => 'text'
	));
	$wp_customize->add_section('architecture_building_archieve_post_layot',array(
        'title' => __('Archieve-Post Layout', 'architecture-building'),
        'panel' => 'architecture_building_post_panel',
    ) );
	$wp_customize->add_setting( 'architecture_building_section_archive_post_heading', array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_section_archive_post_heading', array(
		'label'       => esc_html__( 'Archieve Post Structure', 'architecture-building' ),
		'section'     => 'architecture_building_archieve_post_layot',
		'settings'    => 'architecture_building_section_archive_post_heading',
	) ) );
    $wp_customize->add_setting( 'architecture_building_post_option',
		array(
			'default' => 'right_sidebar',
			'transport' => 'refresh',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( new Architecture_Building_Radio_Image_Control( $wp_customize, 'architecture_building_post_option',
		array(
			'type'=>'select',
			'label' => __( 'select Post Page Layout', 'architecture-building' ),
			'section' => 'architecture_building_archieve_post_layot',
			'choices' => array(
				'right_sidebar' => array(
					'image' => get_template_directory_uri().'/assets/images/2column.jpg',
					'name' => __( 'Right Sidebar', 'architecture-building' )
				),
				'left_sidebar' => array(
					'image' => get_template_directory_uri().'/assets/images/left.png',
					'name' => __( 'Left Sidebar', 'architecture-building' )
				),
				'one_column' => array(
					'image' => get_template_directory_uri().'/assets/images/1column.jpg',
					'name' => __( 'One Column', 'architecture-building' )
				),
				'three_column' => array(
					'image' => get_template_directory_uri().'/assets/images/3column.jpg',
					'name' => __( 'Three Column', 'architecture-building' )
				),
				'four_column' => array(
					'image' => get_template_directory_uri().'/assets/images/4column.jpg',
					'name' => __( 'Four Column', 'architecture-building' )
				),
				'grid_sidebar' => array(
					'image' => get_template_directory_uri().'/assets/images/grid-sidebar.jpg',
					'name' => __( 'Grid-Right-Sidebar Layout', 'architecture-building' )
				),
				'grid_left_sidebar' => array(
					'image' => get_template_directory_uri().'/assets/images/grid-left.png',
					'name' => __( 'Grid-Left-Sidebar Layout', 'architecture-building' )
				),
				'grid_post' => array(
					'image' => get_template_directory_uri().'/assets/images/grid.jpg',
					'name' => __( 'Grid Layout', 'architecture-building' )
				)
			)
		)
	) );
	$wp_customize->add_setting('architecture_building_grid_column',array(
        'default' => '3_column',
        'sanitize_callback' => 'architecture_building_sanitize_choices'
	));
	$wp_customize->add_control('architecture_building_grid_column',array(
		'type' => 'radio',
		'label'     => __('Grid Post Per Row', 'architecture-building'),
		'section' => 'architecture_building_archieve_post_layot',
		'type' => 'select',
		'choices' => array(
			'1_column' => __('1','architecture-building'),
            '2_column' => __('2','architecture-building'),
            '3_column' => __('3','architecture-building'),
            '4_column' => __('4','architecture-building'),
		)
	) );
	$wp_customize->add_setting('archieve_post_order', array(
        'default' => array('title', 'image', 'meta','excerpt','btn'),
        'sanitize_callback' => 'architecture_building_sanitize_sortable',
    ));
    $wp_customize->add_control(new Architecture_Building_Control_Sortable($wp_customize, 'archieve_post_order', array(
    	'label' => esc_html__('Post Order', 'architecture-building'),
        'description' => __('Drag & Drop post items to re-arrange the order and also hide and show items as per the need by clicking on the eye icon.', 'architecture-building') ,
        'section' => 'architecture_building_archieve_post_layot',
        'choices' => array(
            'title' => __('title', 'architecture-building') ,
            'image' => __('media', 'architecture-building') ,
            'meta' => __('meta', 'architecture-building') ,
            'excerpt' => __('excerpt', 'architecture-building') ,
            'btn' => __('Read more', 'architecture-building') ,
        ) ,
    )));
	$wp_customize->add_setting('architecture_building_post_excerpt',array(
		'default'=> 30,
		'transport' => 'refresh',
		'sanitize_callback' => 'architecture_building_sanitize_integer'
	));
	$wp_customize->add_control(new Architecture_Building_Slider_Custom_Control( $wp_customize, 'architecture_building_post_excerpt',array(
		'label' => esc_html__( 'Excerpt Limit','architecture-building' ),
		'section'=> 'architecture_building_archieve_post_layot',
		'settings'=>'architecture_building_post_excerpt',
		'input_attrs' => array(
			'reset'			   => 30,
            'step'             => 1,
			'min'              => 0,
			'max'              => 100,
        ),
	)));
	$wp_customize->add_setting('architecture_building_read_more_text',array(
		'default' => 'Read More',
		'sanitize_callback' => 'sanitize_text_field'
	)); 
	$wp_customize->add_control('architecture_building_read_more_text',array(
		'label' => esc_html__('Read More Text','architecture-building'),
		'section' => 'architecture_building_archieve_post_layot',
		'setting' => 'architecture_building_read_more_text',
		'type'    => 'text'
	));

	$wp_customize->add_section('architecture_building_blog_pagination',array(
        'title' => __('Pagination', 'architecture-building'), 
        'panel' => 'architecture_building_post_panel',       
    ) );

	$wp_customize->add_setting('architecture_building_pagination_type',array(
        'default' => 'numbered',
        'sanitize_callback' => 'architecture_building_sanitize_choices'
	));
	$wp_customize->add_control('architecture_building_pagination_type',array(
		'type' => 'radio',
		'label'     => __('Blog Pagination', 'architecture-building'),
		'section' => 'architecture_building_blog_pagination',
		'type' => 'select',
		'choices' => array(
			'default' => __('Previous/Next','architecture-building'),
            'numbered' => __('Numbered','architecture-building'),
		),
	) );

	$wp_customize->add_setting('architecture_building_single_post_pagination_type',array(
        'default' => 'default',
        'sanitize_callback' => 'architecture_building_sanitize_choices'
	));
	$wp_customize->add_control('architecture_building_single_post_pagination_type',array(
		'type' => 'radio',
		'label'     => __('Post Pagination', 'architecture-building'),
		'section' => 'architecture_building_blog_pagination',
		'type' => 'select',
		'choices' => array(
			'default' => __('Previous/Next','architecture-building'),
            'post-name' => __('Post Title','architecture-building'),
		),
	) );

	// header-image
	$wp_customize->add_setting( 'architecture_building_section_header_image_heading', array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_section_header_image_heading', array(
		'label'       => esc_html__( 'Header Image Settings', 'architecture-building' ),
		'section'     => 'header_image',
		'settings'    => 'architecture_building_section_header_image_heading',
		'priority'    =>'1',
	) ) );

	$wp_customize->add_setting('architecture_building_show_header_image',array(
        'default' => 'on',
        'sanitize_callback' => 'architecture_building_sanitize_choices'
	));
	$wp_customize->add_control('architecture_building_show_header_image',array(
        'type' => 'select',
        'label' => __('Select Option','architecture-building'),
        'section' => 'header_image',
        'choices' => array(
            'on' => __('With Header Image','architecture-building'),
            'off' => __('Without Header Image','architecture-building'),
        ),
	) );

	$wp_customize->add_section('architecture_building_breadcrumb_settings',array(
        'title' => __('Breadcrumb Settings', 'architecture-building'),
        'priority' => 4
    ) );
	$wp_customize->add_setting( 'architecture_building_section_breadcrumb_heading', array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_section_breadcrumb_heading', array(
		'label'       => esc_html__( ' Theme Breadcrumb Settings', 'architecture-building' ),
		'section'     => 'architecture_building_breadcrumb_settings',
		'settings'    => 'architecture_building_section_breadcrumb_heading',
	) ) );
	$wp_customize->add_setting(
		'architecture_building_enable_breadcrumb',
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
		new Architecture_Building_Customizer_Customcontrol_Switch(
			$wp_customize,
			'architecture_building_enable_breadcrumb',
			array(
				'settings'        => 'architecture_building_enable_breadcrumb',
				'section'         => 'architecture_building_breadcrumb_settings',
				'label'           => __( 'Show Breadcrumb', 'architecture-building' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
			)
		)
	);
	$wp_customize->add_setting('architecture_building_breadcrumb_separator', array(
        'default' => ' / ',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('architecture_building_breadcrumb_separator', array(
        'label' => __('Breadcrumb Separator', 'architecture-building'),
        'section' => 'architecture_building_breadcrumb_settings',
        'type' => 'text',
    ));
	$wp_customize->add_setting( 'architecture_building_single_breadcrumb_heading', array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_single_breadcrumb_heading', array(
		'label'       => esc_html__( 'Single post & Page', 'architecture-building' ),
		'section'     => 'architecture_building_breadcrumb_settings',
		'settings'    => 'architecture_building_single_breadcrumb_heading',
	) ) );
	$wp_customize->add_setting(
		'architecture_building_single_enable_breadcrumb',
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
		new Architecture_Building_Customizer_Customcontrol_Switch(
			$wp_customize,
			'architecture_building_single_enable_breadcrumb',
			array(
				'settings'        => 'architecture_building_single_enable_breadcrumb',
				'section'         => 'architecture_building_breadcrumb_settings',
				'label'           => __( 'Show Breadcrumb', 'architecture-building' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
			)
		)
	);
	if ( class_exists( 'WooCommerce' ) ) { 
		$wp_customize->add_setting( 'architecture_building_woocommerce_breadcrumb_heading', array(
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_woocommerce_breadcrumb_heading', array(
			'label'       => esc_html__( 'Woocommerce Breadcrumb', 'architecture-building' ),
			'section'     => 'architecture_building_breadcrumb_settings',
			'settings'    => 'architecture_building_woocommerce_breadcrumb_heading',
		) ) );
		$wp_customize->add_setting(
			'architecture_building_woocommerce_enable_breadcrumb',
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
			new Architecture_Building_Customizer_Customcontrol_Switch(
				$wp_customize,
				'architecture_building_woocommerce_enable_breadcrumb',
				array(
					'settings'        => 'architecture_building_woocommerce_enable_breadcrumb',
					'section'         => 'architecture_building_breadcrumb_settings',
					'label'           => __( 'Show Breadcrumb', 'architecture-building' ),				
					'choices'		  => array(
						'1'      => __( 'On', 'architecture-building' ),
						'off'    => __( 'Off', 'architecture-building' ),
					),
					'active_callback' => '',
				)
			)
		);
		$wp_customize->add_setting('woocommerce_breadcrumb_separator', array(
	        'default' => ' / ',
	        'sanitize_callback' => 'sanitize_text_field',
	    ));
	    $wp_customize->add_control('woocommerce_breadcrumb_separator', array(
	        'label' => __('Breadcrumb Separator', 'architecture-building'),
	        'section' => 'architecture_building_breadcrumb_settings',
	        'type' => 'text',
	    ));
	}

	// woocommerce
	if ( class_exists( 'WooCommerce' ) ) { 

		$wp_customize->add_section('architecture_building_woocoomerce_section',array(
	        'title' => __('Custom Woocommerce Settings', 'architecture-building'),
	        'panel' => 'woocommerce',
	        'priority' => 4,
	    ) );
		$wp_customize->add_setting( 'architecture_building_section_shoppage_heading', array(
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_section_shoppage_heading', array(
			'label'       => esc_html__( 'Sidebar Settings', 'architecture-building' ),
			'section'     => 'architecture_building_woocoomerce_section',
			'settings'    => 'architecture_building_section_shoppage_heading',
		) ) );
		$wp_customize->add_setting( 'architecture_building_shop_page_sidebar',
			array(
				'default' => 'right_sidebar',
				'transport' => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);
		$wp_customize->add_control( new Architecture_Building_Radio_Image_Control( $wp_customize, 'architecture_building_shop_page_sidebar',
			array(
				'type'=>'select',
				'label' => __( 'Show Shop Page Sidebar', 'architecture-building' ),
				'section'     => 'architecture_building_woocoomerce_section',
				'choices' => array(

					'right_sidebar' => array(
						'image' => get_template_directory_uri().'/assets/images/2column.jpg',
						'name' => __( 'Right Sidebar', 'architecture-building' )
					),
					'left_sidebar' => array(
						'image' => get_template_directory_uri().'/assets/images/left.png',
						'name' => __( 'Left Sidebar', 'architecture-building' )
					),
					'full_width' => array(
						'image' => get_template_directory_uri().'/assets/images/1column.jpg',
						'name' => __( 'Full Width', 'architecture-building' )
					),
				)
			)
		) );
		$wp_customize->add_setting( 'architecture_building_wocommerce_single_page_sidebar',
			array(
				'default' => 'right_sidebar',
				'transport' => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);
		$wp_customize->add_control( new Architecture_Building_Radio_Image_Control( $wp_customize, 'architecture_building_wocommerce_single_page_sidebar',
			array(
				'type'=>'select',
				'label'           => __( 'Show Single Product Page Sidebar', 'architecture-building' ),
				'section'     => 'architecture_building_woocoomerce_section',
				'choices' => array(

					'right_sidebar' => array(
						'image' => get_template_directory_uri().'/assets/images/2column.jpg',
						'name' => __( 'Right Sidebar', 'architecture-building' )
					),
					'left_sidebar' => array(
						'image' => get_template_directory_uri().'/assets/images/left.png',
						'name' => __( 'Left Sidebar', 'architecture-building' )
					),
					'full_width' => array(
						'image' => get_template_directory_uri().'/assets/images/1column.jpg',
						'name' => __( 'Full Width', 'architecture-building' )
					),
				)
			)
		) );
		$wp_customize->add_setting( 'architecture_building_section_archieve_product_heading', array(
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_section_archieve_product_heading', array(
			'label'       => esc_html__( 'Archieve Product Settings', 'architecture-building' ),
			'section'     => 'architecture_building_woocoomerce_section',
			'settings'    => 'architecture_building_section_archieve_product_heading',
		) ) );
		$wp_customize->add_setting('architecture_building_archieve_item_columns',array(
	        'default' => '3',
	        'sanitize_callback' => 'architecture_building_sanitize_choices'
		));
		$wp_customize->add_control('architecture_building_archieve_item_columns',array(
	        'type' => 'select',
	        'label' => __('Select No of Columns','architecture-building'),
	        'section' => 'architecture_building_woocoomerce_section',
	        'choices' => array(
	            '1' => __('One Column','architecture-building'),
	            '2' => __('Two Column','architecture-building'),
	            '3' => __('Three Column','architecture-building'),
	            '4' => __('four Column','architecture-building'),
	            '5' => __('Five Column','architecture-building'),
	            '6' => __('Six Column','architecture-building'),
	        ),
		) );
		$wp_customize->add_setting( 'architecture_building_archieve_shop_perpage', array(
			'default'              => 6,
			'type'                 => 'theme_mod',
			'transport' 		   => 'refresh',
			'sanitize_callback'    => 'architecture_building_sanitize_number_absint',
			'sanitize_js_callback' => 'absint',
		) );
		$wp_customize->add_control( 'architecture_building_archieve_shop_perpage', array(
			'label'       => esc_html__( 'Display Products','architecture-building' ),
			'section'     => 'architecture_building_woocoomerce_section',
			'type'        => 'number',
			'input_attrs' => array(
				'step'             => 1,
				'min'              => 0,
				'max'              => 30,
			),
		) );
		$wp_customize->add_setting( 'architecture_building_section_related_heading', array(
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_section_related_heading', array(
			'label'       => esc_html__( 'Related Product Settings', 'architecture-building' ),
			'section'     => 'architecture_building_woocoomerce_section',
			'settings'    => 'architecture_building_section_related_heading',
		) ) );
		$wp_customize->add_setting('architecture_building_related_item_columns',array(
	        'default' => '3',
	        'sanitize_callback' => 'architecture_building_sanitize_choices'
		));
		$wp_customize->add_control('architecture_building_related_item_columns',array(
	        'type' => 'select',
	        'label' => __('Select No of Columns','architecture-building'),
	        'section' => 'architecture_building_woocoomerce_section',
	        'choices' => array(
	            '1' => __('One Column','architecture-building'),
	            '2' => __('Two Column','architecture-building'),
	            '3' => __('Three Column','architecture-building'),
	            '4' => __('four Column','architecture-building'),
	            '5' => __('Five Column','architecture-building'),
	            '6' => __('Six Column','architecture-building'),
	        ),
		) );
		$wp_customize->add_setting( 'architecture_building_related_shop_perpage', array(
			'default'              => 3,
			'type'                 => 'theme_mod',
			'transport' 		   => 'refresh',
			'sanitize_callback'    => 'architecture_building_sanitize_number_absint',
			'sanitize_js_callback' => 'absint',
		) );
		$wp_customize->add_control( 'architecture_building_related_shop_perpage', array(
			'label'       => esc_html__( 'Display Products','architecture-building' ),
			'section'     => 'architecture_building_woocoomerce_section',
			'type'        => 'number',
			'input_attrs' => array(
				'step'             => 1,
				'min'              => 0,
				'max'              => 10,
			),
		) );
		$wp_customize->add_setting(
			'architecture_building_related_product',
			array(
				'type'                 => 'option',
				'capability'           => 'edit_theme_options',
				'theme_supports'       => '',
				'default'              => '1',
				'transport'            => 'refresh',
				'sanitize_callback'    => 'architecture_building_callback_sanitize_switch',
			)
		);
		$wp_customize->add_control(new Architecture_Building_Customizer_Customcontrol_Switch($wp_customize,'architecture_building_related_product',
			array(
				'settings'        => 'architecture_building_related_product',
				'section'         => 'architecture_building_woocoomerce_section',
				'label'           => __( 'Show Related Products', 'architecture-building' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
			)
		));
	}

	// mobile width
	$wp_customize->add_section('architecture_building_mobile_options',array(
        'title' => __('Mobile Media settings', 'architecture-building'),
        'priority' => 4,
    ) );
    $wp_customize->add_setting( 'architecture_building_section_mobile_heading', array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_section_mobile_heading', array(
		'label'       => esc_html__( 'Mobile Media settings', 'architecture-building' ),
		'section'     => 'architecture_building_mobile_options',
		'settings'    => 'architecture_building_section_mobile_heading',
	) ) );
	$wp_customize->add_setting('architecture_building_menu_icon',array(
		'default'	=> 'fas fa-bars',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Architecture_Building_Fontawesome_Icon_Chooser(
        $wp_customize,'architecture_building_menu_icon',array(
		'label'	=> __('Menu Icon','architecture-building'),
		'transport' => 'refresh',
		'section'	=> 'architecture_building_mobile_options',
		'setting'	=> 'architecture_building_menu_icon',
		'type'		=> 'icon'
	)));
	$wp_customize->add_setting(
		'architecture_building_slider_button_mobile_show_hide',
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
		new Architecture_Building_Customizer_Customcontrol_Switch(
			$wp_customize,
			'architecture_building_slider_button_mobile_show_hide',
			array(
				'settings'        => 'architecture_building_slider_button_mobile_show_hide',
				'section'         => 'architecture_building_mobile_options',
				'label'           => __( 'Show Slider Button', 'architecture-building' ),
				'description' => __('Control wont function if the button is off in the main slider settings.', 'architecture-building') ,				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
			)
		)
	);
	$wp_customize->add_setting(
		'architecture_building_scroll_enable_mobile',
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
		new Architecture_Building_Customizer_Customcontrol_Switch(
			$wp_customize,
			'architecture_building_scroll_enable_mobile',
			array(
				'settings'        => 'architecture_building_scroll_enable_mobile',
				'section'         => 'architecture_building_mobile_options',
				'label'           => __( 'Show Scroll Top', 'architecture-building' ),
				'description' => __('Control wont function if scroll-top is off in the main settings.', 'architecture-building') ,				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
			)
		)
	);
	$wp_customize->add_setting( 'architecture_building_section_mobile_breadcrumb_heading', array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_section_mobile_breadcrumb_heading', array(
		'label'       => esc_html__( 'Mobile Breadcrumb settings', 'architecture-building' ),
		'description' => __('Controls wont function if the breadcrumb is off in the main breadcrumb settings.', 'architecture-building') ,
		'section'     => 'architecture_building_mobile_options',
		'settings'    => 'architecture_building_section_mobile_breadcrumb_heading',
	) ) );
	$wp_customize->add_setting(
		'architecture_building_enable_breadcrumb_mobile',
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
		new Architecture_Building_Customizer_Customcontrol_Switch(
			$wp_customize,
			'architecture_building_enable_breadcrumb_mobile',
			array(
				'settings'        => 'architecture_building_enable_breadcrumb_mobile',
				'section'         => 'architecture_building_mobile_options',
				'label'           => __( 'Theme Breadcrumb', 'architecture-building' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
			)
		)
	);
	$wp_customize->add_setting(
		'architecture_building_single_enable_breadcrumb_mobile',
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
		new Architecture_Building_Customizer_Customcontrol_Switch(
			$wp_customize,
			'architecture_building_single_enable_breadcrumb_mobile',
			array(
				'settings'        => 'architecture_building_single_enable_breadcrumb_mobile',
				'section'         => 'architecture_building_mobile_options',
				'label'           => __( 'Single Post & Page', 'architecture-building' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
			)
		)
	);
	if ( class_exists( 'WooCommerce' ) ) {
		$wp_customize->add_setting(
			'architecture_building_woocommerce_enable_breadcrumb_mobile',
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
			new Architecture_Building_Customizer_Customcontrol_Switch(
				$wp_customize,
				'architecture_building_woocommerce_enable_breadcrumb_mobile',
				array(
					'settings'        => 'architecture_building_woocommerce_enable_breadcrumb_mobile',
					'section'         => 'architecture_building_mobile_options',
					'label'           => __( 'wooCommerce Breadcrumb', 'architecture-building' ),				
					'choices'		  => array(
						'1'      => __( 'On', 'architecture-building' ),
						'off'    => __( 'Off', 'architecture-building' ),
					),
					'active_callback' => '',
				)
			)
		);
	}

	$wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport  = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.site-title a',
		'render_callback' => 'architecture_building_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description',
		'render_callback' => 'architecture_building_customize_partial_blogdescription',
	) );

	//front page
	$num_sections = apply_filters( 'architecture_building_front_page_sections', 4 );

	// Create a setting and control for each of the sections available in the theme.
	for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
		$wp_customize->add_setting( 'panel_' . $i, array(
			'default'           => false,
			'sanitize_callback' => 'architecture_building_sanitize_dropdown_pages',
			'transport'         => 'postMessage',
		) );

		$wp_customize->add_control( 'panel_' . $i, array(
			/* translators: %d is the front page section number */
			'label'          => sprintf( __( 'Front Page Section %d Content', 'architecture-building' ), $i ),
			'description'    => ( 1 !== $i ? '' : __( 'Select pages to feature in each area from the dropdowns. Add an image to a section by setting a featured image in the page editor. Empty sections will not be displayed.', 'architecture-building' ) ),
			'section'        => 'theme_options',
			'type'           => 'dropdown-pages',
			'allow_addition' => true,
			'active_callback' => 'architecture_building_is_static_front_page',
		) );

		$wp_customize->selective_refresh->add_partial( 'panel_' . $i, array(
			'selector'            => '#panel' . $i,
			'render_callback'     => 'architecture_building_front_page_section',
			'container_inclusive' => true,
		) );
	}
}
add_action( 'customize_register', 'architecture_building_customize_register' );

function architecture_building_customize_partial_blogname() {
	bloginfo( 'name' );
}
function architecture_building_customize_partial_blogdescription() {
	bloginfo( 'description' );
}
function architecture_building_is_static_front_page() {
	return ( is_front_page() && ! is_home() );
}
function architecture_building_is_view_with_layout_option() {
	return ( is_page() || ( is_archive() && ! is_active_sidebar( 'sidebar-1' ) ) );
}

/* Pro control */
if (class_exists('WP_Customize_Control') && !class_exists('Architecture_Building_Pro_Control')):
    class Architecture_Building_Pro_Control extends WP_Customize_Control{

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
