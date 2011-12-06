<?php 

add_shortcode('slideshow', 'kriesi_sc_slideshow');
add_shortcode('slide', 'kriesi_sc_slide');


function kriesi_sc_slideshow($atts, $content=null, $shortcodename ="")
{	
	$uniqueClass = mt_rand();

	$return  = '<div class="feature_wrap">';
	$return .= '<div class="featured_inside medium_sized_slider slider_'.$uniqueClass.'">';
	
	$return .= '<span class="fancyborder ie6fix fancyborder_top"></span>';
	$return .= '<span class="fancyborder ie6fix fancyborder_left"></span>';
	$return .= '<span class="fancyborder ie6fix fancyborder_right"></span>';
	$return .= '<span class="fancyborder ie6fix fancyborder_bottom"></span>';
	
	$return .= do_shortcode(strip_tags($content));
	
	$return .= '</div>';
	$return .= '</div>';

	$return .= kriesi_sc_create_slider($uniqueClass, $atts);

	return $return;
}

function kriesi_sc_slide($atts, $content=null, $shortcodename ="")
{	
	$return  = '<div class="featured">';
	if(isset($atts['link'])  && $atts['link'] != "") $return .= '<a href="'.$atts['link'].'">';
	$return .= '<img alt="" src="'.$atts['src'].'" />';
	if(isset($atts['link']) && $atts['link'] != "") $return .= '</a>';
	$return .= '</div><!-- end .featured -->';
	return $return;
}

function kriesi_sc_create_slider($uniqueClass, $atts)
{	

	if(!isset($atts['autorotation']) || $atts['autorotation'] == "") $atts['autorotation'] = 'false';
	if(!isset($atts['height']) || $atts['height'] == "") $atts['height'] = 'full';
	if(!isset($atts['width']) || $atts['width'] == "") $atts['width'] = 'full';
	if(!isset($atts['speed']) || $atts['speed'] == "") $atts['speed'] = '3';
	if(!isset($atts['boxspeed']) || $atts['boxspeed'] == "") $atts['boxspeed'] = '600';
	if(!isset($atts['delay']) || $atts['delay'] == "") $atts['delay'] = '35';
	if(!isset($atts['transition']) || $atts['transition'] == "") $atts['transition'] = 'fade';
	if(!isset($atts['display']) || $atts['display'] == "") $atts['display'] = 'diagonaltop';
	if(!isset($atts['switch']) || $atts['switch'] == "") $atts['switch'] = 'true';


	$return  = '<script type="text/javascript">';
	$return .= 'jQuery(".slider_'.$uniqueClass.'").aviaSlider(';
	$return .= '{';
	$return .= '    slides: ".featured",';
	$return .= '    slideControlls: "items",';
	$return .= '    appendControlls: ".slider_'.$uniqueClass.'",';
	$return .= '    animationSpeed:'.$atts['boxspeed'].',';
	$return .= '    autorotation: '.$atts['autorotation'].',';
	$return .= '    transition: "'.$atts['transition'].'",';
	$return .= '    autorotationSpeed:'.$atts['speed'].',';
	$return .= '    blockSize: {height: "'.$atts['height'].'", width:"'.$atts['width'].'"},';
	$return .= '    betweenBlockDelay:'.$atts['delay'].',';
	$return .= '    showText: false,';
	$return .= '    display: "'.$atts['display'].'",';		
	$return .= '    switchMovement:'.$atts['switch'];
	$return .= '})';
	$return .= '</script>';
	return $return;
}



