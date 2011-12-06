<?php

class kclass_display_slideshow{

	var $slideshowLoop;
	var $postPerPage;
	var $postType;
	var $containerClass;
	var $size;
	var $insertContent = "";
	var $caption = "";
	var $slider = "";
	var $welcomeMsg = "";

	function kclass_display_slideshow()
	{	
		
	}
	
	function setQueryType($arg)
	{
		$this->postType = $arg;
	}
	
	function setSlideshowSize($arg)
	{
		$this->size = $arg;
	}
	
	function setQueryNumber($arg)
	{
		$this->postPerPage = $arg;
	}
	
	function setSlideshowClass($arg)
	{
		$this->containerClass = $arg;
	}
	
	function addContent($arg)
	{
		$this->insertContent .= $arg;
	}
	
	function setCaption($arg)
	{
		$this->caption = $arg;
	}
	
	function setWelcome($arg)
	{
		$this->welcomeMsg .= $arg;
	}
	
	
	
######################################################################
# SHOW SLIDER IN FRONTEND
######################################################################

	function show()
	{
		global $k_option;
		
		$this->slideshowLoop = new WP_Query("post_type=".$this->postType."&posts_per_page=".$this->postPerPage);
		$this->slider = "<ul class='slideshow ".$this->containerClass."'>\n";
		$this->slider.= $this->insertContent;
		
		if($this->slideshowLoop->have_posts())
		{
			
			$loopCount = 1;
		
				while ($this->slideshowLoop->have_posts())
				{ 
					$this->slideshowLoop->the_post();

					$caption = html_entity_decode(get_post_meta($this->slideshowLoop->post->ID, $this->caption, true));
					$img = kriesi_post_thumb($this->slideshowLoop->post->ID, array('size'=> array($this->size),
																'wh' => $k_option['custom']['imgSize'][$this->size],
																'display_link' => array('none')
															));
															
					$imageLink = get_real_url(get_post_meta($this->slideshowLoop->post->ID, "_img_url", true));
					
					$linkMethod = get_post_meta($this->slideshowLoop->post->ID, "_how_url", true);
					$buttonText = get_post_meta($this->slideshowLoop->post->ID, "_button_text", true);
					$descriptionPos = get_post_meta($this->slideshowLoop->post->ID, "_how_description", true);
					
					if($descriptionPos == 'hidden') $linkMethod = 'image';
					
					if($imageLink !=  '')
					{
						if($linkMethod == 'button')
						{
							$linkBehaviour = 'button';
						}
						else
						{
							$linkBehaviour = 'image';
						}
					}
					else
					{
						$linkBehaviour = '';
					}
					
					//check if its a flv link
					$addClass = "";
					if(kriesi_is_file($imageLink, array('flv'))) { $addClass = "class='videoplayer'"; }
					
					//check if its an image link
					else if(kriesi_is_file($imageLink, "image")) { $addClass = "rel='lightbox[slider]'"; }
					
					//check if its a video link
					else if(kriesi_is_file($imageLink, "videoService")) { $addClass = "rel='lightbox[slider]'"; }

					$this->slider.= "<li class='featured featured".$loopCount."'>\n";
					
					$this->slider.= $linkBehaviour == "image" ? "<a href='".$imageLink."' ".$addClass.">\n" : "<span>\n";
					
					if($descriptionPos != 'hidden')
					{						
						$this->slider .= "<span class='feature_excerpt feature_excerpt_pos_".$descriptionPos."'>\n";
						$this->slider .= "<strong class='sliderheading'>".get_the_title()."</strong>\n";
						$this->slider .= "<span class='sliderdate'>".get_the_time('M d, Y')."</span>\n";
						$this->slider .= "<span class='slidercontent'>\n";
						$this->slider .= $caption;
						$this->slider .= "</span>";
						if($linkBehaviour == 'button') $this->slider .= "<a href='".$imageLink."' class='excerpt_button dynamicFont'>".$buttonText."</a>";
						$this->slider .= "</span>\n";
					}
					
					$this->slider.= $img;
					$this->slider.= $linkBehaviour == "image" ? "</a>\n" : "</span>\n";
					$this->slider.= "</li><!-- end .featured -->\n";
					
					$loopCount ++;
				}
		
			
		
		}
		else
		{
			$this->slider.= "<li class='featured featured1'><span class='slideWelcome'>".$this->welcomeMsg."</span></li>\n";
		}
		
		$this->slider.= "</ul><!-- end .featured_inside --> \n";
		echo $this->slider;
	}

	function showThumbnails()
	{
		global $k_option;
		$this->slider = '';
		
		if(!is_object($this->slideshowLoop))
		{
			$this->slideshowLoop = new WP_Query("post_type=".$this->postType."&posts_per_page=".$this->postPerPage);
		}		
		
		if($this->slideshowLoop->have_posts())
		{
			$this->slider = "<ul class='slideshowThumbs'>\n";
			$loopCount = 1;
		
				while ($this->slideshowLoop->have_posts())
				{ 
					$this->slideshowLoop->the_post();

					$img = kriesi_post_thumb($this->slideshowLoop->post->ID, array('size'=> array($this->size),
																'wh' => $k_option['custom']['imgSize'][$this->size],
																'display_link' => array('none')
															));
															
					$imageLink = get_real_url(get_post_meta($this->slideshowLoop->post->ID, "_img_url", true));

					$this->slider.= "<li class='slideThumb ie6fix slideThumb".$loopCount."'>\n";
					$this->slider.= $imageLink != "" ? "<a href='".$imageLink."' class='slideThumWrap noLightbox'>\n" : "<span class='slideThumWrap'>\n";
				
					$this->slider .= "<span class='slideThumbTitle'>\n";
					$this->slider .= "<strong class='slideThumbHeading rounded ie6fix'>".get_the_title()."</strong>\n";
					$this->slider .= "</span>\n";
					
					$this->slider.= "<span class='fancy'></span>";
					$this->slider.= $img;
					$this->slider.= $imageLink != "" ? "</a>" : "</span>";
					$this->slider.= "</li><!-- end .slideThumb -->\n";
					
					$loopCount ++;
				}
		
			$this->slider.= "</ul><!-- end .slideshowThumbs --> \n";
		
		}
		
		echo $this->slider;
	}


}
			
			