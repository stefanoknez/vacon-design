<?php

$architecture_building_custom_style= "";

/*---------------------------Scroll-top-position -------------------*/

$architecture_building_scroll_options = get_theme_mod( 'architecture_building_scroll_options','right_align');

if($architecture_building_scroll_options == 'right_align'){

$architecture_building_custom_style .='.scroll-top button{';

	$architecture_building_custom_style .='';

$architecture_building_custom_style .='}';

}else if($architecture_building_scroll_options == 'center_align'){

$architecture_building_custom_style .='.scroll-top button{';

	$architecture_building_custom_style .='right: 0; left:0; margin: 0 auto; top:85% !important';

$architecture_building_custom_style .='}';

}else if($architecture_building_scroll_options == 'left_align'){

$architecture_building_custom_style .='.scroll-top button{';

	$architecture_building_custom_style .='right: auto; left:5%; margin: 0 auto';

$architecture_building_custom_style .='}';
}

/*---------------------------text-transform-------------------*/

$architecture_building_text_transform = get_theme_mod( 'architecture_building_menu_text_transform','CAPITALISE');
if($architecture_building_text_transform == 'CAPITALISE'){

$architecture_building_custom_style .='nav#top_gb_menu ul li a{';

	$architecture_building_custom_style .='text-transform: capitalize ;';

$architecture_building_custom_style .='}';

}else if($architecture_building_text_transform == 'UPPERCASE'){

$architecture_building_custom_style .='nav#top_gb_menu ul li a{';

	$architecture_building_custom_style .='text-transform: uppercase ;';

$architecture_building_custom_style .='}';

}else if($architecture_building_text_transform == 'LOWERCASE'){

$architecture_building_custom_style .='nav#top_gb_menu ul li a{';

	$architecture_building_custom_style .='text-transform: lowercase ;';

$architecture_building_custom_style .='}';
}

/*-------------------------Slider-content-alignment-------------------*/

$architecture_building_slider_content_alignment = get_theme_mod( 'architecture_building_slider_content_alignment','CENTER-ALIGN');

if($architecture_building_slider_content_alignment == 'LEFT-ALIGN'){

$architecture_building_custom_style .='.slider-inner{';

	$architecture_building_custom_style .='text-align:left;';

$architecture_building_custom_style .='}';


}else if($architecture_building_slider_content_alignment == 'CENTER-ALIGN'){

$architecture_building_custom_style .='.slider-inner{';

	$architecture_building_custom_style .='text-align:center;';

$architecture_building_custom_style .='}';


}else if($architecture_building_slider_content_alignment == 'RIGHT-ALIGN'){

$architecture_building_custom_style .='.slider-inner{';

	$architecture_building_custom_style .='text-align:right;';

$architecture_building_custom_style .='}';

}

//--------------------sticky header----------------------
if (false === get_option('architecture_building_sticky_header')) {
	    add_option('architecture_building_sticky_header', 'off');
	}

	// Define the custom CSS based on the 'architecture_building_sticky_header' option

	if (get_option('architecture_building_sticky_header', 'off') !== 'on') {
	    $architecture_building_custom_style .= '.fixed_header.fixed {';
	    $architecture_building_custom_style .= 'position: static;';
	    $architecture_building_custom_style .= '}';
	}

	if (get_option('architecture_building_sticky_header', 'off') !== 'off') {
	    $architecture_building_custom_style .= '.fixed_header.fixed {';
	    $architecture_building_custom_style .= 'position: fixed; background: var(--theme-primary-color);';
	    $architecture_building_custom_style .= '}';

	    $architecture_building_custom_style .= '.admin-bar .fixed {';
	    $architecture_building_custom_style .= ' margin-top: 32px;';
	    $architecture_building_custom_style .= '}';
	}

// logo max height
$architecture_building_logo_max_height = get_theme_mod('architecture_building_logo_max_height','100');

if($architecture_building_logo_max_height != false){

$architecture_building_custom_style .='.custom-logo-link img{';

	$architecture_building_custom_style .='max-height: '.esc_html($architecture_building_logo_max_height).'px;';

$architecture_building_custom_style .='}';
}

/*---------------------------Width -------------------*/
	
$architecture_building_theme_width = get_theme_mod( 'architecture_building_width_options','full_width');

