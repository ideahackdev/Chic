<?php
/* Add our function to the widgets_init hook. */
add_action( 'widgets_init', 'kriesi_sidebar_news_widget' );

/* Function that registers our widget. */
function kriesi_sidebar_news_widget() {
	global $kriesiaddwidget;
	$kriesiaddwidget = 0;
	register_widget( 'Kriesi_sidebar_news_Widget' );
}

class Kriesi_sidebar_news_Widget extends WP_Widget {
	function Kriesi_sidebar_news_Widget() 
	{
		$widget_ops = array('classname' => 'community_news', 'description' => 'A Sidebar widget to display posts in your sidebar' );
		
		$this->WP_Widget( 'community_news', THEMENAME.' Sidebar News', $widget_ops );
	}
 
	function widget($args, $instance) 
	{	
		global $k_option;
		extract($args, EXTR_SKIP);
		echo $before_widget;
		
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$count = empty($instance['count']) ? '' : apply_filters('widget_entry_title', $instance['count']);
		$cat = empty($instance['cat']) ? '' : apply_filters('widget_comments_title', $instance['cat']);
		
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		
		$additional_loop = new WP_Query("cat=".$cat."&posts_per_page=".$count);
		if($additional_loop->have_posts()) : 
		while ($additional_loop->have_posts()) : $additional_loop->the_post();
		
		global $post; 
		$small_prev = kriesi_post_thumb($post->ID, array('size'=> array('S'),
															'display_link' => array('permalink'),
															'wh' => $k_option['custom']['imgSize']['S'],
															'img_attr' => array('class'=>'rounded_small ie6fix alignleft'),
															'link_attr' => array('class'=>'alignleft  preloading_background')
															));
		?>
		
			<div class="entry box_entry">
			<h4><a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link:','avisio')?><?php the_title(); ?>"><?php the_title(); ?></a></h4>
			
			<?php 
			if($small_prev) echo $small_prev;
			the_excerpt('Read more'); ?>
			</div>
		
		<?php 
		endwhile;
		endif;

		
		
		
		echo $after_widget;
		
	}
 
 
	function update($new_instance, $old_instance) 
	{
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['count'] = strip_tags($new_instance['count']);
		$instance['cat'] = strip_tags($new_instance['cat']);
		return $instance;
	}

 
 
	function form($instance) 
	{
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'count' => '', 'cat' => '' ) );
		$title = strip_tags($instance['title']);
		$count = strip_tags($instance['count']);
		$cat = strip_tags($instance['cat']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: 
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
		
		<p><label for="<?php echo $this->get_field_id('count'); ?>">How many entries do you want to display: 
		<input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo attribute_escape($count); ?>" /></label></p>
		
		<p><label for="<?php echo $this->get_field_id('cat'); ?>">Enter the ids of the categories you want to display, separate them by comma:
		<input class="widefat" id="<?php echo $this->get_field_id('cat'); ?>" name="<?php echo $this->get_field_name('cat'); ?>" type="text" value="<?php echo attribute_escape($cat); ?>" /></label></p>
		
			
<?php
	}
}
