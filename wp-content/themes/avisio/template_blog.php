<?php
/*
Template Name: Blog Overview
*/
if($k_option['blog']['headline'])
$k_option['custom']['headlineContent'] = "<h2>".$k_option['blog']['headline']."</h2>";

 get_header(); 

	$negative_cats = preg_replace("!(\d)+!","-${0}$0", $k_option['blog']['blog_cat_final']);
	$query_string = "cat=".$negative_cats."&paged=$paged";
	

	// the query string now looks like this:
	// "cat=-3,-10-12&paged=$paged";
	// you can add additional query options if you want, all of them are described here:
	// http://codex.wordpress.org/Template_Tags/query_posts#Examples
	// append this parameters with the "&" sign
	
	// example: $query_string =  $query_string."&orderby=author&order=ASC";
	?>
	
	<div class="wrapper fullwidth" id='wrapper_main'>

	<div class="center">		
		
		<div id="main">
				
		<div class='content'>
		
			<div class="entry">
	
	<?php
	$additional_loop = new WP_Query($query_string);
	
	if ($additional_loop->have_posts()) :
	while ($additional_loop->have_posts()) : $additional_loop->the_post();	
 	$more = 0;
 	
 	
 	
 	//get preview image
 	$big_prev_image = kriesi_post_thumb($post->ID, array('size'=> array('L'),
													 'wh' => $k_option['custom']['imgSize']['L'],
													 'display_link' => array($k_option['blog']['overview_image']), 
													'linkurl' => array ('XL','_preview_big'),
													));
	
	if($big_prev_image != "") echo "<span class='framed framed_full_size'><span>".$big_prev_image."</span></span>";
	?>
	
<h1 class="siteheading">
			<a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link:','avisio')?> <?php the_title(); ?>"><?php the_title(); ?>
			</a>
			</h1>
			
				<div class="entry-head">
					<span class="categories"><?php _e('Posted in: ', 'avisio');  the_category(', '); ?></span><span class='limit'>-</span>
					<span class="date"><?php the_time('M d, Y') ?></span>
					<span class="comments"><?php comments_popup_link(__('No Comments','avisio'), __('1 Comment','avisio'), __('% Comments','avisio')); ?></span>
				</div>
			
			
			<div class="entry-content">
			<?php 
			
			echo get_the_post_thumbnail( $post_id, 'medium'); 
			
			the_meta(); // ideahack added
			
			the_excerpt();
			
			//the_content(__('Read more &raquo;','avisio')); 
			?>
			<?php edit_post_link('Edit', '', ''); ?>
			<!--end entry-content-->
			</div>

	 		<div class="hr"><a href="#top" class="scrollTop">top</a></div>
 			<?php
		
		endwhile;		
		else: 
		
			echo'<h2>'.__('Nothing Found','avisio').'</h2>';
			echo'<p>'.__('Sorry, no posts matched your criteria','avisio').'</p>';
			
		endif;
		
		kriesi_pagination($additional_loop->max_num_pages);
		echo "</div></div>";
	
		echo '<div class="hr"></div>';
		echo '<div id="blogcategories">Categories';
		wp_list_categories('title_li=0');
		echo '</div>';
		
		echo '<div id="blogarchives">Archives';
		wp_get_archives('type=monthly&show_post_count=1');
		echo '</div>';
		
//	$k_option['showSidebar'] = 'blog';
	?>
	<!--end main-->
		</div>
	<?php

	get_footer();
?>			

