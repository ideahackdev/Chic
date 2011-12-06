<?php

class kclass_display_box{

	var $runs;
	var $boxname;
	var $pagename;
	var $widgetname;
	var $placeholder;
	var $prev_image_array;
	var $classname;

	function kclass_display_box($pagename, $boxname, $widgetname, $placeholder = array(), $default = 3)
	{	
		global $k_option;
		
		if($k_option[$pagename][$boxname] != "")
		{
			$this->runs = $k_option[$pagename][$boxname];
		}
		else
		{
			$this->runs = $default;
		}
		
		$this->boxname = $boxname;
		$this->pagename = $pagename;
		$this->widgetname = $widgetname;
		$this->placeholder = $placeholder;
		
		
	}
	
	function prev_image($array)
	{
		$this->prev_image_array = $array;
	}
	
	function setClass($classname)
	{
		$this->classname = $classname;
	}
	
	
	function display()
	{	
		global $k_option, $more, $post;
		
		for($counter = 1; $counter <= $this->runs; $counter++)
		{	
			$last = "";
			$preview = '';
			if ($counter == $this->runs) $last = "last";
			
			
			switch($k_option[$this->pagename][$this->boxname.$counter.'_content'])
  	 		{	
  	 			
	  	 		case 'post':
	  	 		$query_string = "&showposts=1";
	  	 		$offset = 0;
	  	 		
	  	 		#calculate post offset
	  	 		if($counter > 1)
	  	 		{
	  	 			for($i = 1; $i < $counter; $i++)
	  	 			{
	  	 				if($k_option[$this->pagename][$this->boxname.$i.'_content'] == $k_option[$this->pagename][$this->boxname.$counter.'_content'])
	  	 				{
	  	 					if($k_option[$this->pagename][$this->boxname.$i.'_content_post'] == $k_option[$this->pagename][$this->boxname.$counter.'_content_post'] )
	  	 					{
	  	 					$offset++;
	  	 					}
	  	 				}
	  	 			}
	  	 		}
	  	 		
	  	 		$query_string .= "&offset=".$offset.".&cat=".$k_option[$this->pagename][$this->boxname.$counter.'_content_post'];
	  	 		query_posts($query_string);
	  	 		
				 
	  	 		break;
	  	 		
	  	 		case 'page':
	  	 		$query_string = "page_id=".$k_option[$this->pagename][$this->boxname.$counter.'_content_page'];
	  	 		query_posts($query_string);
	  	 			  	 		
	  	 		break;
	  	 		
	  	 		case 'widget':
	  	 		if (function_exists('dynamic_sidebar') && dynamic_sidebar($this->widgetname.' '.$counter)){}
	  	 		break;
	  	 		default:
	  	 		echo'<div class="box box_small box'.$counter.' '.$this->classname.' '.$last.'">'."\n";
	  	 		echo $this->placeholder[$counter];
	  	 		echo'</div><!--end widget-->'."\n";
  	 		}
  	 		
  	 		if(	$k_option[$this->pagename][$this->boxname.$counter.'_content'] == 'page' ||
  	 			$k_option[$this->pagename][$this->boxname.$counter.'_content'] == 'post')
  	 		{
 				if (have_posts()) : 
				while (have_posts()) : the_post(); 
				
				// check if we got a previe picture, and which one should be taken 
				// (image resizing with "tim thumb" on? then we can take the big one and resize it)
				// $preview_small = get_post_meta($post->ID, "_preview_small", true);
				// $preview_medium = get_post_meta($post->ID, "_preview_medium", true);
				// $preview_big = get_post_meta($post->ID, "_preview_big", true);
				
													
				$preview = kriesi_post_thumb($post->ID, array('size'=> array('M'),
															'display_link' => array('none'),
															'wh' => $k_option['custom']['imgSize']['M']
															));							
				
				$page_link = get_permalink();
				$more = 0;						
				echo'<div class="box_'.$k_option[$this->pagename][$this->boxname.$counter.'_content'].' box box_small box'.$counter.' '.$this->classname.' '.$last.'" >'."\n";
				echo $preview;
				echo'<h3><a href="'.$page_link.'">'.get_the_title().'</a></h3>'."\n";
				the_content('');
				echo '<a href="'.get_permalink().'" class="more-link">'.__('Read more','avisio').'</a>';
				echo'</div><!--end widget-->'."\n";
				endwhile; 
				endif;
			}
		}
	}
}
			
			