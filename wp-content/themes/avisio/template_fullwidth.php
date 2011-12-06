<?php 
/*
Template Name: Full Width
*/ 

global $k_option, $blogpage, $contactpage;

get_header(); 
	?>


<div class="wrapper fullwidth" id='wrapper_main'>

	<div class="center">		
		
		<div id="main">
				
		<div class='content'>
		
			<div class="entry">
			<?php
			
			if (have_posts()) :
			while (have_posts()) : the_post();	
		 	$more = 1;

		 	//get preview image
		 	$big_prev_image = kriesi_post_thumb($post->ID, array('size'=> array('XL','_preview_medium'),
															 'wh' => $k_option['custom']['imgSize']['XL'],
															 'display_link' => array('lightbox'), 
															'linkurl' => array ('XL','_preview_big'),
															));
			?>

	           
			<h1 class="siteheading">
			<a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link:','avisio')?> <?php the_title(); ?>"><?php the_title(); ?>
			</a>
			</h1>
			
			
			<div class="entry-content">
			<?php 
			echo $big_prev_image;
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
 			
	
		<!--end content-->
		</div>	
			
		
		
		<!--end main-->
		</div>
		
		
<?php get_footer(); ?>