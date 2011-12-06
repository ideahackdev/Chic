<?php 
global $k_option;

get_header(); 

?>


<div class="wrapper fullwidth" id='wrapper_main'>

	<div class="center">		
		
		<div id="main">
				
		<div class='content'>
		
			<div class="entry"><?php ?>
			<?php
		
			if (have_posts()) :
			while (have_posts()) : the_post();	
		 	$more = 1;

		 	
			$terms = get_the_term_list( $post->ID, 'portfolio_entries', '', ', ', '' ); 
		 	//get preview image
		 	$big_prev_image = kriesi_post_thumb($post->ID, array('size'=> array('L'),
															 'wh' => $k_option['custom']['imgSize']['L'],
															 'display_link' => array('lightbox'), 
															'linkurl' => array ('XL','_preview_big')
															));
				if($big_prev_image != "" && !is_attachment()) echo "<span class='framed framed_full_size'><span>".$big_prev_image."</span></span>";

			?>

	           
			<h1 class="siteheading">
			<a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link:','avisio')?> <?php the_title(); ?>"><?php the_title(); ?>
			</a>
			</h1>
			
				<div class="entry-head">
					<span class="categories"><?php _e('Posted in: ', 'avisio'); the_category(', '); echo $terms; ?></span><span class='limit'>-</span>
					<span class="date"><?php the_time('M d, Y') ?></span>
					<span class="comments"><?php comments_popup_link(__('No Comments','avisio'), __('1 Comment','avisio'), __('% Comments','avisio')); ?></span>
				</div>
			
			
			<div class="entry-content">
			<?php 

			the_meta();
			
			the_content(); ?>
			<?php edit_post_link('Edit', '', ''); ?>
			<!--end entry-content-->
			</div>

 			<?php
		
		endwhile;
		endif;

			?>
			
	 			
	 		<!--end entry -->	
 			</div>
 			



 			<div class='hr'><a href="#top" class='scrollTop'>top</a></div>
 			
 			<div class='entry commententries'>
           		<?php comments_template(); ?>
           	</div>
	
		<!--end content-->
		</div>	
			
		
		
		<!--end main-->
		</div>
		
		
<?php get_footer(); ?>