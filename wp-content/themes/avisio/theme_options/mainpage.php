<?php
$pageinfo = array('full_name' => 'Mainpage Options', 'optionname'=>'mainpage', 'child'=>true, 'filename' => basename(__FILE__));

$options = array (

	array(	"type" => "open"),
	array(	"type" => "group"),
		
	array(	"name" => "Headline Button Text",
		"desc" => "Enter the text of the button besides the mainpage headline.<br/>",
		"id" => "buttonText",
		"std" => "Our Work",
		"size" => 30,
		"type" => "text"),
		
	array(	"name" => "Headline Button Link",
		"desc" => "Where should the button link to:",
        "id" => "buttonLink",
        "type" => "dropdown",
        "subtype" => "page"),
	
	array(	"type" => "group"),	
	
	array(	"name" => "Mainpage Content",
			"desc" => "Select the pages you want to display on your front page here. They are grouped with the help of tabs",
            "id" => "mainpage_content",
            "type" => "multi",
            "subtype" => "page"),	
		
	
	array(	"type" => "group"),

            
	array(	"type" => "close")


	
			
);

$options_page = new kriesi_option_pages($options, $pageinfo);
