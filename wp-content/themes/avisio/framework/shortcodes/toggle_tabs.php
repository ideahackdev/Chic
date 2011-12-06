<?php 

add_shortcode('toggle', 'kriesi_sc_toggle');
add_shortcode('tab_container', 'kriesi_sc_tabs');
add_shortcode('tab', 'kriesi_sc_tab_single');


function kriesi_sc_toggle($atts, $content=null, $shortcodename ="")
{	
	//remove wrong nested p tags
	$content = remove_invalid_tags($content, array('p'));
	
	$active[0] = $active[1] = '';
	if(isset($atts[0]) && $atts[0] == 'active') {$active[0] = 'activeTitle'; $active[1] = 'activetoggle open';}
	
	if(isset($atts['close'])) $closeAll = "closeAll"; 
	
	$return  = '<div class="ie6fix toggler '.$closeAll.' '.$active[0].'">'.$atts['title'].'</div>'."\n";
	$return .= '<div class="toggle '.$active[1].'">'."\n";
	$return .= '<div class="toggle_content">'."\n";
	$return .= wpautop(do_shortcode(shortcode_unautop($content)))."\n";
	$return .= '</div>'."\n";
	$return .= '</div>'."\n";

	return $return;
}



function kriesi_sc_tabs($atts, $content=null, $shortcodename ="")
{	
	$content = remove_tags($content, array('p'));
	$return  = '<div class="tabcontainer">'."\n";
 	$return .= do_shortcode($content)."\n";
	$return .= '</div>'."\n";
	
	return $return;
}




function kriesi_sc_tab_single($atts, $content=null, $shortcodename ="")
{		
	
	$active = '';
	if(isset($atts[0]) && $atts[0] == 'active') $active = 'active';

	$return  = '<span class="ie6fix tab '.$active.'_tab">'.$atts['title'].'</span>'."\n";
	$return .= '<div class="tab_content '.$active.'_tab_content">'."\n";
	$return .= do_shortcode(wpautop($content))."\n";
	$return .= '</div>'."\n";

	return $return;
}