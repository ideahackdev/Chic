<?php 

add_shortcode('pre', 'kriesi_pre');


function kriesi_pre($atts, $content=null, $shortcodename ="")
{	

	$width = '';
	if (isset($atts[0]))  $width = $atts[0];

	$last = '';
	if (isset($atts[1]) && trim($atts[1]) == 'last')  $last = 'last';
	
	
	// remove unnecessary p tags if wordpress auto p is enabled
	$remove = array('<p>','</p>');
	if(strpos($content, $remove[1]) === 0)
	{
		$content = ltrim($content,$remove[1]);
		$content = rtrim($content,$remove[0]);
	}
	$content = strip_tags($content); 
	
	// add pre tags to the content
	$return .= '<pre class="'.$width.' '.$last.'">';
	$return .= $content;
	$return .= '</pre>';
		
	

	return $return;
}