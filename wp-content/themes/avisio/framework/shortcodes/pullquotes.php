<?php 

add_shortcode('pullquote', 'func_pullquotes');

function func_pullquotes($atts, $content=null, $shortcodename ="")
{	
	// set alignment
	$alignment = 'left';
	if (isset($atts[0]) && trim($atts[0]) == 'right')  $alignment = 'right';

	// remove unnecessary p tags if wordpress auto p is enabled
	$remove = array('<p>','</p>');
	if(strpos($content, $remove[1]) === 0)
	{
		$content = ltrim($content,$remove[1]);
		$content = rtrim($content,$remove[0]);
	}
	
	// add blockquotes to the content
	$return .= '<blockquote class="pullquote '.$shortcodename.'_'.$alignment.'">';
	$return .= wpautop($content);
	$return .= '</blockquote>';
	
	return $return;
}