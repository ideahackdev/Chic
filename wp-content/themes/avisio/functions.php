<?php
global $k_option;



load_theme_textdomain('avisio');

add_custom_background();

#####################################################################
# Define Thumbnail sizes
#####################################################################
$k_option['custom']['imgSize']['base'] = array('width'=>267, 'height'=>180); 	// backend preview size, if changed does not affect the frontend
$k_option['custom']['imgSize']['S'] = array('width'=>70, 'height'=>50);			// small preview pics eg sidebar news
$k_option['custom']['imgSize']['M'] = array('width'=>192, 'height'=>130);		// medium preview pic for portfolio with 4 columns
$k_option['custom']['imgSize']['M3'] = array('width'=>274, 'height'=>170);		// medium preview pic for portfolio with 3 columns
$k_option['custom']['imgSize']['M2'] = array('width'=>436, 'height'=>230);		// medium preview pic for portfolio with 2 columns
$k_option['custom']['imgSize']['L'] = array('width'=>574, 'height'=>268);		// image for blog posts and 1 column portfolio
$k_option['custom']['imgSize']['XL'] = array('width'=>940, 'height'=>440);		// big images for fullsize pages and mainpage slider


##################################################################
# Get Theme informations and save them to PHP Constants
##################################################################
$the_theme = get_theme_data(TEMPLATEPATH . '/style.css');
$the_version = trim($the_theme['Version']);
if(!$the_version) $the_version = "1";

//set theme constants
define('THEMENAME', $the_theme['Title']);
define('THEMEVERSION', $the_version);

// set Path constants
define('KFW', TEMPLATEPATH . '/framework/'); // 'K'riesi 'F'rame 'W'ork;
define('KFWOPTIONS', 	TEMPLATEPATH . '/theme_options/'); 
define('KFWHELPER', 	KFW . 'helper_functions/'); 
define('KFWCLASSES', 	KFW . 'classes/'); 
define('KFWPLUGINS', 	KFW . 'theme_plugins/');
define('KFWWIDGETS', 	KFW . 'theme_widgets/'); 
define('KFWINC', 		KFW . 'includes/'); 
define('KFWSC', 		KFW . 'shortcodes/'); 

// set URI constants
define('KFW_URI', get_bloginfo('template_url') . '/framework/'); // 'K'riesi 'F'rame 'W'ork;
define('KFWOPTIONS_URI', 	get_bloginfo('template_url') . '/theme_options/'); 
define('KFWHELPER_URI', 	KFW_URI . 'helper_functions/'); 
define('KFWCLASSES_URI', 	KFW_URI . 'classes/'); 
define('KFWPLUGINS_URI', 	KFW_URI . 'theme_plugins/'); 
define('KFWWIDGET_URI', 	KFW_URI . 'theme_widgets/'); 
define('KFWINC_URI', 		KFW_URI . 'includes/'); 
define('KFWINC_SC', 		KFW_URI . 'shortcodes/'); 


##################################################################
# this include calls a file that automatically includes all 
# the files within the folder framework and therefore makes 
# all functions and classes available for later use
##################################################################



$autoload['helper'] = array(	'header_includes',			# javascript and css includes for header.php
								'lots_of_small_helpers', 	# helper functions that make my developer-life easier =)
								'pagination',				# pagination function
								'nav_menu',					# alternate navigation output
								'kriesi_post_thumb',		# display a resized image
								'theme_activation'
								);

$autoload['classes'] = array(	'kclass_display_box',
								'kclass_display_slideshow',
								'kclass_description_walker',
								'kclass_breadcrumb',
								'kclass_advanced_css_style'
								);


$autoload['plugins'] = array('kriesi_option_pages/kriesi_option_pages',		
							'kriesi_meta_box/kriesi_meta_box'
							);
														

$autoload['widgets'] = array('sidebar_news');

$autoload['option_pages'] = array('options',
								'slideshow',
								'mainpage',
								'portfolio',
								'blog',
								'contact',
								'sidebar_footer',
								'meta_box'
								 );
								 
$autoload['templatefiles'] = array('wp_list_comments','widgets');	
$autoload['shortcodes'] = array('pullquotes','columns','dropcaps','delimiter','toggle_tabs','slideshow');							

include_once(KFW.'/include_framework.php');


// IDEAHACK FUNCTIONS

//create menus
    add_action( 'init', 'register_my_menus' );
     
    function register_my_menus() {
    register_nav_menus(
    array(
    'menu-2' => __( 'FrontPageMenuBottom' ),
    )
    );
    }

// create a custom trip post type

add_action('init', 'codex_custom_init');
function codex_custom_init() 
{
  $labels = array(
    'name' => _x('Trips', 'post type general name'),
    'singular_name' => _x('Trip', 'post type singular name'),
    'add_new' => _x('Add New', 'trip'),
    'add_new_item' => __('Add New Trip'),
    'edit_item' => __('Edit Trip'),
    'new_item' => __('New Trip'),
    'all_items' => __('All Trips'),
    'view_item' => __('View Trips'),
    'search_items' => __('Search Trips'),
    'not_found' =>  __('No trips found'),
    'not_found_in_trash' => __('No trips found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'Trips'

  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','editor','author','thumbnail','excerpt','custom-fields')
  ); 
  register_post_type('trip',$args);
}

// create a custom taxonomy to post trip data to a post

//hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_trip_taxonomies', 0 );
function create_trip_taxonomies() {
	
	// $labels = array(
	//     'name' => _x( 'Writers', 'taxonomy general name' ),
	//     'singular_name' => _x( 'Writer', 'taxonomy singular name' ),
	//     'search_items' =>  __( 'Search Writers' ),
	//     'popular_items' => __( 'Popular Writers' ),
	//     'all_items' => __( 'All Writers' ),
	//     'parent_item' => null,
	//     'parent_item_colon' => null,
	//     'edit_item' => __( 'Edit Writer' ), 
	//     'update_item' => __( 'Update Writer' ),
	//     'add_new_item' => __( 'Add New Writer' ),
	//     'new_item_name' => __( 'New Writer Name' ),
	//     'separate_items_with_commas' => __( 'Separate writers with commas' ),
	//     'add_or_remove_items' => __( 'Add or remove writers' ),
	//     'choose_from_most_used' => __( 'Choose from the most used writers' ),
	//     'menu_name' => __( 'Writers' ),
	//   ); 
	// 
	//   register_taxonomy('writer','trip',array(
	//     'hierarchical' => false,
	//     'labels' => $labels,
	//     'show_ui' => true,
	//     'update_count_callback' => '_update_post_term_count',
	//     'query_var' => true,
	//     'rewrite' => array( 'slug' => 'writer' ),
	//   ));
	  
	
	
}