if($architecture_building_theme_width == 'full_width'){

$architecture_building_custom_style .='body{';

	$architecture_building_custom_style .='max-width: 100%;';

$architecture_building_custom_style .='}';

}else if($architecture_building_theme_width == 'container'){

$architecture_building_custom_style .='body{';

	$architecture_building_custom_style .='width: 100%; padding-right: 15px; padding-left: 15px;  margin-right: auto !important; margin-left: auto !important;';

$architecture_building_custom_style .='}';

$architecture_building_custom_style .='@media screen and (min-width: 601px){';

$architecture_building_custom_style .='body{';

    $architecture_building_custom_style .='max-width: 720px;';
    
$architecture_building_custom_style .='} }';

$architecture_building_custom_style .='@media screen and (min-width: 992px){';

$architecture_building_custom_style .='body{';

    $architecture_building_custom_style .='max-width: 960px;';
    
$architecture_building_custom_style .='} }';

$architecture_building_custom_style .='@media screen and (min-width: 1200px){';

$architecture_building_custom_style .='body{';

    $architecture_building_custom_style .='max-width: 1140px;';
    
$architecture_building_custom_style .='} }';

$architecture_building_custom_style .='@media screen and (min-width: 1400px){';

$architecture_building_custom_style .='body{';

    $architecture_building_custom_style .='max-width: 1320px;';
    
$architecture_building_custom_style .='} }';

$architecture_building_custom_style .='@media screen and (max-width:600px){';

$architecture_building_custom_style .='body{';

    $architecture_building_custom_style .='max-width: 100%; padding-right:0px; padding-left: 0px';
    
$architecture_building_custom_style .='} }';


}else if($architecture_building_theme_width == 'container_fluid'){

$architecture_building_custom_style .='body{';

	$architecture_building_custom_style .='width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;';

$architecture_building_custom_style .='}';

$architecture_building_custom_style .='@media screen and (max-width:600px){';

$architecture_building_custom_style .='body{';

    $architecture_building_custom_style .='max-width: 100%; padding-right:0px; padding-left: 0px';
    
$architecture_building_custom_style .='} }';
}

//related products
if( get_option( 'architecture_building_related_product',true) != 'on') {

$architecture_building_custom_style .='.related.products{';

	$architecture_building_custom_style .='display: none;';
	
$architecture_building_custom_style .='}';
}

if( get_option( 'architecture_building_related_product',true) != 'off') {

$architecture_building_custom_style .='.related.products{';

	$architecture_building_custom_style .='display: block;';
	
$architecture_building_custom_style .='}';
}

// footer text alignment
$architecture_building_footer_content_alignment = get_theme_mod( 'architecture_building_footer_content_alignment','CENTER-ALIGN');

if($architecture_building_footer_content_alignment == 'LEFT-ALIGN'){

$architecture_building_custom_style .='.site-info{';

	$architecture_building_custom_style .='text-align:left; padding-left: 30px;';

$architecture_building_custom_style .='}';

$architecture_building_custom_style .='.site-info a{';

	$architecture_building_custom_style .='padding-left: 30px;';

$architecture_building_custom_style .='}';


}else if($architecture_building_footer_content_alignment == 'CENTER-ALIGN'){

$architecture_building_custom_style .='.site-info{';

	$architecture_building_custom_style .='text-align:center;';

$architecture_building_custom_style .='}';


}else if($architecture_building_footer_content_alignment == 'RIGHT-ALIGN'){

$architecture_building_custom_style .='.site-info{';

	$architecture_building_custom_style .='text-align:right; padding-right: 30px;';

$architecture_building_custom_style .='}';

$architecture_building_custom_style .='.site-info a{';

	$architecture_building_custom_style .='padding-right: 30px;';

$architecture_building_custom_style .='}';

}

// slider button
$mobile_button_setting = get_option('architecture_building_slider_button_mobile_show_hide', '1');
$main_button_setting = get_option('architecture_building_slider_button_show_hide', '1');

$architecture_building_custom_style .= '#slider .home-btn {';

if ($main_button_setting == 'off') {
    $architecture_building_custom_style .= 'display: none;';
}

$architecture_building_custom_style .= '}';

// Add media query for mobile devices
$architecture_building_custom_style .= '@media screen and (max-width: 600px) {';
if ($main_button_setting == 'off' || $mobile_button_setting == 'off') {
    $architecture_building_custom_style .= '#slider .home-btn { display: none; }';
}
$architecture_building_custom_style .= '}';


// scroll button
$mobile_scroll_setting = get_option('architecture_building_scroll_enable_mobile', '1');
$main_scroll_setting = get_option('architecture_building_scroll_enable', '1');

$architecture_building_custom_style .= '.scrollup {';

if ($main_scroll_setting == 'off') {
    $architecture_building_custom_style .= 'display: none;';
}

