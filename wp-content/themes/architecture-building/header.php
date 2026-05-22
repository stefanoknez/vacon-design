<?php
/**
 * The header for our theme
 *
 * @subpackage Architecture Building
 * @since 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
	if ( function_exists( 'wp_body_open' ) ) {
	    wp_body_open();
	} else {
	    do_action( 'wp_body_open' );
	}
?>
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'architecture-building' ); ?></a>
	<?php if( get_option('architecture_building_theme_loader',true) != 'off'){ ?>
		<?php $architecture_building_loader_option = get_theme_mod( 'architecture_building_loader_style','style_one');
		if($architecture_building_loader_option == 'style_one'){ ?>
			<div id="preloader" class="circle">
				<div id="loader"></div>
			</div>
		<?php }
		else if($architecture_building_loader_option == 'style_two'){ ?>
			<div id="preloader">
				<div class="spinner">
					<div class="rect1"></div>
					<div class="rect2"></div>
					<div class="rect3"></div>
					<div class="rect4"></div>
					<div class="rect5"></div>
				</div>
			</div>
		<?php }?>
	<?php }?>
	<div id="page" class="site">
		<div id="header">
			<div class="top_bar wow slideInDown py-2">
				<div class="container">
					<div class="row">
						<div class="col-lg-5 col-md-3 col-sm-3 align-self-center">
							<?php if( get_option('header_social_icon_enable',false) != 'off'){ ?>
							<?php
					            $architecture_building_header_twt_target = esc_attr(get_option('architecture_building_header_twt_target','true'));
					            $architecture_building_header_linkedin_target = esc_attr(get_option('architecture_building_header_linkedin_target','true'));
					            $architecture_building_header_youtube_target = esc_attr(get_option('architecture_building_header_youtube_target','true'));
					            $architecture_building_header_instagram_target = esc_attr(get_option('architecture_building_header_instagram_target','true'));
					          ?>  								
							<div class="linksbox">
								   <?php if( get_theme_mod('architecture_building_twitter') != ''){ ?>
					            <a target="<?php echo $architecture_building_header_twt_target !='off' ? '_blank' : '' ?>" href="<?php echo esc_url(get_theme_mod('architecture_building_twitter','')); ?>">
					              <i class="<?php echo esc_attr(get_theme_mod('architecture_building_twitter_icon','fab fa-x-twitter')); ?>"></i>
					            </a>
					          <?php }?>
					          <?php if( get_theme_mod('architecture_building_linkedin') != ''){ ?>
					            <a target="<?php echo $architecture_building_header_linkedin_target !='off' ? '_blank' : '' ?>" href="<?php echo esc_url(get_theme_mod('architecture_building_linkedin','')); ?>">
					              <i class="<?php echo esc_attr(get_theme_mod('architecture_building_linkedin_icon','fab fa-linkedin-in')); ?>"></i>
					            </a>
					          <?php }?>
					          <?php if( get_theme_mod('architecture_building_youtube') != ''){ ?>
					            <a target="<?php echo $architecture_building_header_youtube_target !='off' ? '_blank' : '' ?>" href="<?php echo esc_url(get_theme_mod('architecture_building_youtube','')); ?>">
					              <i class="<?php echo esc_attr(get_theme_mod('architecture_building_youtube_icon','fab fa-youtube')); ?>"></i>
					            </a>
					          <?php }?>
					          <?php if( get_theme_mod('architecture_building_instagram') != ''){ ?>
					            <a target="<?php echo $architecture_building_header_instagram_target !='off' ? '_blank' : '' ?>" href="<?php echo esc_url(get_theme_mod('architecture_building_instagram','')); ?>">
					              <i class="<?php echo esc_attr(get_theme_mod('architecture_building_instagram_icon','fab fa-instagram')); ?>"></i>
					            </a>
					          <?php }?>
							</div>
						<?php }?>
						</div>
						<div class="col-lg-7 col-md-9 col-sm-9 align-self-center text-center text-md-end cont-top">
							<?php if( get_theme_mod('architecture_building_top_email_address') != '' ){ ?>
								<span class="me-3 mail"><i class="<?php echo esc_attr(get_theme_mod('architecture_building_email_icon','')); ?> me-2"></i><a href="mailto:<?php echo esc_attr(get_theme_mod('architecture_building_top_email_address', '')); ?>"><?php echo esc_html(get_theme_mod('architecture_building_top_email_address', '')); ?></a></span>
							<?php }?>
							<?php if( get_theme_mod('architecture_building_top_phone_number') != '' ){ ?>
								<span class="me-3 call"><i class="<?php echo esc_attr(get_theme_mod('architecture_building_call_icon','')); ?> me-2"></i><a href="tel:<?php echo esc_attr(get_theme_mod('architecture_building_top_phone_number', '')); ?>"><?php echo esc_html(get_theme_mod('architecture_building_top_phone_number', '')); ?></a></span>
							<?php }?>
							<?php if( get_theme_mod('architecture_building_top_location') != '' ){ ?>
								<span class="location"><i class="<?php echo esc_attr(get_theme_mod('architecture_building_location_icon','')); ?> me-2"></i><a href="<?php echo esc_html(get_theme_mod('architecture_building_address_url')); ?>"><?php echo esc_html(get_theme_mod('architecture_building_top_location','')); ?></a></span>
							<?php }?>
						</div>
					</div>
				</div>
			</div>
			<div class="wrap_figure wow slideInUp">
				<div class="menu_header fixed_header py-2">
					<div class="container">
						<div class="row">
							<div class="col-lg-3 col-md-6 col-sm-6 col-12 align-self-center mb-2 mb-md-0">
								<div class="logo py-3 py-lg-0">
							        <?php if ( has_custom_logo() ) : ?>
					            		<?php the_custom_logo(); ?>
						            <?php endif; ?>
					              	<?php $architecture_building_blog_info = get_bloginfo( 'name' ); ?>
						                <?php if ( ! empty( $architecture_building_blog_info ) ) : ?>
						                  	<?php if ( is_front_page() && is_home() ) : ?>
						                  	<?php if( get_option('architecture_building_logo_title',false) != 'off'){ ?>
						                    	<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						                    <?php }?>
						                  	<?php else : ?>
						                  	<?php if( get_option('architecture_building_logo_title',false) != 'off'){ ?>
					                      		<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					                      	<?php }?>
					                  		<?php endif; ?>
						                <?php endif; ?>
						                <?php
					                  		$architecture_building_description = get_bloginfo( 'description', 'display' );
						                  	if ( $architecture_building_description || is_customize_preview() ) :
						                ?>
						                <?php if( get_option('architecture_building_logo_text',true) != 'off'){ ?>
					                  	<p class="site-description">
					                    	<?php echo esc_html($architecture_building_description); ?>
					                  	</p>
					                  	<?php }?>
					              	<?php endif; ?>
							    </div>
							</div>
							<div class="col-lg-8 col-md-3 col-sm-3 col-6 align-self-center">
									<div class="toggle-menu gb_menu text-sm-end">
										<button onclick="architecture_building_gb_Menu_open()" class="gb_toggle p-2"><i class="<?php echo esc_attr(get_theme_mod('architecture_building_menu_icon','fas fa-bars')); ?>"></i></button>
									</div>
				   				<?php get_template_part('template-parts/navigation/navigation'); ?>
							</div>
							<div class="col-lg-1 col-md-3 col-sm-3 col-6 align-self-center">
								<div class="header-search">
	              					<div class="header-search-wrapper">
						                <span class="search-main">
						                    <i class="search-icon fas fa-search"></i>
						                </span>
						                <span class="search-close-icon"><i class="fas fa-xmark"></i>
						                </span>
						                <div class="search-form-main clearfix">
						                  <?php get_search_form(); ?>
						                </div>
	              					</div>
	            				</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
