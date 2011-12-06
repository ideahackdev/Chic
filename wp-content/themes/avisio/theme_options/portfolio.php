<?php
$pageinfo = array('full_name' => 'Portfolio Options', 'optionname'=>'portfolio', 'child'=>true, 'filename' => basename(__FILE__));

$options = array (

	array(	"type" => "open"),
	
	array(  "name" => "Portfolio Image Link",
			"desc" => "When clicking on a Portfolio Image what should happen?",
            "id" => "portfolio_click",
            "type" => "radio",
            "buttons" => array('Big Image opens in Lightbox','Show Portfolio Single Post'),
            "std" => 1),   
	
	array(	"type" => "close"),

	array(  "type" => "portfolio",
			"taxonomy" => "portfolio_entries",
			"columnoptions" => array(	'1$full_size$L$nosort'=>'1 Column',
										'2$one_half$M2$nosort'=>'2 Columns',
										'3$one_third$M3$nosort'=>'3 Columns',
										'4$one_fourth$M$nosort'=>'4 Columns',
										'2$one_half$M2$sort'=>'2 Columns sortable',
										'3$one_third$M3$sort'=>'3 Columns sortable',
										'4$one_fourth$M$sort'=>'4 Columns sortable')
		)
);

$options_page = new kriesi_option_pages($options, $pageinfo);



######################################################################
# POST TYPE
######################################################################

add_action('init', 'portfolio_register');

	function portfolio_register() {
		  $labels = array(
		    'name' => _x('Portfolio Items', 'post type general name'),
		    'singular_name' => _x('Portfolio Entry', 'post type singular name'),
		    'add_new' => _x('Add New', 'portfolio'),
		    'add_new_item' => __('Add New Portfolio Entry'),
		    'edit_item' => __('Edit Portfolio Entry'),
		    'new_item' => __('New Portfolio Entry'),
		    'view_item' => __('View Portfolio Entry'),
		    'search_items' => __('Search Portfolio Entries'),
		    'not_found' =>  __('No Portfolio Entries found'),
		    'not_found_in_trash' => __('No Portfolio Entries found in Trash'), 
		    'parent_item_colon' => ''
		  );
	
	
		//change the slug here if you want to use a different url scheme for your portfolio entries
		//after you have changed the slug you need to open your wordpress permalink settings and hit the save button
		$slugRule = 'portfolio';
		
    	$args = array(
        	'labels' => $labels,
        	'public' => true,
        	'show_ui' => true,
        	'capability_type' => 'post',
        	'hierarchical' => false,
        	'rewrite' => array('slug'=>$slugRule,'with_front'=>true),
        	'query_var' => true,
        	'show_in_nav_menus'=> false,
        	'menu_position' => 5,
        	'supports' => array('title','thumbnail','excerpt','editor','comments')
        );

    	register_post_type( 'portfolio' , $args );
    	
    	
    	register_taxonomy("portfolio_entries", 
					    	array("portfolio"), 
					    	array(	"hierarchical" => true, 
					    			"label" => "Portfolio Categories", 
					    			"singular_label" => "Portfolio Categories", 
					    			"rewrite" => true,
					    			"query_var" => true

					    		));  

	}

#portfolio_columns, <-  register_post_type then append _columns
add_filter("manage_edit-portfolio_columns", "prod_edit_columns");
add_action("manage_posts_custom_column",  "prod_custom_columns");

function prod_edit_columns($columns){

		$newcolumns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => "Title",
			"portfolio_entries" => "Categories"
		);
		
		$columns= array_merge($newcolumns, $columns);

		return $columns;
}

function prod_custom_columns($column){
		global $post;
		switch ($column)
		{
			case "description":
				#the_excerpt();
				break;
			case "price":
				#$custom = get_post_custom();
				#echo $custom["price"][0];
				break;
			case "portfolio_entries":
				echo get_the_term_list($post->ID, 'portfolio_entries', '', ', ','');
				break;
		}
}