$architecture_building_custom_style .= '}';

// Add media query for mobile devices
$architecture_building_custom_style .= '@media screen and (max-width: 600px) {';
if ($main_scroll_setting == 'off' || $mobile_scroll_setting == 'off') {
    $architecture_building_custom_style .= '.scrollup { display: none; }';
}
$architecture_building_custom_style .= '}';

// theme breadcrumb
$mobile_breadcrumb_setting = get_option('architecture_building_enable_breadcrumb_mobile', '1');
$main_breadcrumb_setting = get_option('architecture_building_enable_breadcrumb', '1');

$architecture_building_custom_style .= '.archieve_breadcrumb {';

if ($main_breadcrumb_setting == 'off') {
    $architecture_building_custom_style .= 'display: none;';
}

$architecture_building_custom_style .= '}';

// Add media query for mobile devices
$architecture_building_custom_style .= '@media screen and (max-width: 600px) {';
if ($main_breadcrumb_setting == 'off' || $mobile_breadcrumb_setting == 'off') {
    $architecture_building_custom_style .= '.archieve_breadcrumb { display: none; }';
}
$architecture_building_custom_style .= '}';

// single post and page breadcrumb
$mobile_single_breadcrumb_setting = get_option('architecture_building_single_enable_breadcrumb_mobile', '1');
$main_single_breadcrumb_setting = get_option('architecture_building_single_enable_breadcrumb', '1');

$architecture_building_custom_style .= '.single_breadcrumb {';

if ($main_single_breadcrumb_setting == 'off') {
    $architecture_building_custom_style .= 'display: none;';
}

$architecture_building_custom_style .= '}';

// Add media query for mobile devices
$architecture_building_custom_style .= '@media screen and (max-width: 600px) {';
if ($main_single_breadcrumb_setting == 'off' || $mobile_single_breadcrumb_setting == 'off') {
    $architecture_building_custom_style .= '.single_breadcrumb { display: none; }';
}
$architecture_building_custom_style .= '}';

// woocommerce breadcrumb
$mobile_woo_breadcrumb_setting = get_option('architecture_building_woocommerce_enable_breadcrumb_mobile', '1');
$main_woo_breadcrumb_setting = get_option('architecture_building_woocommerce_enable_breadcrumb', '1');

$architecture_building_custom_style .= '.woocommerce-breadcrumb {';

if ($main_woo_breadcrumb_setting == 'off') {
    $architecture_building_custom_style .= 'display: none;';
}

$architecture_building_custom_style .= '}';

// Add media query for mobile devices
$architecture_building_custom_style .= '@media screen and (max-width: 600px) {';
if ($main_woo_breadcrumb_setting == 'off' || $mobile_woo_breadcrumb_setting == 'off') {
    $architecture_building_custom_style .= '.woocommerce-breadcrumb { display: none; }';
}
$architecture_building_custom_style .= '}';

//colors
$color = get_theme_mod('architecture_building_primary_color', '#fbb908');
$color_heading = get_theme_mod('architecture_building_heading_color', '#042038');
$color_text = get_theme_mod('architecture_building_text_color', '#8b8b8b');
$color_fade = get_theme_mod('architecture_building_primary_fade', '#fff9e8');
$color_footer_bg = get_theme_mod('architecture_building_footer_bg', '#042038');
$color_post_bg = get_theme_mod('architecture_building_post_bg', '#ffffff');
$slider_overlay = get_theme_mod( 'architecture_building_slider_overlay','#042038 ');


$architecture_building_custom_style .= ":root {";
    $architecture_building_custom_style .= "--theme-primary-color: {$color};";
    $architecture_building_custom_style .= "--theme-heading-color: {$color_heading};";
    $architecture_building_custom_style .= "--theme-text-color: {$color_text};";
    $architecture_building_custom_style .= "--theme-primary-fade: {$color_fade};";
    $architecture_building_custom_style .= "--theme-footer-color: {$color_footer_bg};";
    $architecture_building_custom_style .= "--post-bg-color: {$color_post_bg};";
    $architecture_building_custom_style .= "--slider-overlay: {$slider_overlay};";
$architecture_building_custom_style .= "}";


$architecture_building_slider_opacity = get_theme_mod( 'architecture_building_slider_opacity','0.7');

