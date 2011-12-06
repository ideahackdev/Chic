<?php


class kclass_advanced_css_style
{
	var $themeMods;
	var $backgroundColor;
	var $backgroundPositionX;
	var $backgroundImage;
	var $backgroundAttachment;
	var $backgroundRepeat;
	var $style = '';
	var $links = '';
	var $scripts = '';
	
	function kclass_advanced_css_style()
	{
		$this->style = "<!-- custom styles set at your backend-->\n<style type='text/css'>\n";
		$this->themeMods = get_option('theme_mods_'.strtolower( THEMENAME ));
		$this->backgroundImage = $this->themeMods['background_image'];
		$this->backgroundColor = $this->themeMods['background_color'];
		$this->backgroundPositionX = $this->themeMods['background_position_x'];
		$this->backgroundAttachment = $this->themeMods['background_attachment'];
		$this->backgroundRepeat = $this->themeMods['background_repeat'];
	}
	
	#google api font-currently not in use
	function set_font($elements, $font)
	{
		if(empty($font)) return;
		$this->links .= "<link href=' http://fonts.googleapis.com/css?family=$font' rel='stylesheet' type='text/css' />\n";
		
		$font = str_replace('+',' ',$font);		
		$this->style .= $elements."{font-family: '$font';}\n";
		
	}
	
	function set_cufon_font($elements, $font)
	{
		if(empty($font)) return;
		$this->scripts .= "<script type='text/javascript' src='".get_bloginfo('template_url')."/framework/fonts/cufon.js'></script>\n";
		$this->scripts .= "<script type='text/javascript' src='".get_bloginfo('template_url')."/framework/fonts/optima.font.js'></script>\n";
		$this->scripts .="
<script type='text/javascript'>\n
Cufon.replace('".$elements."',{ 

fontFamily: 'cufon',
hover:'true'

});
\n
</script>
\n
";
	}
	
	function set_element_background($elements, $color = '')
	{
		if(($color == '' && $this->backgroundColor == "") || $elements == '') return;
		
		if($color == '') $color = $this->backgroundColor;
				
		$this->style .= $elements."{background-color: #".$color."; }\n";
	}
	
	function set_element_background_image($elements, $image = '')
	{	
		$position = "";
		if(($image = '' && $this->backgroundImageTiled && $this->backgroundImageFixed == '' && $this->backgroundImage == "") || $elements == '') return;
		#check if we got front end edit
		if($image == '') $image = $this->backgroundImageFixed;
		if($image == '') $image = $this->backgroundImageTiled;
		
		if($this->backgroundImagePos) 
		{ 
			$position = $this->backgroundImagePos; 
		}
		else
		{
			$position .= $this->backgroundPositionX != "" ? "background-position: top ".$this->backgroundPositionX ."; ": "";
			$position .= $this->backgroundAttachment != "" ? "background-attachment: ".$this->backgroundAttachment ."; ": "";
			$position .= $this->backgroundRepeat != "" ? "background-repeat: ".$this->backgroundRepeat ."; ": "";
		}
		
		#check if we got backend edit
		if($image == '') $image = $this->backgroundImage;
		
		if($image != '')
		{	
			$this->style .= $elements."{background-image: url('".$image."'); \n";
			$this->style .= $position." }\n";
		}
	}
	
	
	function set_font_color($elements, $color = '')
	{
		if(($color == '' && $this->backgroundColor == "") || $elements == '') return;
		
		if($color == '') $color = $this->backgroundColor;
		
		$this->style .= $elements."{color: #".$color."; }\n";
	}
	
	function show()
	{
		$this->style  .= "</style>\n<!-- end custom styles-->\n";
		echo $this->links;
		echo $this->scripts;
		echo $this->style;
	}
}

$k_option['custom']['styling'] = new kclass_advanced_css_style();
