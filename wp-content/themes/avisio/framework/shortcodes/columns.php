<?php 

add_shortcode('one_third', 'kriesi_sc_column');
add_shortcode('two_third', 'kriesi_sc_column');
add_shortcode('one_fourth', 'kriesi_sc_column');
add_shortcode('three_fourth', 'kriesi_sc_column');
add_shortcode('one_half', 'kriesi_sc_column');

//for displaying other shortcodes inside

add_shortcode('one_third_pre', 'kriesi_sc_column');
add_shortcode('two_third_pre', 'kriesi_sc_column');
add_shortcode('one_fourth_pre', 'kriesi_sc_column');
add_shortcode('three_fourth_pre', 'kriesi_sc_column');
add_shortcode('one_half_pre', 'kriesi_sc_column');

function kriesi_sc_column($atts, $content=null, $shortcodename ="")
{	
	$last = '';
	if (isset($atts[0]) && trim($atts[0]) == 'last')  $last = 'last';
	
	$pre = '';
	if(preg_match("!(.+)_pre!",$shortcodename, $result)) 
	{
		$pre = true;
		$shortcodename = $result[1];
	}
	
	//remove wrong nested p tags
	$content = remove_invalid_tags($content, array('p'));


	// add divs to the content
	$return .= '<div class="'.$shortcodename.' '.$last.'">';
	if($pre)
	{
		$return .= wpautop($content);
	}
	else
	{
		$return .= wpautop(do_shortcode(shortcode_unautop($content)));
	}
	$return .= '</div>';
	
	if($last != '') $return .= '<span class="clearboth"></span>';
	
	

	return $return;
}

