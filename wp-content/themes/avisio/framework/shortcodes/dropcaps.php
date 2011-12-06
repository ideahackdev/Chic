<?php

add_shortcode('dropcap1', 'kriesi_dropcaps');
add_shortcode('dropcap2', 'kriesi_dropcaps');
add_shortcode('dropcap3', 'kriesi_dropcaps');


function kriesi_dropcaps($atts, $content=null, $shortcodename ="")
{	
	
	// add divs to the content
	$return .= '<span class="'.$shortcodename.' ie6fix">';
	$return .= do_shortcode($content);
	$return .= '</span>';	
	

	return $return;
}