if($architecture_building_slider_opacity == '0'){
$architecture_building_custom_style .='.slide-box img {';
    $architecture_building_custom_style .='opacity: 0';
$architecture_building_custom_style .='}';

}else if($architecture_building_slider_opacity == '0.1'){
$architecture_building_custom_style .='.slide-box img {';
    $architecture_building_custom_style .='opacity: 0.1';
$architecture_building_custom_style .='}';

}else if($architecture_building_slider_opacity == '0.2'){
$architecture_building_custom_style .='.slide-box img {';
    $architecture_building_custom_style .='opacity: 0.2';
$architecture_building_custom_style .='}';

}else if($architecture_building_slider_opacity == '0.3'){
$architecture_building_custom_style .='.slide-box img {';
    $architecture_building_custom_style .='opacity: 0.3';
$architecture_building_custom_style .='}';

}else if($architecture_building_slider_opacity == '0.4'){
$architecture_building_custom_style .='.slide-box img {';
    $architecture_building_custom_style .='opacity: 0.4';
$architecture_building_custom_style .='}';

}else if($architecture_building_slider_opacity == '0.5'){
$architecture_building_custom_style .='.slide-box img {';
    $architecture_building_custom_style .='opacity: 0.5';
$architecture_building_custom_style .='}';

}else if($architecture_building_slider_opacity == '0.6'){
$architecture_building_custom_style .='.slide-box img {';
    $architecture_building_custom_style .='opacity: 0.6';
$architecture_building_custom_style .='}';

}else if($architecture_building_slider_opacity == '0.7'){
$architecture_building_custom_style .='.slide-box img {';
    $architecture_building_custom_style .='opacity: 0.7';
$architecture_building_custom_style .='}';

}else if($architecture_building_slider_opacity == '0.8'){
$architecture_building_custom_style .='.slide-box img {';
    $architecture_building_custom_style .='opacity: 0.8';
$architecture_building_custom_style .='}';

}
else if($architecture_building_slider_opacity == '0.9'){
$architecture_building_custom_style .='.slide-box img {';
    $architecture_building_custom_style .='opacity: 0.9';
$architecture_building_custom_style .='}';

}
else if($architecture_building_slider_opacity == '1'){
$architecture_building_custom_style .='.slide-box img {';
    $architecture_building_custom_style .='opacity: 1';
$architecture_building_custom_style .='}';

}

$architecture_building_slider_heading_color = get_theme_mod( 'architecture_building_slider_heading_color','#ffffff');
$architecture_building_custom_style .='h2.slider-title {';
$architecture_building_custom_style .='color: '.esc_attr($architecture_building_slider_heading_color).';';
$architecture_building_custom_style .='}';

$architecture_building_slider_excerpt_color = get_theme_mod( 'architecture_building_slider_excerpt_color','#ffffff');
$architecture_building_custom_style .='.slide-inner-box p {';
$architecture_building_custom_style .='color: '.esc_attr($architecture_building_slider_excerpt_color).';';
$architecture_building_custom_style .='}';

//-------------------title-font-size----//  
$architecture_building_site_title_fontsize = get_theme_mod('architecture_building_site_title_fontsize','25');

if($architecture_building_site_title_fontsize != false){

$architecture_building_custom_style .='.logo h1,.site-title,.site-title a,.logo h1 a{';

    $architecture_building_custom_style .='font-size: '.esc_html($architecture_building_site_title_fontsize).'px;';

$architecture_building_custom_style .='}';
}

//-------------------tagline-font-size----//  
$architecture_building_site_tagline_fontsize = get_theme_mod('architecture_building_site_tagline_fontsize','15');

if($architecture_building_site_tagline_fontsize != false){

$architecture_building_custom_style .='p.site-description{';

    $architecture_building_custom_style .='font-size: '.esc_html($architecture_building_site_tagline_fontsize).'px;';

$architecture_building_custom_style .='}';
}

//-------------------menu-font-size----//  
$architecture_building_menu_fontsize = get_theme_mod('architecture_building_menu_fontsize','13');

if($architecture_building_menu_fontsize != false){

$architecture_building_custom_style .='.gb_nav_menu li a{';

    $architecture_building_custom_style .='font-size: '.esc_html($architecture_building_menu_fontsize).'px;';

$architecture_building_custom_style .='}';
}

//-------------------first-letter-capital----//
if (false === get_option('architecture_building_first_letter_capital_enable')) {
    add_option('architecture_building_first_letter_capital_enable', 'on');
}
if (get_option('architecture_building_first_letter_capital_enable') === 'off') {
    $architecture_building_custom_style .= '.entry-content > p:first-of-type:first-letter {';
    $architecture_building_custom_style .= 'font-size: 16px; float: none; line-height: unset; padding: 0;';
    $architecture_building_custom_style .= '}';
}