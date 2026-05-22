<?php //to use wp udpate plugin

    $home_id=''; $blog_id=''; $page_id=''; $about_id='';


    // Function to check if a page with a specific title exists
    function page_exists_by_title($title) {
      $page_query = new WP_Query(array(
          'post_type'   => 'page',
          'title'       => $title,
          'post_status' => 'publish',
          'numberposts' => 1
      ));
      
      if ($page_query->have_posts()) {
          // Return the ID of the first matching page
          $page = $page_query->posts[0];
          return $page->ID;
      }
    
      return false; // Return false if no page found
    }

    //Homepage
    $home_title = 'Home';
    if (!page_exists_by_title($home_title)) {
      $home_content = '';
      $home = array(
        'post_type'    => 'page',
        'post_title'   => $home_title,
        'post_content' => $home_content,
        'post_status'  => 'publish',
        'post_author'  => 1,
        'post_name'    => 'home'
      );

      $home_id = wp_insert_post($home);
      
      // Set the home page template
      add_post_meta($home_id, '_wp_page_template', 'page-template/custom-home-page.php');
      
      // Set the static front page
      update_option('page_on_front', $home_id);
      update_option('show_on_front', 'page');

    }else {
      // Get the ID of the existing page
      $home_id = page_exists_by_title($home_title);

      // Set the home page template
      add_post_meta($home_id, '_wp_page_template', 'page-template/custom-home-page.php');
      
      // Set the static front page
      update_option('page_on_front', $home_id);
      update_option('show_on_front', 'page');
    }
    


    // Create a Page if it doesn't exist
    if ( !page_exists_by_title('Page') ) {
      $page_title = 'Page';
      $content = 'Te obtinuit ut adepto satis somno. Aliisque institoribus iter deliciae vivet vita. Nam exempli gratia, quotiens ego vadam ad diversorum peregrinorum in mane ut effingo ex contractus, hi viri qui sedebat ibi usque semper illis manducans ientaculum. Solum cum bulla ut debui; EGO youd adepto a macula proiciendi. Sed quis scit si forte quod esset optima res pro me. sicut ea quae sentio. Qui vellem cadunt off ius desk ejus! Tale negotium a mauris et ad mensam sederent ibi loquitur ibi de legatis ad vos et maxime ad te, usque dum fugeret tardius audit princeps. Bene tamen fiduciam Ego got off semel';

      $ot_page = array(
        'post_type'     => 'page',
        'post_title'    => $page_title,
        'post_content'  => $content,
        'post_status'   => 'publish',
        'post_author'   => 1,
        'post_name'     => 'page'
      );
      $page_id = wp_insert_post($ot_page);
    }else {
      // Get the ID of the existing page
      $ot_page = page_exists_by_title('Page');
    }

    if ( !page_exists_by_title('Page Left Sidebar') ) {
      $page_title = 'Page Left Sidebar';
      $content = 'Te obtinuit ut adepto satis somno. Aliisque institoribus iter deliciae vivet vita. Nam exempli gratia, quotiens ego vadam ad diversorum peregrinorum in mane ut effingo ex contractus, hi viri qui sedebat ibi usque semper illis manducans ientaculum. Solum cum bulla ut debui; EGO youd adepto a macula proiciendi. Sed quis scit si forte quod esset optima res pro me. sicut ea quae sentio. Qui vellem cadunt off ius desk ejus! Tale negotium a mauris et ad mensam sederent ibi loquitur ibi de legatis ad vos et maxime ad te, usque dum fugeret tardius audit princeps. Bene tamen fiduciam Ego got off semelTe obtinuit ut adepto satis somno. Aliisque institoribus iter deliciae vivet vita. Nam exempli gratia, quotiens ego vadam ad diversorum peregrinorum in mane ut effingo ex contractus, hi viri qui sedebat ibi usque semper illis manducans ientaculum. Solum cum bulla ut debui; EGO youd adepto a macula proiciendi. Sed quis scit si forte quod esset optima res pro me. sicut ea quae sentio. Qui vellem cadunt off ius desk ejus! Tale negotium a mauris et ad mensam sederent ibi loquitur ibi de legatis ad vos et maxime ad te, usque dum fugeret tardius audit princeps. Bene tamen fiduciam Ego got off semel.Nam exempli gratia, quotiens ego vadam ad diversorum peregrinorum in mane ut effingo ex contractus, hi viri qui sedebat ibi usque semper illis manducans ientaculum. Solum cum bulla ut debui; EGO youd adepto a macula proiciendi. Sed quis scit si forte quod esset optima res pro me. sicut ea quae sentio. Qui vellem cadunt off ius desk ejus! Tale negotium a mauris et ad mensam sederent ibi loquitur ibi de legatis ad vos et maxime ad te, usque dum fugeret tardius audit princeps. Bene tamen fiduciam Ego got off semel.';

      $ot_page = array(
        'post_type'     => 'page',
        'post_title'    => $page_title,
        'post_content'  => $content,
        'post_status'   => 'publish',
        'post_author'   => 1,
        'post_name'     => 'page-left'
      );
      $page_id = wp_insert_post($ot_page);

      // Set the page template
      add_post_meta($page_id, '_wp_page_template', 'page-template/left-sidebar.php');
    }else {
      // Get the ID of the existing page
      $ot_page = page_exists_by_title('Page Left Sidebar');
    }

    if ( !page_exists_by_title('Page Right Sidebar') ) {
      $page_title = 'Page Right Sidebar';
      $content = 'Te obtinuit ut adepto satis somno. Aliisque institoribus iter deliciae vivet vita. Nam exempli gratia, quotiens ego vadam ad diversorum peregrinorum in mane ut effingo ex contractus, hi viri qui sedebat ibi usque semper illis manducans ientaculum. Solum cum bulla ut debui; EGO youd adepto a macula proiciendi. Sed quis scit si forte quod esset optima res pro me. sicut ea quae sentio. Qui vellem cadunt off ius desk ejus! Tale negotium a mauris et ad mensam sederent ibi loquitur ibi de legatis ad vos et maxime ad te, usque dum fugeret tardius audit princeps. Bene tamen fiduciam Ego got off semelTe obtinuit ut adepto satis somno. Aliisque institoribus iter deliciae vivet vita. Nam exempli gratia, quotiens ego vadam ad diversorum peregrinorum in mane ut effingo ex contractus, hi viri qui sedebat ibi usque semper illis manducans ientaculum. Solum cum bulla ut debui; EGO youd adepto a macula proiciendi. Sed quis scit si forte quod esset optima res pro me. sicut ea quae sentio. Qui vellem cadunt off ius desk ejus! Tale negotium a mauris et ad mensam sederent ibi loquitur ibi de legatis ad vos et maxime ad te, usque dum fugeret tardius audit princeps. Bene tamen fiduciam Ego got off semel.Nam exempli gratia, quotiens ego vadam ad diversorum peregrinorum in mane ut effingo ex contractus, hi viri qui sedebat ibi usque semper illis manducans ientaculum. Solum cum bulla ut debui; EGO youd adepto a macula proiciendi. Sed quis scit si forte quod esset optima res pro me. sicut ea quae sentio. Qui vellem cadunt off ius desk ejus! Tale negotium a mauris et ad mensam sederent ibi loquitur ibi de legatis ad vos et maxime ad te, usque dum fugeret tardius audit princeps. Bene tamen fiduciam Ego got off semel.';

      $ot_page = array(
        'post_type'     => 'page',
        'post_title'    => $page_title,
        'post_content'  => $content,
        'post_status'   => 'publish',
        'post_author'   => 1,
        'post_name'     => 'page-right'
      );
      $page_id = wp_insert_post($ot_page);

      // Set the page template
      add_post_meta($page_id, '_wp_page_template', 'page-template/right-sidebar.php');
    }else {
      // Get the ID of the existing page
      $ot_page = page_exists_by_title('Page Right Sidebar');
    }

    if ( ! page_exists_by_title('50 Years Of Experience In Industry') ) {
      $civil_engineering_page_title = '50 Years Of Experience In Industry';
      $content = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur accusantium.Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem ut aliquip ommodo consequat.';

      $civil_engineering_about_page = array(
          'post_type'     => 'page',
          'post_title'    => $civil_engineering_page_title,
          'post_content'  => $content,
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_name'     => 'service'
      );
      $civil_engineering_about_page_id = wp_insert_post($civil_engineering_about_page);

      $civil_engineering_about_image_url = get_stylesheet_directory_uri().'/assets/image.jpg';

      $civil_engineering_about_image_name = 'image.jpg';
      $civil_engineering_about_upload_dir       = wp_upload_dir(); 
      // Set upload folder
      $civil_engineering_about_image_data       = file_get_contents($civil_engineering_about_image_url); 
       
      // Get image data
      $civil_engineering_about_unique_file_name = wp_unique_filename( $civil_engineering_about_upload_dir['path'], $civil_engineering_about_image_name ); 
      // Generate unique name
      $filename= basename( $civil_engineering_about_unique_file_name ); 
      // Create image file name
      // Check folder permission and define file location
      if( wp_mkdir_p( $civil_engineering_about_upload_dir['path'] ) ) {
          $file = $civil_engineering_about_upload_dir['path'] . '/' . $filename;
      } else {
          $file = $civil_engineering_about_upload_dir['basedir'] . '/' . $filename;
      }
      file_put_contents( $file, $civil_engineering_about_image_data );
      $wp_filetype = wp_check_filetype( $filename, null );
      $civil_engineering_about_attachment = array(
          'post_mime_type' => $wp_filetype['type'],
          'post_title'     => sanitize_file_name( $filename ),
          'post_content'   => '',
          'post_status'    => 'inherit'
      );
      $attach_id = wp_insert_attachment( $civil_engineering_about_attachment, $file, $civil_engineering_about_page_id );
      require_once(ABSPATH . 'wp-admin/includes/image.php');
      $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
          wp_update_attachment_metadata( $attach_id, $attach_data );
          set_post_thumbnail( $civil_engineering_about_page_id, $attach_id );
    } else {
      // Get the ID of the existing page
      $civil_engineering_about_page_id = page_exists_by_title('50 Years Of Experience In Industry');
    }

    // ------- Create Left Menu --------
    $menuname =  'Main Menu';
    $bpmenulocation = 'primary';
    $menu_exists = wp_get_nav_menu_object( $menuname );

    if (!$menu_exists) {
      // Create the menu
      $menu_id = wp_create_nav_menu($menuname);

      // Add the HOME item
      wp_update_nav_menu_item($menu_id, 0, array(
          'menu-item-title'  => __('Home', 'civil-engineering'),
          'menu-item-classes' => 'home',
          'menu-item-url'     => home_url('/index.php/home/'),
          'menu-item-status'  => 'publish'
      ));

      // Add the PAGE item
      $parent_page_item_id = wp_update_nav_menu_item($menu_id, 0, array(
          'menu-item-title'  => __('Pages', 'civil-engineering'),
          'menu-item-classes' => 'page',
          'menu-item-url'     => home_url('/index.php/page/'),
          'menu-item-status'  => 'publish'
      ));

      // Add the Page Left Sidebar item as a child of PAGE
      wp_update_nav_menu_item($menu_id, 0, array(
          'menu-item-title'   => __('Page Left Sidebar', 'civil-engineering'),
          'menu-item-classes' => 'page-left',
          'menu-item-url'     => home_url('/index.php/page-left/'),
          'menu-item-status'  => 'publish',
          'menu-item-parent-id' => $parent_page_item_id
      ));

      // Add the Page Right Sidebar item as a child of PAGE
      wp_update_nav_menu_item($menu_id, 0, array(
          'menu-item-title'   => __('Page Right Sidebar', 'civil-engineering'),
          'menu-item-classes' => 'page-right',
          'menu-item-url'     => home_url('/index.php/page-right/'),
          'menu-item-status'  => 'publish',
          'menu-item-parent-id' => $parent_page_item_id
      ));

      wp_update_nav_menu_item($menu_id, 0, array(
          'menu-item-title'  => __('Projects', 'civil-engineering'),
          'menu-item-classes' => 'projects',
          'menu-item-url'     => '#',
          'menu-item-status'  => 'publish'
      ));

      wp_update_nav_menu_item($menu_id, 0, array(
          'menu-item-title'  => __('Portfolio', 'civil-engineering'),
          'menu-item-classes' => 'portfolio',
          'menu-item-url'     => '#',
          'menu-item-status'  => 'publish'
      ));

      wp_update_nav_menu_item($menu_id, 0, array(
          'menu-item-title'  => __('Contact', 'civil-engineering'),
          'menu-item-classes' => 'contact',
          'menu-item-url'     => '#',
          'menu-item-status'  => 'publish'
      ));
      
      // Assign the menu to the desired location if not already assigned
      if (!has_nav_menu($bpmenulocation)) {
          $locations = get_theme_mod('nav_menu_locations');
          $locations[$bpmenulocation] = $menu_id;
          set_theme_mod('nav_menu_locations', $locations);
      }
    }
       
    // --------Header------------------------

    set_theme_mod( 'architecture_building_top_email_address', 'info@example.com' ); 

    set_theme_mod( 'architecture_building_email_icon', 'fas fa-envelope' ); 

    set_theme_mod( 'architecture_building_top_phone_number', '+1 23 456 7890' ); 

    set_theme_mod( 'architecture_building_call_icon', 'fas fa-phone' ); 

    set_theme_mod( 'architecture_building_top_location', 'No.40 Marie Sreet 15/2 NewYork City, USA' ); 

    set_theme_mod( 'architecture_building_location_icon', 'fas fa-map-marker-alt' ); 

    // --------Social Icons------------------------

    set_theme_mod('architecture_building_twitter','https://x.com/');

    set_theme_mod('architecture_building_linkedin','https://www.linkedin.com/');

    set_theme_mod('architecture_building_youtube','https://www.youtube.com/');

    set_theme_mod('architecture_building_instagram','https://www.instagram.com/');

    //-------------- Slider-----------------------

    set_theme_mod('architecture_building_slider_count','4');

    $slider_category = wp_create_category('slider');

    for($i=1;$i<=4;$i++){

      $title = 'We Design Your Future';
      $content = 'Lorem ipsum dolor sit amet, consectetur adopesi cing elit, sed do eiusmod tempor incunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation';

      // Create post object
      $architecture_building_my_post = array(
       'post_title'    => wp_strip_all_tags( $title ),
       'post_content'  => $content,
       'post_status'   => 'publish',
       'post_type'     => 'post',
       'post_category' => array($slider_category)
      );

      $architecture_building_slider_post_id = wp_insert_post($architecture_building_my_post);

      $architecture_building_post_image_url = get_template_directory_uri().'/assets/images/header-img-1.png';

      $architecture_building_image_name = 'header-img-1.png';
      $architecture_building_upload_dir       = wp_upload_dir(); 
      // Set upload folder
      $architecture_building_image_data       = file_get_contents($architecture_building_post_image_url); 
       
      // Get image data
      $architecture_building_unique_file_name = wp_unique_filename( $architecture_building_upload_dir['path'], $architecture_building_image_name ); 
      // Generate unique name
      $filename= basename( $architecture_building_unique_file_name ); 
      // Create image file name
      // Check folder permission and define file location
      if( wp_mkdir_p( $architecture_building_upload_dir['path'] ) ) {
          $file = $architecture_building_upload_dir['path'] . '/' . $filename;
      } else {
          $file = $architecture_building_upload_dir['basedir'] . '/' . $filename;
      }
      file_put_contents( $file, $architecture_building_image_data );
      $wp_filetype = wp_check_filetype( $filename, null );
      $architecture_building_attachment = array(
          'post_mime_type' => $wp_filetype['type'],
          'post_title'     => sanitize_file_name( $filename ),
          'post_content'   => '',
          'post_type'     => 'post',
          'post_status'    => 'inherit'
      );
      $attach_id = wp_insert_attachment( $architecture_building_attachment, $file, $architecture_building_slider_post_id );
      require_once(ABSPATH . 'wp-admin/includes/image.php');
      $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
          wp_update_attachment_metadata( $attach_id, $attach_data );
          set_post_thumbnail( $architecture_building_slider_post_id, $attach_id );

    }

    set_theme_mod('architecture_building_post_setting', 'slider');

    //-------------- contact us-----------------------

    set_theme_mod('civil_engineering_contact_us_heading','Already have an excellent idea!');

    set_theme_mod('civil_engineering_contact_us_text','And want to know whether it is posssible to implement it?');

    set_theme_mod('civil_engineering_contact_us_btn_url','#');

    set_theme_mod('civil_engineering_contact_us_btn_text','See New Projects');

    //-------------- Service-----------------------

    set_theme_mod( 'architecture_building_services_heading', 'Services We Offer' ); 

    set_theme_mod( 'architecture_building_services_heading_text', 'Lorem ipsum dolor sit amet, consectetur adopesi cing elit, sed do eiusmod tempor incunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,' ); 

    $architecture_building_service_category = wp_create_category('Our Services'); 

    $architecture_building_service_title=array('Architecture','Interior','Sustainable Design');

    set_theme_mod( 'architecture_building_service_count', '3' );

    for($i=1;$i<=3;$i++){

      $title = $architecture_building_service_title[$i-1];
      $content = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.';

      // Create post object
      $architecture_building_my_post = array(
       'post_title'    => wp_strip_all_tags( $title ),
       'post_content'  => $content,
       'post_status'   => 'publish',
       'post_type'     => 'post',
       'post_category' => array($architecture_building_service_category),
      );

      $architecture_building_service_post_id = wp_insert_post($architecture_building_my_post);

      $architecture_building_service_post_image_url = get_template_directory_uri().'/assets/images/image'.$i.'.jpg';

      $architecture_building_service_image_name = 'image'.$i.'.jpg';
      $architecture_building_service_upload_dir       = wp_upload_dir(); 
      // Set upload folder
      $architecture_building_service_image_data       = file_get_contents($architecture_building_service_post_image_url); 
       
      // Get image data
      $architecture_building_service_unique_file_name = wp_unique_filename( $architecture_building_service_upload_dir['path'], $architecture_building_service_image_name ); 
      // Generate unique name
      $filename= basename( $architecture_building_service_unique_file_name ); 
      // Create image file name
      // Check folder permission and define file location
      if( wp_mkdir_p( $architecture_building_service_upload_dir['path'] ) ) {
          $file = $architecture_building_service_upload_dir['path'] . '/' . $filename;
      } else {
          $file = $architecture_building_service_upload_dir['basedir'] . '/' . $filename;
      }
      file_put_contents( $file, $architecture_building_service_image_data );
      $wp_filetype = wp_check_filetype( $filename, null );
      $architecture_building_service_attachment = array(
          'post_mime_type' => $wp_filetype['type'],
          'post_title'     => sanitize_file_name( $filename ),
          'post_content'   => '',
          'post_type'     => 'post',
          'post_status'    => 'inherit'
      );
      $attach_id = wp_insert_attachment( $architecture_building_service_attachment, $file, $architecture_building_service_post_id );
      require_once(ABSPATH . 'wp-admin/includes/image.php');
      $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
          wp_update_attachment_metadata( $attach_id, $attach_data );
          set_post_thumbnail( $architecture_building_service_post_id, $attach_id );

    }

    set_theme_mod( 'architecture_building_services_category_setting', 'Our Services' );

    //-------------- About Us-----------------------

    set_theme_mod('civil_engineering_about_us_title','we are ready to build your dream home');

    set_theme_mod( 'civil_engineering_about_us_settigs', $civil_engineering_about_page_id );
  ?>