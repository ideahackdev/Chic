<?php

global $k_option;


#########################################

if ( function_exists('register_sidebar') )
{	
	

		register_sidebar(array(
			'name' => 'Displayed Everywhere',
			'before_widget' => '<div id="%1$s" class="box_small box widget %2$s">', 
		'after_widget' => '</div>', 
		'before_title' => '<h3 class="widgettitle">', 
		'after_title' => '</h3>', 
		));
	

		register_sidebar(array(
			'name' => 'Sidebar Blog',
			'before_widget' => '<div id="%1$s" class="box_small box widget %2$s">', 
		'after_widget' => '</div>', 
		'before_title' => '<h3 class="widgettitle">', 
		'after_title' => '</h3>', 
		));
	
	
	
		register_sidebar(array(
			'name' => 'Sidebar Pages',
			'before_widget' => '<div id="%1$s" class="box_small box widget %2$s">', 
		'after_widget' => '</div>', 
		'before_title' => '<h3 class="widgettitle">', 
		'after_title' => '</h3>', 
		));
		
		
	$k_option['custom']['footer'] = array('column1','column2','column3','column4');

	foreach ($k_option['custom']['footer'] as $footer_widget)
	{
		register_sidebar(array(
		'name' => 'Footer - '.$footer_widget,
		'before_widget' => '<div id="%1$s" class="box_small box widget %2$s">', 
		'after_widget' => '</div>', 
		'before_title' => '<h3 class="widgettitle">', 
		'after_title' => '</h3>', 
		));
	}
	

	
	
		$dynamic_widgets = explode(',',$k_option['includes']['multi_widget_final']);
		foreach ($dynamic_widgets as $page_name)
		{	
		
			if($page_name != "")
			register_sidebar(array(
			'name' => 'Page: '.get_the_title($page_name),
			'before_widget' => '<div id="%1$s" class="box_small box widget %2$s">', 
			'after_widget' => '</div>', 
			'before_title' => '<h3 class="widgettitle">', 
			'after_title' => '</h3>', 
			));
		
	}
	
	
	
	$dynamic_widgets_cat = explode(',',$k_option['includes']['multi_widget_cat_final']);
	foreach ($dynamic_widgets_cat as $the_cat)
	{
	
		
			$the_cat_name = get_cat_name($the_cat);

			if($the_cat_name != "")
			register_sidebar(array(
			'name' => 'Category: '.$the_cat_name,
			'before_widget' => '<div id="%1$s" class="box_small box widget %2$s">', 
			'after_widget' => '</div>', 
			'before_title' => '<h3 class="widgettitle">', 
			'after_title' => '</h3>', 
			));
		
	}
}


	
	
	
	function dummy_widget($number)
	{
		switch($number)
		{
			case 1: 
				echo"<div class='box box_small widget_archive'>";
				echo"<h3>Archive</h3>";
				echo"<ul>";
				wp_get_archives('type=monthly');
				echo"</ul>";
				echo"</div>";
			break;
			
			case 2: 
				echo"<div class='box box_small widget_archive'>";
				echo"<h3>Categories</h3>";
				echo"<ul>";
				wp_list_cats('sort_column=name&optioncount=0&hierarchical=0');
				echo"</ul>";
				echo"</div>";
			break;
			
			case 3: 
				echo"<div class='box box_small widget_archive'>";
				echo"<h3>Pages</h3>";
				echo"<ul>";
				wp_list_pages('title_li=&depth=-1' );
				echo"</ul>";
				echo"</div>";
			break;
			
			case 4: 
				echo"<h3>Latest News</h3>";
				$sbNews = new Kriesi_sidebar_news_Widget();
				$sbNews->widget(array(),'');
			break;
		}
	}