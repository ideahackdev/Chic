<?php

/* If this is a category archive */ 
$output = "";
$useTemplate ="";
if (is_category()) { 		
$output = __('Archive for ','avisio').single_cat_title('',false);
} elseif (is_day()) {
$output = __('Archive for ','avisio').get_the_time('F jS, Y');
} elseif (is_month()){ 
$output = __('Archive for ','avisio').get_the_time('F, Y'); 
} elseif (is_year()) { 
$output = __('Archive for ','avisio').get_the_time('Y'); 
} elseif (is_search()) {
$output = __('Search Results','avisio'); 
} elseif (is_author()) { 
$output = __('Author Archive','avisio'); 
} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
$output = __('Blog Archives','avisio');
} elseif(is_tax()){
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
$output = __('Archive for ','avisio').$term->name;
$useTemplate = $term->slug;
}
 
if($output != "") $k_option['custom']['headlineContent'] = '<h2>'.$output.'</h2>';
		
if($useTemplate != '')
{
	include(TEMPLATEPATH."/template_portfolio.php");
}
else
{		
get_header(); 


	
	?>
	
	<div class="wrapper fullwidth" id='wrapper_main'>

	<div class="center">		
		
		<div id="main">
				
		<div class='content'>
		
			<div class="archiveentry entry">
	
	<?php
		
	if (have_posts()) :
	while (have_posts()) : the_post();	
 	$more = 0;
 	$extraclass = 'noImage';
 	$terms = get_the_term_list( $post->ID, 'portfolio_entries', '', ', ', '' ); 

 	//get preview image
 	$big_prev_image = kriesi_post_thumb($post->ID, array('size'=> array('M'),
													 'wh' => $k_option['custom']['imgSize']['M'],
													 'display_link' => array('permalink')
													));
													
	if($big_prev_image != "") 
	{
		echo "<span class='fullwidth imagewrap'><span class='framed framed_one_fourth one_fourth'><span>".$big_prev_image."</span></span></span>";
		$extraclass ='withImage';
	}

	?>
<div class='contentwrap <?php echo $extraclass; ?>'>
<h1 class="siteheading">
			<a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link:','avisio')?> <?php the_title(); ?>"><?php the_title(); ?>
			</a>
			</h1>
			
				<div class="entry-head">
				<?php 
				$category = get_the_category();
				if(isset($category[0]->cat_name) || $terms != ''){ 
				?>
				<span class="categories"><?php _e('Posted in: ', 'avisio'); the_category(', '); echo $terms; ?></span><span class='limit'>-</span><?php } ?>
					<span class="date"><?php the_time('M d, Y') ?></span>
					<span class="comments"><?php comments_popup_link(__('No Comments','avisio'), __('1 Comment','avisio'), __('% Comments','avisio')); ?></span>
				</div>
			
			
			<div class="entry-content">
			<?php 
			the_excerpt(); ?>
			<?php edit_post_link('Edit', '', ''); ?>
			<!--end entry-content-->
			

			
			</div>
</div>
	 		<div class="hr"><a href="#top" class="scrollTop">top</a></div>
 			<?php
		
		endwhile;		
		else: 
		
			echo'<h2>'.__('Nothing Found','avisio').'</h2>';
			echo'<p>'.__('Sorry, your search didn\'t return any results.','avisio').'</p>';
			echo'<p>'.__('Please try again with another term.','avisio').'</p>';
			
		endif;
		
		kriesi_pagination();
		echo "</div></div>";

	// $k_option['showSidebar'] = 'blog';
	// 							get_sidebar();
	// 							
	echo "</div>";
	
	get_footer();
}
?>			

