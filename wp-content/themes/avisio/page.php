<?php 
###############################################################################################
# Check if the page displayed has a different template applied within the custom admin page
# if thats the case display the template file, otherwise display the basic page template
###############################################################################################

global $k_option;
######################################################################
# Check for blog and contact pages
######################################################################
if ($post->ID == $k_option['contact']['contact_page']) $contactpage = true;
else if ($post->ID == $k_option['blog']['blog_page']) $blogpage = true;


######################################################################
# Check for portfolio pages
######################################################################
if(isset($k_option['portfolio']['matrix_slider_port_final']) && $k_option['portfolio']['matrix_slider_port_final'] != ''){
	foreach($k_option['portfolio']['matrix_slider_port_final'] as $key => $value)
	{
		if ($post->ID == $key)
		{	
			$portfoliopage = true;
		} 
	}
}

######################################################################
# Include page templates if other template is applied to the page
######################################################################
if($contactpage)
{
	include(TEMPLATEPATH."/template_contact.php");
}
else if($blogpage)
{
	include(TEMPLATEPATH."/template_blog.php");
}
else if($portfoliopage)
{
	include(TEMPLATEPATH."/template_portfolio.php");
}
else
{
######################################################################
# Display Basic Page
######################################################################

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
		 	$big_prev_image = kriesi_post_thumb($post->ID, array('size'=> array('L','_preview_medium'),
															 'wh' => $k_option['custom']['imgSize']['L'],
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
		
		
<?php get_footer(); } ?>