<?php

$architecture_building_custom_style= "";


/*-------------------------Slider-content-alignment-------------------*/

$civil_engineering_slider_content_alignment = get_theme_mod( 'civil_engineering_slider_content_alignment','CENTER-ALIGN');

if($civil_engineering_slider_content_alignment == 'LEFT-ALIGN'){

$architecture_building_custom_style .='.slide-inner-box{';

	$architecture_building_custom_style .='text-align:left; left: 25%; right: 40%;';

$architecture_building_custom_style .='}';

$architecture_building_custom_style .='@media screen and (max-width:1199px){';

$architecture_building_custom_style .='.slide-inner-box{';

    $architecture_building_custom_style .='right: 30%; left: 20%';
    
$architecture_building_custom_style .='} }';

$architecture_building_custom_style .='@media screen and (max-width:991px){';

$architecture_building_custom_style .='.slide-inner-box{';

    $architecture_building_custom_style .='right: 20%; left: 15%';
    
$architecture_building_custom_style .='} }';


}else if($civil_engineering_slider_content_alignment == 'CENTER-ALIGN'){

$architecture_building_custom_style .='.slide-inner-box{';

	$architecture_building_custom_style .='text-align:center;  left: 25%; right: 25%;';

$architecture_building_custom_style .='}';


}else if($civil_engineering_slider_content_alignment == 'RIGHT-ALIGN'){

$architecture_building_custom_style .='.slide-inner-box{';

	$architecture_building_custom_style .='text-align:right;left: 40%; right: 25%;';

$architecture_building_custom_style .='}';

$architecture_building_custom_style .='@media screen and (max-width:1199px){';

$architecture_building_custom_style .='.slide-inner-box{';

    $architecture_building_custom_style .='right: 20%; left: 30%';
    
$architecture_building_custom_style .='} }';

$architecture_building_custom_style .='@media screen and (max-width:991px){';

$architecture_building_custom_style .='.slide-inner-box{';

    $architecture_building_custom_style .='right: 15%; left: 20%';
    
$architecture_building_custom_style .='} }';

}

//colors
$color = get_theme_mod('civil_engineering_primary_color', '#fab915');
$color_heading = get_theme_mod('civil_engineering_heading_color', '#000000');
$color_text = get_theme_mod('civil_engineering_text_color', '#666666');
$color_footer_bg = get_theme_mod('civil_engineering_footer_bg', '#000000');
$slider_overlay = get_theme_mod( 'civil_engineering_slider_overlay','#000000 ');


$architecture_building_custom_style .= ":root {";
    $architecture_building_custom_style .= "--theme-primary-color: {$color};";
    $architecture_building_custom_style .= "--theme-heading-color: {$color_heading};";
    $architecture_building_custom_style .= "--theme-text-color: {$color_text};";
    $architecture_building_custom_style .= "--theme-footer-color: {$color_footer_bg};";
    $architecture_building_custom_style .= "--slider-overlay: {$slider_overlay};";
$architecture_building_custom_style .= "}";


$civil_engineering_slider_opacity = get_theme_mod( 'civil_engineering_slider_opacity','0.5');

if($civil_engineering_slider_opacity == '0'){
$architecture_building_custom_style .='.slide-box img {';
    $architecture_building_custom_style .='opacity: 0';
$architecture_building_custom_style .='}';

}else if($civil_engineering_slider_opacity == '0.1'){
$architecture_building_custom_style .='.slide-box img {';
    $architecture_building_custom_style .='opacity: 0.1';
$architecture_building_custom_style .='}';

}else if($civil_engineering_slider_opacity == '0.2'){
$architecture_building_custom_style .='.slide-box img {';
    $architecture_building_custom_style .='opacity: 0.2';
$architecture_building_custom_style .='}';

}else if($civil_engineering_slider_opacity == '0.3'){
$architecture_building_custom_style .='.slide-box img {';
    $architecture_building_custom_style .='opacity: 0.3';
$architecture_building_custom_style .='}';

}else if($civil_engineering_slider_opacity == '0.4'){
$architecture_building_custom_style .='.slide-box img {';
    $architecture_building_custom_style .='opacity: 0.4';
$architecture_building_custom_style .='}';

}else if($civil_engineering_slider_opacity == '0.5'){
$architecture_building_custom_style .='.slide-box img {';
    $architecture_building_custom_style .='opacity: 0.5';
$architecture_building_custom_style .='}';

}else if($civil_engineering_slider_opacity == '0.6'){
$architecture_building_custom_style .='.slide-box img {';
    $architecture_building_custom_style .='opacity: 0.6';
$architecture_building_custom_style .='}';

}else if($civil_engineering_slider_opacity == '0.7'){
$architecture_building_custom_style .='.slide-box img {';
    $architecture_building_custom_style .='opacity: 0.7';
$architecture_building_custom_style .='}';

}else if($civil_engineering_slider_opacity == '0.8'){
$architecture_building_custom_style .='.slide-box img {';
    $architecture_building_custom_style .='opacity: 0.8';
$architecture_building_custom_style .='}';

}
else if($civil_engineering_slider_opacity == '0.9'){
$architecture_building_custom_style .='.slide-box img {';
    $architecture_building_custom_style .='opacity: 0.9';
$architecture_building_custom_style .='}';

}
else if($civil_engineering_slider_opacity == '1'){
$architecture_building_custom_style .='.slide-box img {';
    $architecture_building_custom_style .='opacity: 1';
$architecture_building_custom_style .='}';

}