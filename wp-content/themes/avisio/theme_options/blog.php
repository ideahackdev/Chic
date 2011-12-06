<?php
$pageinfo = array('full_name' => 'Blog Options', 'optionname'=>'blog', 'child'=>true, 'filename' => basename(__FILE__));

$options = array (

	array(	"type" => "open"),

	array(	"name" => "Blog Page",
			"desc" => "The Page you choose here will display the Blog in addition to the normal page content:",
	        "id" => "blog_page",
	        "type" => "dropdown",
	        "subtype" => "page"),
	        
	
	 array(	"name" => "Blog Page Headline",
			"desc" => "Enter a Blog headline that should appear above your gallery entries here.<br/>",
			"id" => "headline",
			"std" => "Get some inspiration! The best flash and html sites available on the net.",
			"size" => 70,
			"type" => "text"),
			
	array(	"name" => "Blog Overview Preview Images",
	"desc" => "What should happen if a user clicks an Image on the Blog overview page?",
    "id" => "overview_image",
    "type" => "dropdown",
    "std" => "lightbox",
    "subtype" => array('Open lightbox'=>'lightbox','Open single post view'=>'permalink')),		
			
     	array(	"name" => "Exclude Categories",
			"desc" => "The blog Page usually displays all Categorys, since sometimes you want to exclude some of these categories (for example porfolio entries) you can EXCLUDE multiple categories here:",
            "id" => "blog_cat",
            "type" => "multi",
            "subtype" => "cat"),       	       
	
	array(	"type" => "close")

	
);

$options_page = new kriesi_option_pages($options, $pageinfo);
