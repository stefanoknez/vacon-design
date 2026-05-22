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
          $architecture_building_slider_category=  get_theme_mod('architecture_building_post_setting');if($architecture_building_slider_category){
          $architecture_building_page_query = new WP_Query(array( 

              'category_name' => esc_html($architecture_building_slider_category ,'architecture-building'),

              'posts_per_page' => get_theme_mod('architecture_building_slider_count')

            ));?>
            <?php while( $architecture_building_page_query->have_posts() ) : $architecture_building_page_query->the_post(); ?>
            <div class="slide-box">
               <?php if(has_post_thumbnail()){ ?>
                <img src="<?php the_post_thumbnail_url('full'); ?>"/>
              <?php }else{?>
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/slider2.png" alt="" />
              <?php } ?>
              <div class="slide-inner-box slider-inner">
                <h2 class="slider-title"><?php the_title();?></h2>
                <?php if( get_option('architecture_building_slider_excerpt_show_hide',false) != 'off'){ ?>
                  <p class="slider-excerpt mb-0"><?php echo wp_trim_words(get_the_content(), get_theme_mod('architecture_building_slider_excerpt_count',20) );?></p>
                <?php } ?>
                <div class="home-btn my-4">
                  <a href="<?php the_permalink(); ?>"><?php echo esc_html(get_theme_mod('architecture_building_slider_read_more',__('Get a quote','architecture-building'))); ?></a>
                </div>
              </div>
            </div>
            <?php endwhile;
          wp_reset_postdata();
        }?>
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
          $architecture_building_project_category=  get_theme_mod('architecture_building_services_category_setting');
          $architecture_building_services_order = get_theme_mod('architecture_building_services_order_type','ascending');
          if($architecture_building_project_category){
            $architecture_building_args = array( 

              'category_name' => esc_html($architecture_building_project_category ,'architecture-building'),

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
            $architecture_building_page_query = new WP_Query($architecture_building_args);?>
            <?php while( $architecture_building_page_query->have_posts() ) : $architecture_building_page_query->the_post(); ?>
              <div class="col-lg-4 col-sm-4">
                <div class="box mb-4 wow zoomIn">
                  <?php if(has_post_thumbnail()){ ?>
                    <?php the_post_thumbnail(); ?>
                  <?php }?>
                  <div class="box-conetnt-title">
                    <h4 class="title"><?php the_title();?></h4>
                  </div>
                  <div class="box-content">
                    <h4 class="title"><?php the_title();?></h4>
                    <p class="mb-0"><?php echo wp_trim_words( get_the_content(), 10 );?></p>
                    <div class="home-btn my-2">
                      <a href="<?php the_permalink(); ?>"><?php esc_html_e('Read More','architecture-building'); ?></a>
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
  <section id="custom-page-content" <?php if ( have_posts() && trim( get_the_content() ) !== '' ) echo 'class="pt-3"'; ?>>
    <div class="container">
      <?php while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; ?>
    </div>
  </section>
</main>

<?php get_footer(); ?>
