<?php
/**
 * Template Name: Custom Home Page
 */
get_header(); ?>

<main id="content">
<?php if( get_option('architecture_building_slider_arrows', false) !== 'off'){ ?>
  <section id="slider">
    <div class="owl-carousel">
      <?php
        $civil_engineering_slider_category=  get_theme_mod('architecture_building_post_setting');if($civil_engineering_slider_category){
        $civil_engineering_page_query = new WP_Query(array( 

              'category_name' => esc_html($civil_engineering_slider_category ,'civil-engineering'),

              'posts_per_page' => get_theme_mod('architecture_building_slider_count')

            ));?>
          <?php while( $civil_engineering_page_query->have_posts() ) : $civil_engineering_page_query->the_post(); ?>
          <div class="slide-box">
            <?php if(has_post_thumbnail()){ ?>
              <img src="<?php the_post_thumbnail_url('full'); ?>"/>
            <?php }else{?>
              <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/header-img-1.png" alt="" />
            <?php } ?>
            <div class="slide-inner-box">
              <h2 class="slider-title"><?php the_title();?></h2>
              <?php if( get_option('architecture_building_slider_excerpt_show_hide',false) != 'off'){ ?>
                <p class="slider-excerpt mb-0"><?php echo wp_trim_words(get_the_content(), get_theme_mod('architecture_building_slider_excerpt_count',20) );?></p>
              <?php } ?>
              <div class="home-btn my-4">
                <a href="<?php the_permalink(); ?>"><?php echo esc_html(get_theme_mod('architecture_building_slider_read_more',__('Get a quote','civil-engineering'))); ?></a>
              </div>
            </div>
          </div>
          <?php endwhile;
        wp_reset_postdata();
      }?>
    </div>
  </section>
<?php }?>
<?php if( get_option('civil_engineering_contact_enable', false) !== 'off'){ ?>
  <section id="contact-us" class="py-4 text-center text-sm-start">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 align-self-center">
          <?php if( get_theme_mod('civil_engineering_contact_us_heading') != ''){ ?>
            <h3><?php echo esc_html(get_theme_mod('civil_engineering_contact_us_heading','')); ?></h3>
          <?php }?>
          <?php if( get_theme_mod('civil_engineering_contact_us_text') != ''){ ?>
            <p class="mb-0"><?php echo esc_html(get_theme_mod('civil_engineering_contact_us_text','')); ?></p>
          <?php }?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 align-self-center">
          <?php if( get_theme_mod('civil_engineering_contact_us_btn_url') != '' || get_theme_mod('civil_engineering_contact_us_btn_text') != ''){ ?>
            <div class="contact-btn text-center text-sm-end my-4 my-md-0">
              <a href="<?php echo esc_url(get_theme_mod('civil_engineering_contact_us_btn_url','')); ?>"><?php echo esc_html(get_theme_mod('civil_engineering_contact_us_btn_text','')); ?></a>
            </div>
          <?php }?>
        </div>
      </div>
    </div>
  </section>
<?php }?>  
<?php if( get_option('architecture_building_services_enable', false) !== 'off'){ ?>
  <section id="home-services" class="py-5">
    <div class="container">
      <?php if( get_theme_mod('architecture_building_services_heading') != ''){ ?>
        <div class="text-center">
          <h3><?php echo esc_html(get_theme_mod('architecture_building_services_heading','')); ?></h3>
        </div>
      <?php }?>
      <?php if( get_theme_mod('architecture_building_services_heading_text') != ''){ ?>
        <div class="service-text">
          <p class="text-center"><?php echo esc_html(get_theme_mod('architecture_building_services_heading_text','')); ?></p>
        </div>
      <?php }?>
      <div class="row pt-4">
        <?php
          $civil_engineering_project_category=  get_theme_mod('architecture_building_services_category_setting');
          $architecture_building_services_order = get_theme_mod('architecture_building_services_order_type','ascending');
          if($civil_engineering_project_category){
            $architecture_building_args = array( 

              'category_name' => esc_html($civil_engineering_project_category ,'civil-engineering'),

              'posts_per_page' => get_theme_mod('architecture_building_service_count'),

              'order'         => 'ASC'

            );
            // Adjust ordering based on user selection
            if ($architecture_building_services_order == 'descending') {
              $architecture_building_args['order'] = 'DESC';
            } else if ($architecture_building_services_order == 'a-to-z') {
              $architecture_building_args['orderby'] = 'title';
              $architecture_building_args['order'] = 'ASC';
            } else if ($architecture_building_services_order == 'z-to-a') {
              $architecture_building_args['orderby'] = 'title';
              $architecture_building_args['order'] = 'DESC';
            }
          $civil_engineering_page_query = new WP_Query($architecture_building_args);?>
            <?php while( $civil_engineering_page_query->have_posts() ) : $civil_engineering_page_query->the_post(); ?>
              <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="box mb-4">
                  <?php if(has_post_thumbnail()){ ?>
                    <?php the_post_thumbnail(); ?>
                  <?php }?>
                  <div class="box-conetnt-title">
                    <h4 class="title"><?php the_title();?></h4>
                  </div>
                  <div class="box-content">
                    <h4 class="title"><?php the_title();?></h4>
                    <p class="mb-0"><?php echo wp_trim_words( get_the_content(),20 );?></p>
                    <div class="home-btn my-2">
                      <a href="<?php the_permalink(); ?>"><?php esc_html_e('Get a Quote','civil-engineering'); ?></a>
                    </div>
                  </div>
                </div>
              </div>
            <?php endwhile;
          wp_reset_postdata();
        }?>
      </div>
    </div>
  </section>
<?php }?>
<?php if( get_option('civil_engineering_about_us_enable', false) !== 'off'){ ?>
  <?php if( get_theme_mod('civil_engineering_about_us_title') != '' || get_theme_mod('civil_engineering_about_us_settigs') != ''){ ?>
    <section id="about-us" class="py-5">
      <div class="container">
        <div class="row">
          <?php
            $civil_engineering_mod =  get_theme_mod( 'civil_engineering_about_us_settigs');
            if ( 'page-none-selected' != $civil_engineering_mod ) {
              $construction_firm_about_page[] = $civil_engineering_mod;
            }
            if( !empty($construction_firm_about_page) ) :
            $civil_engineering_args = array(
              'post_type' =>array('page'),
              'post__in' => $construction_firm_about_page
            );
            $civil_engineering_query = new WP_Query( $civil_engineering_args );
            if ( $civil_engineering_query->have_posts() ) :
          ?>
          <?php  while ( $civil_engineering_query->have_posts() ) : $civil_engineering_query->the_post(); ?>
            <div class="col-lg-6 col-md-6 align-self-center">
              <div class="img-box">
                <?php
                  $civil_engineering_content = apply_filters( 'the_content', get_the_content() );
                  $civil_engineering_video = false;
                  // Only get video from the content if a playlist isn't present.
                  if ( false === strpos( $civil_engineering_content, 'wp-playlist-script' ) ) {
                    $civil_engineering_video = get_media_embedded_in_content( $civil_engineering_content, array( 'video', 'object', 'embed', 'iframe' ) );
                  }
                ?>
                <?php
                  if ( ! is_single() ) {
                    // If not a single post, highlight the video file.
                    if ( ! empty( $civil_engineering_video ) ) {
                      foreach ( $civil_engineering_video as $civil_engineering_video_html ) {
                        echo '<div class="entry-video">';
                          echo $civil_engineering_video_html;
                        echo '</div>';
                      }
                    } else {
                      if(has_post_thumbnail()){ ?>
                         <?php the_post_thumbnail(); ?>
                      <?php } 
                    }
                  };
                ?>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 align-self-center">
              <h3><?php the_title();?></h3>
              <h4><?php echo esc_html( get_theme_mod( 'civil_engineering_about_us_title','') ); ?></h4>
              <p class="mb-0"><?php echo wp_trim_words( get_the_content(),50 );?></p>
              <div class="home-btn my-2">
                <a href="<?php the_permalink(); ?>"><?php esc_html_e('Read More','civil-engineering'); ?></a>
              </div>
            </div>
          <?php endwhile;
          wp_reset_postdata();?>
          <?php else : ?>
          <div class="no-postfound"></div>
            <?php endif;
          endif;?>
        </div>
      </div>
    </section>
  <?php }?>
<?php }?>
<section id="custom-page-content" <?php if ( have_posts() && trim( get_the_content() ) !== '' ) echo 'class="pt-3"'; ?>>
    <div class="container">
      <?php while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; ?>
    </div>
  </section>
</main>

<?php get_footer(); ?>
