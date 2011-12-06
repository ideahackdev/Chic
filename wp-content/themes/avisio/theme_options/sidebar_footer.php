<?php
$pageinfo = array('full_name' => 'Sidebar &amp; Footer', 'optionname'=>'includes', 'child'=>true, 'filename' => basename(__FILE__));

$options = array (

	array(	"type" => "open"),
	   array(	"name" => "Sidebar Widgets",
			"desc" => "",
			"type" => "title_inside",
			),

	array(	"name" => "Extra Widget Areas for specific Pages",
			"desc" => "Here you can add widget areas for single pages. that way you can put different content for each page into your sidebar.<br/>
After you have choosen the Pages press the 'Save Changes' button and then start adding widgets to your new widget areas <a href='widgets.php'>here</a>.<br/><br/>

<strong>Attention</strong> when removing areas: You have to be carefull when deleting widget areas that are not the last one in the list.<br/> It is recommended to avoid this. If you want to know more about this topic please read the documentation that comes with this theme.<br/>",
            "id" => "multi_widget",
            "type" => "multi",
            "subtype" => "page"),
            
	array(	"name" => "Extra Widget Areas for specific Categories",
			"desc" => "Here you can add widget areas for single Categories. that way you can put different content for each Category into your sidebar.<br/>
After you have choosen the Category press the 'Save Changes' button and then start adding widgets to your new widget areas <a href='widgets.php'>here</a>.<br/><br/>

<strong>Attention</strong> when removing areas: You have to be carefull when deleting widget areas that are not the last one in the list.<br/> It is recommended to avoid this. If you want to know more about this topic please read the documentation that comes with this theme.<br/>",
            "id" => "multi_widget_cat",
            "type" => "multi",
            "subtype" => "cat"),
 
 	array(  "name" => "Display Widget areas for categories on posts of that category as well",
			"desc" => "If you have set special widget areas for categories you can choose to display them on the single post view as well, if that category is applied to this post",
            "id" => "single_post_multi_widget_cat",
            "type" => "radio",
            "buttons" => array('yes','no'),
            "std" => 1),
            
	array(  "name" => "Display 'dummy' sidebars widgets",
			"desc" => "When no sidebar widgets are set for a specific post page or category should the theme set default dummy sidebars?",
            "id" => "dummy_sidebars",
            "type" => "radio",
            "buttons" => array('yes','no'),
            "std" => 1),
            
   array(	"name" => "Footer",
			"desc" => "",
			"type" => "title_inside",
			),	 
        
   	array(	"name" => "Facebook Account",
			"desc" => "Enter the link to your facebook account to create a small icon link within your footer",
			"id" => "acc_fb",
			"std" => "pages/Kriesi/333648177216",
			"size" => 20,
			"type" => "text"),	
			
	array(	"name" => "Flickr Account",
			"desc" => "Enter the name of your flickr account to create a small icon link within your footer (looks something like this: 34166943@N05 )",
			"id" => "acc_fl",
			"std" => "34166943@N05",
			"size" => 20,
			"type" => "text"),	
			
	array(	"name" => "Twitter Account",
			"desc" => "Enter the name of your twitter account to create a small icon link within your footer",
			"id" => "acc_tw",
			"std" => "kriesi",
			"size" => 20,
			"type" => "text"),	
            
	array(	"type" => "close")


	
			
);



$options_page = new kriesi_option_pages($options, $pageinfo);

#####################################################################
# Define Sidebars
#####################################################################

if($k_option['includes']['sidebarCount'] == 2)
{
	$k_option['custom']['sidebars'] = array('left','right');
}
else
{
	$k_option['custom']['sidebars'] = array('left');
}

$k_option['custom']['footer'] = array('left','center','right');