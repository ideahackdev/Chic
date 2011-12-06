<?php
######################################################################
# OPTIONSPAGE
######################################################################


$pageinfo = array('full_name' => 'Slideshow Options', 'optionname'=>'slideshow', 'child'=>true, 'filename' => basename(__FILE__));

$options = array (

	array(	"type" => "open"),
	
	array(	"name" => "Mainpage Slideshow",
			"desc" => "",
			"type" => "title_inside",
			"std" => "",
			"id" => "hidden"
			),	
            
   	array(	"name" => "Featured Slider - Number of Slides",
			"desc" => "The slider can display any number of posts (allthough somewhere between 4 and 7 is recommended)",
			"id" => "feature_count",
			"std" => "5",
			"size" => 2,
			"type" => "text"),
			
	    array(  "name" => "Autoplay",
			"desc" => "Should the slider auto-rotate?",
            "id" => "slide_autorotate",
            "type" => "radio",
            "buttons" => array('Yes','No'),
            "std" => 1),
    
    array(	"name" => "Autoplay Duration",
			"desc" => "Enter time between transitions in seconds",
			"id" => "slide_duration",
			"std" => "5",
			"size" => 4,
			"type" => "text"),
			
	 array(	"name" => "Transition Speed",
			"desc" => "Enter time transitions speed in miliseconds",
			"id" => "slide_transition",
			"std" => "900",
			"size" => 4,
			"type" => "text"),	
    
    array(	"type" => "group"),
	array(	"name" => "AviaSlider additional Settings",
		"desc" => "The AviaSlider is highly flexible and customizable. You can create your very own unique slider setup here.<br/>If you want to see whats possible with the slider check the AviaSlider <a href='http://aviathemes.com/aviaslider/' target='_blank'>Demo Page</a>",
		"type" => "title_inside",
		"std" => "",
		"id" => "hidden"
		),
    array(	"name" => "Rectangle height",
			"desc" => "As you can see in the Live Preview the Slider uses Squares/rectangels to create a unique transition. Set the hight here",
            "id" => "box_height",
            "type" => "dropdown",
            "std" => "full",
            "subtype" => array('1 px'=>'1','5 px'=>'5','10 px'=>'10','20 px'=>'20','30 px'=>'30','40 px'=>'40','50 px'=>'50','60 px'=>'60','70 px'=>'70','80 px'=>'80','90 px'=>'90','100 px'=>'100','110 px'=>'110','120 px'=>'120','130 px'=>'130','140 px'=>'140','150 px'=>'150','fullsize'=>'full')), 
            
    
        array(	"name" => "Rectangle width",
			"desc" => "Set the width here",
            "id" => "box_width",
            "type" => "dropdown",
            "std" => "50",
            "subtype" => array('1 px'=>'1','5 px'=>'5','10 px'=>'10','20 px'=>'20','30 px'=>'30','40 px'=>'40','50 px'=>'50','60 px'=>'60','70 px'=>'70','80 px'=>'80','90 px'=>'90','100 px'=>'100','110 px'=>'110','120 px'=>'120','130 px'=>'130','140 px'=>'140','150 px'=>'150','fullsize'=>'full')),         
        
        array(	"name" => "Transition Type",
			"desc" => "Which transition style should be used for each rectangle",
            "id" => "box_transition",
            "type" => "dropdown",
            "std" => "drop",
            "subtype" => array('slide'=>'slide','fade'=>'fade','drop'=>'drop')),   
            
        
        array(	"name" => "Box delay between transitions",
			"desc" => "How long should the script wait between rectangle transitions. (Number in Miliseconds - the smaller the number the shorter the delay)",
			"id" => "box_transition_delay",
			"std" => "90",
			"size" => 3,
			"type" => "text"),   
			
		array(	"name" => "Transition Direction",
			"desc" => "You can choose only one direction for your transitions or create a sequence of transitions with different direction.<br/>If nothing is selected the following sequence will be applied: 'diagonaltop', 'diagonalbottom','topleft', 'bottomright', 'random'",
            "id" => "transition_direction",
            "type" => "multi",
            "subtype" => array('topleft'=>'topleft','bottomright'=>'bottomright','diagonaltop'=>'diagonaltop','diagonalbottom'=>'diagonalbottom','random'=>'random')),
            
			
	array(	"type" => "group"),           
	array(	"type" => "close")


	
			
);

$options_page = new kriesi_option_pages($options, $pageinfo);

######################################################################
# METABOX
######################################################################


global $k_option;

$options = array();
$boxinfo = array('title' => 'Slideshow Entry Options', 'id'=>'slideshow', 'page'=>array('slideshow'), 'context'=>'normal', 'priority'=>'low', 'callback'=>'');

$options[] = array(	"name" => "<strong>Description Text</strong><br/>Enter a description text here, this text will be displayed as image caption along with the post title.",
			"desc" => "",
			"id" => "_img_excerpt",
			"std" => "",
			"size" => 31,
			"type" => "textarea");
			
			
$options[] = array(	"name" => "<strong>Description Text Appearance</strong><br/>Choose if and where the description text should be displayed",
			"desc" => "",
			"id" => "_how_description",
			"std" => "2",
			"size" => 40,
			"subtype" => array('display to the left'=>'2','display to the  right'=>'3','don\'t display at all'=>'hidden'),
			"type" => "dropdown");				
			
$options[] = array(	"name" => "<strong>Optional URL</strong><br/>URL the Slide gets linked to",
			"desc" => "",
			"id" => "_img_url",
			"std" => "",
			"size" => 40,
			"type" => "dropdown_superlink");
			
$options[] = array(	"name" => "<strong>Linking Behaviour</strong><br/>Choose wether you want to display a button that opens the URL provided above or if the whole image should be clickable",
			"desc" => "",
			"id" => "_how_url",
			"std" => "button",
			"size" => 40,
			"subtype" => array('apply link to button'=>'button','apply link to image'=>'image'),
			"type" => "dropdown");	
			
			
$options[] =	 array(	"name" => "<strong>Button Text</strong><br/>If you have choosen to 'apply link by button' choose the button label text here",
			"desc" => "",
			"id" => "_button_text",
			"std" => "Learn more",
			"size" => 20,
			"type" => "text");	
			

$new_box = new kriesi_meta_box($options, $boxinfo);


######################################################################
# POST TYPE
######################################################################

add_action('init', 'slideshow_register');

	function slideshow_register() {
		  $labels = array(
		    'name' => _x('Slider Entries', 'post type general name'),
		    'singular_name' => _x('Slider Entry', 'post type singular name'),
		    'add_new' => _x('Add New', 'slideshow'),
		    'add_new_item' => __('Add New Slider Entry'),
		    'edit_item' => __('Edit Slider Entry'),
		    'new_item' => __('New Slider Entry'),
		    'view_item' => __('View Slider Entry'),
		    'search_items' => __('Search Slider Entries'),
		    'not_found' =>  __('No Slider Entries found'),
		    'not_found_in_trash' => __('No Slider Entries found in Trash'), 
		    'parent_item_colon' => ''
		  );

	
    	$args = array(
        	'labels' => $labels,
        	'public' => true,
        	'show_ui' => true,
        	'capability_type' => 'post',
        	'hierarchical' => false,
        	'rewrite' => true,
        	'show_in_nav_menus'=> false,
        	'menu_position' => 5,
        	'supports' => array('title','thumbnail')
        );

    	register_post_type( 'slideshow' , $args );
	}
