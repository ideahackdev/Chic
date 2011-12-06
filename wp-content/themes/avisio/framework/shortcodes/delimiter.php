<?php

add_shortcode('hr', 'kriesi_delimiter');


function kriesi_delimiter($atts, $content=null, $shortcodename ="")
{	
	$top = $title = $extraClass = '';
	if (isset($atts[0]) && trim($atts[0]) == 'top')  $top = 'top';
	if (isset($atts['title'])) {$title = $atts['title']; $extraClass = 'hrTitle';}

	// remove unnecessary p tags if wordpress auto p is enabled
	$remove = array('<p>','</p>');
	if(strpos($content, $remove[1]) === 0)
	{
		$content = ltrim($content,$remove[1]);
		$content = rtrim($content,$remove[0]);
	}
	
	// add delimiter to the content
	$return .= '<span class="hr '.$extraClass.'">';
	
	if($title != '')
	{
		$return .= '<span class="hrTitleWrap"><span>'.$title.'</span></span>';
	}
	else if($top == 'top')
	{
		$return .= '<a href="#top" class="scrollTop">top</a>';
	}
	
	$return .= '</span>';	
	

	return $return;
}