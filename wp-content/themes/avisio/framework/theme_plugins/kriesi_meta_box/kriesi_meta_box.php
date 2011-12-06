<?php
##################################################################
class kriesi_meta_box{
##################################################################
	var $options; 			// options passed by the option file
	var $boxinfo;			// meta box info passed by the option file

	function kriesi_meta_box($options, $boxinfo)
	{	
		// set basic options passed by the option file
		$this->options = $options;
		$this->boxinfo = $boxinfo;
		
		add_action('admin_menu', array(&$this, 'init_boxes'));
		add_action('save_post', array(&$this, 'save_postdata'));
		
	}
	
	function init_boxes()
	{	
		$this->add_script_and_styles();
		$this->create_meta_box();
	}
	
	######################################################################
	# add javascript and css files only to the head if these files are called
	######################################################################
	function add_script_and_styles()
	{	
		
		if(basename( $_SERVER['PHP_SELF']) == "page.php" 
		|| basename( $_SERVER['PHP_SELF']) == "page-new.php" 
		|| basename( $_SERVER['PHP_SELF']) == "post-new.php" 
		|| basename( $_SERVER['PHP_SELF']) == "post.php"
		|| basename( $_SERVER['PHP_SELF']) == "media-upload.php")
		{	
			wp_enqueue_style('kriesi_custom_fields_css', KFWPLUGINS_URI . 'kriesi_meta_box/kriesi_custom_fields.css');
			wp_enqueue_script('kriesi_custom_fields_js', KFWPLUGINS_URI . 'kriesi_meta_box/kriesi_custom_fields.js');
			
			if(isset($_GET['hijack_target']))
			{	
				add_action('admin_head', array(&$this,'add_hijack_var'));
			}
		}
	}
	
	
	######################################################################
	# Sets the new target for insertion within a meta tag that can be
	# easily read by jQuery
	######################################################################	
	function add_hijack_var()
	{
		echo "<meta name='hijack_target' content='".$_GET['hijack_target']."' />\n";
	}
	
	
	######################################################################
	# Add the meta boxes to the page/post or link
	# pass id, name, callback, show at page/post/link, in which area, priority
	######################################################################
	function create_meta_box() 
	{  
		if ( function_exists('add_meta_box') && is_array($this->boxinfo['page']) ) 
		{
			foreach ($this->boxinfo['page'] as $area)
			{	
				if ($this->boxinfo['callback'] == '') $this->boxinfo['callback'] = 'new_meta_boxes';
				
				add_meta_box( 	
					$this->boxinfo['id'], 
					$this->boxinfo['title'],
					array(&$this, $this->boxinfo['callback']),
					$area, $this->boxinfo['context'], 
					$this->boxinfo['priority']
				);  
			}
		}  
	}  
	
	
	
	function new_meta_boxes()
	{	
		global $post;


		//calls the helping function based on value of 'type'
		foreach ($this->options as $option)
		{				
			if (method_exists($this, $option['type']))
			{	
				$meta_box_value = get_post_meta($post->ID, $option['id'], true); 
				if($meta_box_value != "") $option['std'] = $meta_box_value;  
				
				echo '<div class="alt kriesi_meta_box_alt meta_box_'.$option['type'].' meta_box_'.$this->boxinfo['context'].'">';
				$this->$option['type']($option);
				echo '</div>';
			}
		}
		
		//security field
		echo'<input type="hidden" name="'.$this->boxinfo['id'].'_noncename" id="'.$this->boxinfo['id'].'_noncename" value="'.wp_create_nonce(plugin_basename(__FILE__) ).'" />';  
	}
	
	function save_postdata() 
	{
		$post_id = $_POST['post_ID'];
		
		foreach ($this->options as $option)
		{
			// Verify
			if (!wp_verify_nonce($_POST[$this->boxinfo['id'].'_noncename'], plugin_basename(__FILE__))) 
			{	
				return $post_id ;
			}
			
			if ( 'page' == $_POST['post_type'] ) 
			{
				if ( !current_user_can( 'edit_page', $post_id  ))
				return $post_id ;
			} 
			else 
			{
				if ( !current_user_can( 'edit_post', $post_id  ))
				return $post_id ;
			}
			
			$data = htmlspecialchars($_POST[$option['id']], ENT_QUOTES,"UTF-8");
			
			if(get_post_meta($post_id , $option['id']) == "")
			add_post_meta($post_id , $option['id'], $data, true);
			
			elseif($data != get_post_meta($post_id , $option['id'], true))
			update_post_meta($post_id , $option['id'], $data);
			
			elseif($data == "")
			delete_post_meta($post_id , $option['id'], get_post_meta($post_id , $option['id'], true));
			
		}
	}
	
	
	####################################################################################################################################	
	# Rendering Methods
	####################################################################################################################################
	
