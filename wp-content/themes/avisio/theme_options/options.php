<?php

$pageinfo = array('full_name' => '"'.THEMENAME.'" General Options', 'optionname'=>'general', 'child'=>false, 'filename' => basename(__FILE__));

$options = array();
			
$options[] = array(	"type" => "open");

		
			
			
$options[] =  array("type" => "group");		

$options[] =	array(	"name" => "General Layout Settings",
			"desc" => "Here you can set several style settings to quickly edit the look and feel of your website",
			"id" => "generallayout",
			"type" => "title_inside");
	
$options[] = array(	"name" => "'".THEMENAME."' - Skin",
			"desc" => "Please choose one of the ".THEMENAME." skins here",
            "id" => "skin",
            "type" => "dropdown",
            "std" => "1",
            "subtype" => array(THEMENAME.' - Default'=>'1',THEMENAME.' - Minimal'=>'2',THEMENAME.' - Dark'=>'3'));
            			
$options[] =	array(	"name" => "Color Options",
			"desc" => "Since ther release of Wordpress 3, theme authors can use a buildt in background color/image editor. ".THEMENAME." uses this color switcher to further define the color scheme. <br/><a href='".get_option('siteurl')."/wp-admin/themes.php?page=custom-background'>You can edit it here</a><br/><br/>",
			"id" => "generallayout",
			"type" => "title_inside");			


$options[] =  array(	"name" => "Fullwidth or Boxed",
			"desc" => "Set if your layout should stretch fullwidth to the left and right browser border or be boxed and centered.",
            "id" => "layout_style",
            "type" => "dropdown",
            "std" => "stretched",
            "subtype" => array(	'Stretched Layout'=>'stretched',
            					'Boxed Layout'=>'boxed'
            					));
            					
            								
$options[] =  array(	"name" => "Heading Font",
			"desc" => "The Font heading utilizes the google API and allows you to use a wide range of custom fonts for your headings",
            "id" => "font_heading",
            "type" => "dropdown",
            "std" => "josefine_small",
            "subtype" => array(	'Cantarell'=>'cantarell',
            					'Cardo'=>'cardo',
            					'Droid Sans'=>'droidsans',
            					'Inconsolata'=>'inconsolata',
            					'Josefin All Characters'=>'josefine',
            					'Josefin Common Characters'=>'josefine_small',
            					'Lobster'=>'lobster',
            					'Molengo'=>'molengo',
								'Optima'=>'Optima_400', // ideahack added
            					'Reenie Beanie'=>'reeniebeanie',
            					'Tangerine'=>'tangerine',
            					'Vollkorn'=>'vollkorn',
            					'Yanone Kaffeesatz'=>'yanonekaffeesatz'
            					));

	
	
$options[] =  array("type" => "group");	
$options[] = array(	"name" => "Logo",
			"desc" => "Add the full URI path to your logo. the themes default logo gets applied if the input field is left blank<br/>Logo Dimension: 247px * 94px (if your logo is larger you might need to modify style.css to align it perfectly)<br/> URI Exampe: http://www.yourdomain.com/path/to/image.jpg<br/>",
			"id" => "logo",
			"std" => "",
			"size" => 30,
			"type" => "upload");
							
$options[] = array(	"name" => "Google Analytics Code",
		"desc" => "Paste your analytics code here, it will get applied to each page",
        "id" => "analytics",
        "type" => "textarea");

$options[] = array(	"type" => "group");	

$options[] = array(	"name" => "Dummy Data Import",
			"desc" => "If you check the checkbox below and save this page the theme will import dummy data to make it look similar to my Live Preview<br/>This option works best when executed on a new wordpress installation and will help you to understand how to fill posts, pages and set the different theme options.",
			"type" => "title_inside");	


$options[] = array(	"name" => "Import Dummy Data on save",
		"desc" => "Import data?",
        "id" => "dummy",
        "type" => "import",
        "file" => TEMPLATEPATH."/dummy.xml"
        );
	
$options[] = array(	"type" => "group");	
$options[] = array(	"type" => "close");
	
          

$options_page = new kriesi_option_pages($options, $pageinfo);
