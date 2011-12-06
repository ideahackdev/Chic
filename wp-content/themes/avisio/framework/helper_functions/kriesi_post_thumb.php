<?php
######################################################################
# displays an image, resized with wordpress, several fallback options
# included
######################################################################


function kriesi_post_thumb($this_post, $option)
{	
	global $k_option;
	
	$defaults = array(	'link'=>false,
						'size'=>false,
						'wh'=>array('width'=>100,'height'=>100),	// array: width/height
						'domain'=>false,							// bol: add or remove domain from timthumb output
						'script'=> KFWINC_URI.'timthumb.php?src=',	// string: timthumb uri
						'display_link' => array('none'),
						'img_attr' => '',
						'link_attr' => ''
						);
	
	$option = array_merge((array)$defaults,(array)$option);

	######################################################################
	# Here we get the image src
	######################################################################	
	// get the default image:
	// first check for a custom field "overwrite" value:
	if (isset($option['size'][1]))
	{	
		$image_customfield = get_post_meta($this_post, $option['size'][1], true);
	}
	
	$thumbnail_id = get_post_thumbnail_id($this_post);
	
	
 	//if there is are no post thumbnails or if there is an overwrite value set the default image gets pulled from the custom field
	if(($image_customfield != '') || $image_customfield != '')
	{
		$image_URL = $image_customfield;
	}
	// otherwise if we got a value for a post thumb we take this as default image
	else if(isset($option['size'][0]))
	{			
		//get the full size image as well as the resized. if the url is the same then there was no resize and we need to use timthumb
		$image_src = wp_get_attachment_image_src($thumbnail_id, $option['size'][0]);
		$image_src2 = wp_get_attachment_image_src($thumbnail_id, NULL);

		//if this is already the largest image (reduced version might be missing), 
		if($image_src[0] == $image_src2[0])
		{
			// if resizing is enabled and the image is bigger than defined activate resize
			if($k_option['custom']['resizing'] && ($option['wh']['width'] < $image_src[1] || $option['wh']['height'] < $image_src[2]))
			{
				$parameters .= '&amp;zc=1';
				if($option['wh']['height'] != '') 	$parameters .= '&amp;h='.$option['wh']['height'] ;
				if($option['wh']['width'] != '') 	$parameters .= '&amp;w='.$option['wh']['width'] ;
				
				//check if domain should be included in timthumb output
				if($option['domain'] == false)
				{
					$uri_array = parse_url($image_src[0]);
					$image_src[0] = $uri_array['path'];
					$image_URL = $option['script'].$image_src[0].$parameters;
				}
			}
			// no resizing, either because image isnt too big or resizing is disabled
			else
			{
				$image_URL = $image_src[0];
			}
		}
		
		// small version is not missing:
		else
		{
			$image_URL = $image_src[0];
		}
	}	
	
	
	
	//first we get the link attributes:
	$img_attr_string = '';
	
	if(is_array($option['img_attr']))
	{
		foreach ($option['img_attr'] as $attr=>$value)
		{
			$img_attr_string .= $attr."='".$value."' ";
		}
	}
		
		
		// if we got no image yet then abort script
		if($image_URL == "") return false;
		
		
	######################################################################
	# Here we get the Link
	######################################################################	
		// if the display_link option is not set directly use the custom field value. set the option directly by puttin 
		// 'none','permalink' or 'lightbox' in an otherwise empty array
		
		//first we get the link attributes:
		$link_attr_string = '';

		if(is_array($option['link_attr']))
		{	
			foreach ($option['link_attr'] as $attr=>$value)
			{
				$link_attr_string .= $attr."='".$value."' ";
			}
		}
		
		
		// now we check if the link option is set and which option has been choosen
		if(!is_array($option['display_link']))
		{
			$display_link = $image_customfield = get_post_meta($this_post, $option['display_link'], true);
		}
		else
		{
			$display_link = $option['display_link'][0];
		}
		
		$linkwrap[1] = '</a>';
		// no link;
		if($display_link == 'none') { $linkwrap[0] = $linkwrap[1] = ''; }
		
		// permalink
		else if($display_link == 'permalink') { $linkwrap[0] = '<a '.$link_attr_string.' href="'.get_permalink().'" title="'.get_the_title().'" >'; }
		
		//lightbox link
		else if($display_link == 'lightbox')
		{	
			//check if we got a set customfield to overwrite the default generated image
			if (isset($option['linkurl'][1]))
			{
				$link_src = get_post_meta($this_post, $option['linkurl'][1], true);
			}
			
			if($link_src == '')
			{	
				
				$link_src = wp_get_attachment_image_src($thumbnail_id, $option['linkurl'][0]);
				$link_src = $link_src[0];
			}
			
			$linkwrap[0] = '<a '.$link_attr_string.' rel="lightbox[grouped]" href="'.$link_src.'" title="'.get_the_title().'" >';
		}
		else
		{	
			if($display_link != "")
			{
				$link_src = $display_link;
				$linkwrap[0] = '<a '.$link_attr_string.' href="'.$link_src.'" title="'.get_the_title().'" >';
			}
			else
			{
				$linkwrap[0] = $linkwrap[1] = ''; 
			}
		}
		
		
		
		$defaultimage = $linkwrap[0]."<img ".$img_attr_string." src='".$image_URL."' alt='' title='".get_the_title()."' height='".$option['wh']['height'] ." ' width='".$option['wh']['width'] ."' />".$linkwrap[1];

	
	return $defaultimage;
}