	##############################################################
	# TITLE
	##############################################################	
	
	function title($values)
	{	
		echo '<p>'.$values['name'].'</p>';
	}
	
	##############################################################
	# TEXT
	##############################################################	
	function text($values)
	{	
		if(isset($this->database_options[$values['id']])) $values['std'] = $this->database_options[$values['id']];
		
		echo '<p>'.$values['name'].'</p>';
		echo '<p><input type="text" size="'.$values['size'].'" value="'.$values['std'].'" id="'.$values['id'].'" name="'.$values['id'].'"/>';
		echo $values['desc'].'<br/></p>';
	    echo '<br/>';
	}
	
	
	##############################################################
	# TEXTAREA
	##############################################################	
	function textarea($values)
	{	
		if(isset($this->database_options[$values['id']])) $values['std'] = $this->database_options[$values['id']];
		
		echo '<p>'.$values['name'].'</p>';
		echo '<p><textarea class="kriesi_textarea" cols="20" rows="1" id="'.$values['id'].'" name="'.$values['id'].'">'.$values['std'].'</textarea>';
		echo $values['desc'].'<br/></p>';
	    echo '<br/>';
	}
	
	
	##############################################################
	# Media
	##############################################################	
	function media($values)
	{	
		if(isset($this->database_options[$values['id']])) $values['std'] = $this->database_options[$values['id']];
		
		//reference code is wp_includes/media.php function media_buttons()
		global $post_ID, $temp_ID;
		$uploading_iframe_ID = (int) (0 == $post_ID ? $temp_ID : $post_ID);
		$media_upload_iframe_src = "media-upload.php?post_id=$uploading_iframe_ID";
		$image_upload_iframe_src = apply_filters('image_upload_iframe_src', "$media_upload_iframe_src&amp;type=image");
		
		$button = '<a href="'.$image_upload_iframe_src.'&amp;hijack_target='.$values['id'].'&amp;TB_iframe=true" id="'.$values['id'].'" class="k_hijack button thickbox" title="'.$image_title.'" onclick="return false;" >'.$values['button_label'].'</a>';
		
		// check if entry is a valid image and display it if thats the case
		$image = '';
		if($values['std'] != '')
		{	
			$fileextension = substr($values['std'], strrpos($values['std'], '.') + 1);
			$extensions = array('png','gif','jpeg','jpg','pdf','tif');
			
			if(in_array($fileextension, $extensions))
			{
				$image = '<img src="'.$values['std'].'" />';
			}
		}
		
		echo '<div id="'.$values['id'].'_div" class="kriesi_preview_pic">'.$image .'</div>';
		echo '<p>'.$values['name'].'</p><p>';
		if($values['desc'] != "") echo '<p>'.$values['desc'].'<br/>';
		echo '<input class="kriesi_preview_pic_input" type="text" size="'.$values['size'].'" value="'.$values['std'].'" name="'.$values['id'].'"/>'.$button;
		echo '</p>';
	    echo '<br/>';
	}
	
	
	##############################################################
	# CHECKBOX
	##############################################################
	function checkbox($values)
	{	
		if(isset($values['std']) && $values['std'] == 'true') $checked = 'checked = "checked"'; 
		echo '<p>'.$values['name'].'</p>';
		echo '<p><input class="kcheck" type="checkbox" name="'.$values['id'].'" id="'.$values['id'].'" value="true"  '.$checked.' />';
		echo '<label for="'.$values['id'].'">'.$values['desc'].'</label><br/></p>';
	}
	
