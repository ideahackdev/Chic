<?php
global $k_option;

$options = array();
$boxinfo = array('title' => 'Post Thumbnail Options', 'id'=>'post_thumb_overwrite', 'page'=>array('post','page','portfolio'), 'context'=>'side', 'priority'=>'low', 'callback'=>'');

$options[] = array(	"name" => "<strong>Thumbnail overwrite options</strong><br/>Preview pictures are generated automatically. If you dont like the output you can set it manually here. (only for small pictures like on portfolio page)",
			"type" => "title");
		

$options[] = array(	"name" => "Preview Picture overwrite",
			"desc" => "Image",
			"id" => "_preview_medium",
			"std" => "",
			"button_label" => "Insert Image",
			"size" => 31,
			"type" => "media");
			
			
			
$options[] = array(	"name" => "The lightbox can not only contain a bigger version of the image, it can also contain another image or a video",
			"type" => "title");
		

$options[] = array(	"name" => "<strong>Full Size Pic or Video for Lightbox</strong>",
			"desc" => "Image and Video Links allowed",
			"id" => "_preview_big",
			"std" => "",
			"button_label" => "Insert Image/Video",
			"size" => 31,
			"type" => "media");

$new_box = new kriesi_meta_box($options, $boxinfo);






$options = array();
$boxinfo = array('title' => 'Additional page/post options', 'id'=>'extra_option', 'page'=>array('post','page','portfolio'), 'context'=>'normal', 'priority'=>'high', 'callback'=>'');
			
$options[] = array(	"name" => "<strong>Additional Headline</strong><br/>Enter a headline that should appear above your entry/page here.",
			"desc" => "",
			"id" => "_headline",
			"std" => "",
			"size" => 70,
			"type" => "text");

$new_box3 = new kriesi_meta_box($options, $boxinfo);



