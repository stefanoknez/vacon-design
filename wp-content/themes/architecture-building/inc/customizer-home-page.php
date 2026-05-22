<?php
/**
 * Architecture Building: Customizer-home-page
 *
 * @subpackage Architecture Building
 * @since 1.0
 */
	
	//  Home Page Panel
	$wp_customize->add_panel( 'architecture_building_custompage_panel', array(
		'title' => esc_html__( 'Custom Page Settings', 'architecture-building' ),
		'priority' => 2,
	));
	// Top Header
    $wp_customize->add_section('architecture_building_top',array(
        'title' => __('Contact Details', 'architecture-building'),
        'priority' => 3,
        'panel' => 'architecture_building_custompage_panel',
    ) );
    $wp_customize->add_setting( 'architecture_building_section_contact_heading', array(
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_section_contact_heading', array(
		'label'       => esc_html__( 'Contact Settings', 'architecture-building' ),	
		'description' => __( 'Add contact info in the below feilds', 'architecture-building' ),		
		'section'     => 'architecture_building_top',
		'settings'    => 'architecture_building_section_contact_heading',
	) ) );
    $wp_customize->add_setting('architecture_building_top_email_address',array(
		'default' => '',
		'sanitize_callback' => 'sanitize_email'
	));
	$wp_customize->add_control('architecture_building_top_email_address',array(
		'label' => esc_html__('Add Email Address','architecture-building'),
		'section' => 'architecture_building_top',
		'setting' => 'architecture_building_top_email_address',
		'type'    => 'text'
	));
	$wp_customize->add_setting('architecture_building_email_icon',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Architecture_Building_Fontawesome_Icon_Chooser(
        $wp_customize,'architecture_building_email_icon',array(
		'label'	=> __('Add Email Icon','architecture-building'),
		'transport' => 'refresh',
		'section'	=> 'architecture_building_top',
		'setting'	=> 'architecture_building_email_icon',
		'type'		=> 'icon'
	)));
	$wp_customize->add_setting('architecture_building_top_phone_number',array(
		'default' => '',
		'sanitize_callback' => 'architecture_building_sanitize_phone_number'
	));
	$wp_customize->add_control('architecture_building_top_phone_number',array(
		'label' => esc_html__('Add Phone Number','architecture-building'),
		'section' => 'architecture_building_top',
		'setting' => 'architecture_building_top_phone_number',
		'type'    => 'text'
	));
	$wp_customize->add_setting('architecture_building_call_icon',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Architecture_Building_Fontawesome_Icon_Chooser(
        $wp_customize,'architecture_building_call_icon',array(
		'label'	=> __('Add phone Icon','architecture-building'),
		'transport' => 'refresh',
		'section'	=> 'architecture_building_top',
		'setting'	=> 'architecture_building_call_icon',
		'type'		=> 'icon'
	)));
	$wp_customize->add_setting('architecture_building_address_url',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw'
	));
	$wp_customize->add_control('architecture_building_address_url',array(
		'label' => esc_html__('Add Map URL','architecture-building'),
		'section' => 'architecture_building_top',
		'setting' => 'architecture_building_address_url',
		'type'    => 'url'
	));
    $wp_customize->add_setting('architecture_building_top_location',array(
		'default' => '',
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('architecture_building_top_location',array(
		'label' => esc_html__('Add Location','architecture-building'),
		'section' => 'architecture_building_top',
		'setting' => 'architecture_building_top_location',
		'type'    => 'text'
	));
	$wp_customize->add_setting('architecture_building_location_icon',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Architecture_Building_Fontawesome_Icon_Chooser(
        $wp_customize,'architecture_building_location_icon',array(
		'label'	=> __('Add Location Icon','architecture-building'),
		'transport' => 'refresh',
		'section'	=> 'architecture_building_top',
		'setting'	=> 'architecture_building_location_icon',
		'type'		=> 'icon'
	)));

	// Social Media
    $wp_customize->add_section('architecture_building_urls',array(
        'title' => __('Social Media', 'architecture-building'),
        'priority' => 3,
        'panel' => 'architecture_building_custompage_panel',
    ) );
    $wp_customize->add_setting( 'architecture_building_section_social_heading', array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_section_social_heading', array(
		'label'       => esc_html__( 'Social Media Settings', 'architecture-building' ),
		'description' => __( 'Add social media links in the below feilds', 'architecture-building' ),			
		'section'     => 'architecture_building_urls',
		'settings'    => 'architecture_building_section_social_heading',
	) ) );
	$wp_customize->add_setting(
		'header_social_icon_enable',
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
			'header_social_icon_enable',
			array(
				'settings'        => 'header_social_icon_enable',
				'section'         => 'architecture_building_urls',
				'label'           => __( 'Check to show social fields', 'architecture-building' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
			)
		)
	);
	$wp_customize->add_setting( 'architecture_building_section_twitter_heading', array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_section_twitter_heading', array(
		'label'       => esc_html__( 'Twitter Settings', 'architecture-building' ),			
		'section'     => 'architecture_building_urls',
		'settings'    => 'architecture_building_section_twitter_heading',
	) ) );
    $wp_customize->add_setting('architecture_building_twitter_icon',array(
		'default'	=> 'fab fa-x-twitter',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Architecture_Building_Fontawesome_Icon_Chooser(
        $wp_customize,'architecture_building_twitter_icon',array(
		'label'	=> __('Add Icon','architecture-building'),
		'transport' => 'refresh',
		'section'	=> 'architecture_building_urls',
		'setting'	=> 'architecture_building_twitter_icon',
		'type'		=> 'icon'
	)));
	$wp_customize->selective_refresh->add_partial( 'architecture_building_twitter', array(
		'selector' => '.social-icon a i',
		'render_callback' => 'architecture_building_customize_partial_architecture_building_twitter',
	) );
	$wp_customize->add_setting('architecture_building_twitter',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw'
	));
	$wp_customize->add_control('architecture_building_twitter',array(
		'label' => esc_html__('Add URL','architecture-building'),
		'section' => 'architecture_building_urls',
		'setting' => 'architecture_building_twitter',
		'type'    => 'url'
	));
	$wp_customize->add_setting(
		'architecture_building_header_twt_target',
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
			'architecture_building_header_twt_target',
			array(
				'settings'        => 'architecture_building_header_twt_target',
				'section'         => 'architecture_building_urls',
				'label'           => __( 'Open link in a new tab', 'architecture-building' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
			)
		)
	);
	$wp_customize->add_setting( 'architecture_building_section_linkedin_heading', array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_section_linkedin_heading', array(
		'label'       => esc_html__( 'Linkedin Settings', 'architecture-building' ),			
		'section'     => 'architecture_building_urls',
		'settings'    => 'architecture_building_section_linkedin_heading',
	) ) );
	$wp_customize->add_setting('architecture_building_linkedin_icon',array(
		'default'	=> 'fab fa-linkedin',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Architecture_Building_Fontawesome_Icon_Chooser(
        $wp_customize,'architecture_building_linkedin_icon',array(
		'label'	=> __('Add Icon','architecture-building'),
		'transport' => 'refresh',
		'section'	=> 'architecture_building_urls',
		'setting'	=> 'architecture_building_linkedin_icon',
		'type'		=> 'icon'
	)));
	$wp_customize->add_setting('architecture_building_linkedin',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw'
	));
	$wp_customize->add_control('architecture_building_linkedin',array(
		'label' => esc_html__('Add URL','architecture-building'),
		'section' => 'architecture_building_urls',
		'setting' => 'architecture_building_linkedin',
		'type'    => 'url'
	));
	$wp_customize->add_setting(
		'architecture_building_header_linkedin_target',
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
			'architecture_building_header_linkedin_target',
			array(
				'settings'        => 'architecture_building_header_linkedin_target',
				'section'         => 'architecture_building_urls',
				'label'           => __( 'Open link in a new tab', 'architecture-building' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
			)
		)
	);
	$wp_customize->add_setting( 'architecture_building_section_youtube_heading', array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_section_youtube_heading', array(
		'label'       => esc_html__( 'Youtube Settings', 'architecture-building' ),			
		'section'     => 'architecture_building_urls',
		'settings'    => 'architecture_building_section_youtube_heading',
	) ) );
	$wp_customize->add_setting('architecture_building_youtube_icon',array(
		'default'	=> 'fab fa-youtube',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Architecture_Building_Fontawesome_Icon_Chooser(
        $wp_customize,'architecture_building_youtube_icon',array(
		'label'	=> __('Add Icon','architecture-building'),
		'transport' => 'refresh',
		'section'	=> 'architecture_building_urls',
		'setting'	=> 'architecture_building_youtube_icon',
		'type'		=> 'icon'
	)));
	$wp_customize->add_setting('architecture_building_youtube',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw'
	));
	$wp_customize->add_control('architecture_building_youtube',array(
		'label' => esc_html__('Add URL','architecture-building'),
		'section' => 'architecture_building_urls',
		'setting' => 'architecture_building_youtube',
		'type'    => 'url'
	));
	$wp_customize->add_setting(
		'architecture_building_header_youtube_target',
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
			'architecture_building_header_youtube_target',
			array(
				'settings'        => 'architecture_building_header_youtube_target',
				'section'         => 'architecture_building_urls',
				'label'           => __( 'Open link in a new tab', 'architecture-building' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
			)
		)
	);
	$wp_customize->add_setting( 'architecture_building_section_instagram_heading', array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_section_instagram_heading', array(
		'label'       => esc_html__( 'Instagram Settings', 'architecture-building' ),			
		'section'     => 'architecture_building_urls',
		'settings'    => 'architecture_building_section_instagram_heading',
	) ) );
	$wp_customize->add_setting('architecture_building_instagram_icon',array(
		'default'	=> 'fab fa-instagram',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Architecture_Building_Fontawesome_Icon_Chooser(
        $wp_customize,'architecture_building_instagram_icon',array(
		'label'	=> __('Add Icon','architecture-building'),
		'transport' => 'refresh',
		'section'	=> 'architecture_building_urls',
		'setting'	=> 'architecture_building_instagram_icon',
		'type'		=> 'icon'
	)));
	$wp_customize->add_setting('architecture_building_instagram',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw'
	));
	$wp_customize->add_control('architecture_building_instagram',array(
		'label' => esc_html__('Add URL','architecture-building'),
		'section' => 'architecture_building_urls',
		'setting' => 'architecture_building_instagram',
		'type'    => 'url'
	));
	$wp_customize->add_setting(
		'architecture_building_header_instagram_target',
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
			'architecture_building_header_instagram_target',
			array(
				'settings'        => 'architecture_building_header_instagram_target',
				'section'         => 'architecture_building_urls',
				'label'           => __( 'Open link in a new tab', 'architecture-building' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
			)
		)
	);
    
    //Slider
	$wp_customize->add_section( 'architecture_building_slider_section' , array(
    	'title'      => __( 'Slider Settings', 'architecture-building' ),
    	'priority'   => 3,
    	'panel' => 'architecture_building_custompage_panel',
	) );
	$wp_customize->add_setting( 'architecture_building_section_slide_heading', array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_section_slide_heading', array(
		'label'       => esc_html__( 'Slider Settings', 'architecture-building' ),
		'description' => __( 'Slider Image Dimension ( 1600px x 650px )', 'architecture-building' ),		
		'section'     => 'architecture_building_slider_section',
		'settings'    => 'architecture_building_section_slide_heading',
		'priority'    => 1,
	) ) );
	$wp_customize->add_setting(
		'architecture_building_slider_arrows',
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
			'architecture_building_slider_arrows',
			array(
				'settings'        => 'architecture_building_slider_arrows',
				'section'         => 'architecture_building_slider_section',
				'label'           => __( 'Check To show Slider', 'architecture-building' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
				'priority'   => 1,
			)
		)
	);

	$wp_customize->add_setting('architecture_building_slider_count',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('architecture_building_slider_count',array(
		'label'	=> esc_html__('Slider Count','architecture-building'),
		'section'	=> 'architecture_building_slider_section',
		'type'		=> 'number',
		'priority'	  => 1,
	));

	$architecture_building_categories = get_categories();
	$cats = array();
	$i = 0;
	$cat_post[]= 'select';
	foreach($architecture_building_categories as $category){
	if($i==0){
	  $default = $category->slug;
	  $i++;
	}
	$cat_post[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('architecture_building_post_setting',array(
		'default' => 'select',
		'sanitize_callback' => 'architecture_building_sanitize_select',
	));
	$wp_customize->add_control('architecture_building_post_setting',array(
		'type'    => 'select',
		'choices' => $cat_post,
		'label' => esc_html__('Select Category to display slider images','architecture-building'),
		'section' => 'architecture_building_slider_section',
		'priority' => 1,
	));

	$wp_customize->add_setting('architecture_building_slider_heading_color', array(
	    'default' => '#ffffff',
	    'sanitize_callback' => 'sanitize_hex_color',
	    'transport' => 'refresh',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'architecture_building_slider_heading_color', array(
	    'section' => 'architecture_building_slider_section',
	    'label' => esc_html__('Slider Title Color', 'architecture-building'),
	 	'priority'    => 2,
	)));

	$wp_customize->add_setting(
		'architecture_building_slider_excerpt_show_hide',
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
			'architecture_building_slider_excerpt_show_hide',
			array(
				'settings'        => 'architecture_building_slider_excerpt_show_hide',
				'section'         => 'architecture_building_slider_section',
				'label'           => __( 'Show Hide excerpt', 'architecture-building' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'priority'   => 3,
			)
		)
	);
	$wp_customize->add_setting('architecture_building_slider_excerpt_count',array(
		'default'=> 20,
		'transport' => 'refresh',
		'sanitize_callback' => 'architecture_building_sanitize_integer'
	));
	$wp_customize->add_control(new Architecture_Building_Slider_Custom_Control( $wp_customize, 'architecture_building_slider_excerpt_count',array(
		'label' => esc_html__( 'Excerpt Limit','architecture-building' ),
		'section'=> 'architecture_building_slider_section',
		'settings'=>'architecture_building_slider_excerpt_count',
		'input_attrs' => array(
			'reset'			   => 20,
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
        'priority'   => 3,
	)));

	$wp_customize->add_setting('architecture_building_slider_excerpt_color', array(
	    'default' => '#ffffff',
	    'sanitize_callback' => 'sanitize_hex_color',
	    'transport' => 'refresh',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'architecture_building_slider_excerpt_color', array(
	    'section' => 'architecture_building_slider_section',
	    'label' => esc_html__('Slider Excerpt Color', 'architecture-building'),
	 	'priority'    => 4,
	)));

	$wp_customize->add_setting(
		'architecture_building_slider_button_show_hide',
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
			'architecture_building_slider_button_show_hide',
			array(
				'settings'        => 'architecture_building_slider_button_show_hide',
				'section'         => 'architecture_building_slider_section',
				'label'           => __( 'Show Hide Button', 'architecture-building' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'priority'   => 5,
			)
		)
	);
	$wp_customize->add_setting('architecture_building_slider_read_more',array(
		'default' => 'Get a quote',
		'sanitize_callback' => 'sanitize_text_field'
	)); 
	$wp_customize->add_control('architecture_building_slider_read_more',array(
		'label' => esc_html__('Button Text','architecture-building'),
		'section' => 'architecture_building_slider_section',
		'setting' => 'architecture_building_slider_read_more',
		'type'    => 'text',
		'priority'   => 5,
	));

	$wp_customize->add_setting('architecture_building_slider_content_alignment',array(
        'default' => 'CENTER-ALIGN',
        'sanitize_callback' => 'architecture_building_sanitize_choices'
	));
	$wp_customize->add_control('architecture_building_slider_content_alignment',array(
		'type' => 'radio',
		'label'     => __('Slider Content Alignment', 'architecture-building'),
		'section' => 'architecture_building_slider_section',
		'type' => 'select',
		'choices' => array(
			'LEFT-ALIGN' => __('LEFT','architecture-building'),
            'CENTER-ALIGN' => __('CENTER','architecture-building'),
            'RIGHT-ALIGN' => __('RIGHT','architecture-building'),
		),
		'priority'    => 6,
	) );

	$wp_customize->add_setting('architecture_building_slider_overlay', array(
	    'default' => '#042038',
	    'sanitize_callback' => 'sanitize_hex_color',
	    'transport' => 'refresh',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'architecture_building_slider_overlay', array(
	    'section' => 'architecture_building_slider_section',
	    'label' => esc_html__('Slider Overlay Color', 'architecture-building'),
	 	'priority'    => 7,
	)));

	$wp_customize->add_setting('architecture_building_slider_opacity',array(
        'default' => '0.7',
        'sanitize_callback' => 'architecture_building_sanitize_choices'
	));
	$wp_customize->add_control('architecture_building_slider_opacity',array(
		'type' => 'radio',
		'label'     => __('Slider Opacity', 'architecture-building'),
		'section' => 'architecture_building_slider_section',
		'type' => 'select',
		'choices' => array(
			'0' => __('0','architecture-building'),
			'0.1' => __('0.1','architecture-building'),
			'0.2' => __('0.2','architecture-building'),
			'0.3' => __('0.3','architecture-building'),
			'0.4' => __('0.4','architecture-building'),
			'0.5' => __('0.5','architecture-building'),
			'0.6' => __('0.6','architecture-building'),
			'0.7' => __('0.7','architecture-building'),
			'0.8' => __('0.8','architecture-building'),
			'0.9' => __('0.9','architecture-building'),
			'1' => __('1','architecture-building')
		),
	) );

	// Category Section
	$wp_customize->add_section( 'architecture_building_services_section' , array(
    	'title'      => __( 'Services Section Settings', 'architecture-building' ),
		'priority'   => 4,
		'panel' => 'architecture_building_custompage_panel',
	) );
	$wp_customize->add_setting( 'architecture_building_section_custom_service_heading', array(
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_section_custom_service_heading', array(
		'label'       => esc_html__( 'Services Settings', 'architecture-building' ),
		'section'     => 'architecture_building_services_section',
		'settings'    => 'architecture_building_section_custom_service_heading',
	) ) );
	$wp_customize->add_setting(
		'architecture_building_services_enable',
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
			'architecture_building_services_enable',
			array(
				'settings'        => 'architecture_building_services_enable',
				'section'         => 'architecture_building_services_section',
				'label'           => __( 'Check To Show services', 'architecture-building' ),				
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
			)
		)
	);
    $wp_customize->add_setting('architecture_building_services_heading',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('architecture_building_services_heading',array(
		'label'	=> esc_html__('Add Heading','architecture-building'),
		'section'	=> 'architecture_building_services_section',
		'type'		=> 'text',
	));
    $wp_customize->add_setting('architecture_building_services_heading_text',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('architecture_building_services_heading_text',array(
		'label'	=> esc_html__('Add Heading Text','architecture-building'),
		'section'	=> 'architecture_building_services_section',
		'type'		=> 'text',
	));

	$architecture_building_categories = get_categories();
	$cats = array();
	$i = 0;
	$cat_post[]= 'select';
	foreach($architecture_building_categories as $category){
	if($i==0){
	  $default = $category->slug;
	  $i++;
	}
	$cat_post[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('architecture_building_services_category_setting',array(
		'default' => 'select',
		'sanitize_callback' => 'architecture_building_sanitize_select',
	));
	$wp_customize->add_control('architecture_building_services_category_setting',array(
		'type'    => 'select',
		'choices' => $cat_post,
		'label' => esc_html__('Select Category to display post','architecture-building'),
		'section' => 'architecture_building_services_section',
	));

	$wp_customize->add_setting('architecture_building_services_order_type',array(
        'default' => 'ascending',
        'sanitize_callback' => 'architecture_building_sanitize_choices'
	));
	$wp_customize->add_control('architecture_building_services_order_type',array(
        'type' => 'select',
        'label' => __('Post Order','architecture-building'),
        'section' => 'architecture_building_services_section',
        'choices' => array(
            'ascending' => __('Oldest to Newest','architecture-building'),
            'descending' => __('Newest to Oldest','architecture-building'),
            'a-to-z' => __('A&rarr;Z','architecture-building'),
            'z-to-a' => __('Z&rarr;A','architecture-building'),
        ),
	) );

	$wp_customize->add_setting('architecture_building_service_count',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('architecture_building_service_count',array(
		'label'	=> esc_html__('Service Count','architecture-building'),
		'section'	=> 'architecture_building_services_section',
		'type'		=> 'number',
	));

	//Footer
    $wp_customize->add_section( 'architecture_building_footer_copyright', array(
    	'title' => esc_html__( 'Footer Text', 'architecture-building' ),
    	'priority' => 6,
    	'panel' => 'architecture_building_custompage_panel',
	) );
	$wp_customize->add_setting( 'architecture_building_section_footer_heading', array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new Architecture_Building_Customizer_Customcontrol_Section_Heading( $wp_customize, 'architecture_building_section_footer_heading', array(
		'label'       => esc_html__( 'Footer Settings', 'architecture-building' ),	
		'section'     => 'architecture_building_footer_copyright',
		'settings'    => 'architecture_building_section_footer_heading',
		'priority' => 1,
	) ) );
	$wp_customize->add_setting('architecture_building_footer_text',array(
		'default'	=> 'Architecture Building WordPress Theme',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('architecture_building_footer_text',array(
		'label'	=> esc_html__('Copyright Text','architecture-building'),
		'section'	=> 'architecture_building_footer_copyright',
		'type'		=> 'textarea'
	));
	$wp_customize->add_setting('architecture_building_footer_content_alignment',array(
        'default' => 'CENTER-ALIGN',
        'sanitize_callback' => 'architecture_building_sanitize_choices'
	));
	$wp_customize->add_control('architecture_building_footer_content_alignment',array(
		'type' => 'radio',
		'label'     => __('Footer Content Alignment', 'architecture-building'),
		'section' => 'architecture_building_footer_copyright',
		'type' => 'select',
		'choices' => array(
			'LEFT-ALIGN' => __('LEFT','architecture-building'),
            'CENTER-ALIGN' => __('CENTER','architecture-building'),
            'RIGHT-ALIGN' => __('RIGHT','architecture-building'),
		),
	) );

	$wp_customize->add_setting(
		'architecture_building_footer_widgets_show_hide',
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
			'architecture_building_footer_widgets_show_hide',
			array(
				'settings'        => 'architecture_building_footer_widgets_show_hide',
				'section'         => 'architecture_building_footer_copyright',
				'label'           => __( 'Check To show Footer Widgets', 'architecture-building' ),
				'choices'		  => array(
					'1'      => __( 'On', 'architecture-building' ),
					'off'    => __( 'Off', 'architecture-building' ),
				),
				'active_callback' => '',
			)
		)
	);
	
	$wp_customize->add_setting('architecture_building_footer_widget',array(
        'default' => '4',
        'sanitize_callback' => 'architecture_building_sanitize_choices'
	));
	$wp_customize->add_control('architecture_building_footer_widget',array(
		'type' => 'radio',
		'label'     => __('Footer Per Column', 'architecture-building'),
		'section' => 'architecture_building_footer_copyright',
		'type' => 'select',
		'choices' => array(
			'1' => __('1','architecture-building'),
            '2' => __('2','architecture-building'),
            '3' => __('3','architecture-building'),
            '4' => __('4','architecture-building'),
		)
	) );