	##############################################################
	# DROPDOWN
	##############################################################	
	function dropdown($values)
	{	
					
		echo '<p>'.$values['name'].'</p>';
		
			if($values['subtype'] == 'page')
			{
				$select = 'Select page';
				$entries = get_pages('title_li=&orderby=name');
			}
			else if($values['subtype'] == 'cat')
			{
				$select = 'Select category';
				$entries = get_categories('title_li=&orderby=name&hide_empty=0');
			}
			else
			{	
				$select = 'Select...';
				$entries = $values['subtype'];
			}
		
			echo '<p><select class="postform" id="'. $values['id'] .'" name="'. $values['id'] .'"> ';
			echo '<option value="">'.$select .'</option>  ';

			foreach ($entries as $key => $entry)
			{
				if($values['subtype'] == 'page')
				{
					$id = $entry->ID;
					$title = $entry->post_title;
				}
				else if($values['subtype'] == 'cat')
				{
					$id = $entry->term_id;
					$title = $entry->name;
				}
				else
				{
					$id = $entry;
					$title = $key;				
				}

				if ($values['std'] == $id )
				{
					$selected = "selected='selected'";	
				}
				else
				{
					$selected = "";		
				}
				
				echo"<option $selected value='". $id."'>". $title."</option>";
			}
		
		echo '</select>';
		echo $values['desc'].'<br/></p>';
		 
	    echo '<br/>';
	}
	
	##############################################################
	# DROPDOWN SUPERLINK
	##############################################################	
	function dropdown_superlink($values)
	{	
		$getValues = explode("$:$",$values['std']);

	
		echo '<div class="dropdown_superlink">';			
		echo '<p>'.$values['name'].'</p>';
		
			
			$select['page'] = 'Link to page';
			$select['cat'] = 'Link to category';
			$select['post'] = 'Link to post';
			$select['manually'] = 'Link manually';
			
			echo '<p><select class="postform superselector"> ';
			echo '<option value="">Select Linking method</option>';
			
			foreach ($select as $key => $value)
			{
				if($hidden == "" && $key == $getValues[0]) { $selected = "selected"; } else {$selected = "";}
			
				echo "<option $selected value='". $key."'>". $value."</option>";
			}
			echo '</select>';
			echo '</p>';
			
			
			
			
			
			//page
			$entries = get_pages('title_li=&orderby=name');
			$hidden = "";
			if($getValues[0] != 'page') $hidden = "hidden";
			
			echo '<p><select class="postform page '.$hidden.'"> ';
			echo '<option value="">Select Page</option>';
			
			foreach ($entries as $page)
			{
				if($hidden == "" && $page->ID == $getValues[1]) { $selected = "selected"; } else {$selected = "";}
			
				echo "<option $selected value='".$page->ID."'>". $page->post_title."</option>";
			}
			echo '</select>';
			echo '</p>';
			
			//cat
			$entries = get_categories('title_li=&orderby=name&hide_empty=0');
			$hidden = "";
			if($getValues[0] != 'cat') $hidden = "hidden";
			
			echo '<p><select class="postform cat '.$hidden.'"> ';
			echo '<option value="">Select Category</option>';
			
			foreach ($entries as $category)
			{
				if($hidden == "" && $category->term_id == $getValues[1]) { $selected = "selected"; } else {$selected = "";}
				
				echo "<option $selected value='".$category->term_id."'>". $category->name."</option>";
			}
			echo '</select>';
			echo '</p>';
			
			
			
			//post
			$entries = get_posts('orderby=title&numberposts=-1&order=ASC');
			$hidden = "";
			if($getValues[0] != 'post') $hidden = "hidden";
			
			echo '<p><select class="postform post '.$hidden.'" > ';
			echo '<option value="">Select Post</option>';
			
			foreach ($entries as $page)
			{
				if($hidden == "" && $page->ID == $getValues[1]) { $selected = "selected"; } else {$selected = "";}
			
				echo "<option $selected value='".$page->ID."'>". $page->post_title."</option>";
			}
			echo '</select>';
			echo '</p>';

			
			//manually
			$hidden = "";
			$setValue = "";
			if($getValues[0] != 'manually') { $hidden = "hidden"; } else { $setValue = $getValues[1]; }
			
			echo '<p><input size="'.$values['size'].'" type="text" class="manually '.$hidden.'" value="'.$setValue.'"/> </p>';	
			
			//hidden real value
			echo '<input type="hidden" id="'. $values['id'] .'" name="'. $values['id'] .'" class="value" value='. $values['std'] .' /> ';	
		 
	    echo '<br/>';
	    echo "</div>";
	}
	
	
	
	
	
##################################################################
} # End Class
##################################################################
