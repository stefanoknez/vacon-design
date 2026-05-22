<?php
/**
 * Custom header
 */

function architecture_building_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'architecture_building_custom_header_args', array(
		'default-image'          => get_parent_theme_file_uri( '/assets/images/header-img.png' ),
		'default-text-color'     => 'fff',
		'header-text' 			 =>	false,
		'width'                  => 1600,
		'height'                 => 100,
		'flex-width'             => true,
		'flex-height'			 => true,
		'wp-head-callback'       => 'architecture_building_header_style',
	) ) );

	register_default_headers( array(
		'default-image' => array(
			'url'           => '%s/assets/images/header-img.png',
			'thumbnail_url' => '%s/assets/images/header-img.png',
			'description'   => __( 'Default Header Image', 'architecture-building' ),
		),

		'default-image-1' => array(
			'url'           => '%s/assets/images/header-img-1.png',
			'thumbnail_url' => '%s/assets/images/header-img-1.png',
			'description'   => __( 'Default Header Image', 'architecture-building' ),
		),
	) );


}

add_action( 'after_setup_theme', 'architecture_building_custom_header_setup' );

if ( ! function_exists( 'architecture_building_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see architecture_building_custom_header_setup().
 */
add_action( 'wp_enqueue_scripts', 'architecture_building_header_style' );
function architecture_building_header_style() {
	if ( get_header_image() ) :
	$architecture_building_custom_css = "
		.header-image, .woocommerce-page .single-post-image {
			background-image:url('".esc_url(get_header_image())."');
			background-position: top;
			background-size:cover !important;
			background-repeat:no-repeat !important;
		}";
	   	wp_add_inline_style( 'architecture-building-style', $architecture_building_custom_css );
	endif;
}
endif;

