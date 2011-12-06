<?php 

$k_option['custom']['headlineContent'] = '<h2>'.__('The Page could not be found','avisio').'</h2>';

get_header(); 

	?>


<div class="wrapper" id='wrapper_main'>

	<div class="center">		
		
		<div id="main">
				
		<div class='content'>
		
			<div class="entry">

			<h1 class="siteheading">
			<?php _e('ERROR 404','avisio'); ?>
			</h1>
			
			<div class="entry-content">
			<strong> <?php _e('We are sorry, the page you are looking for does not exist','avisio'); ?></strong>
			<p><?php _e('You might want to try our site search or to browse the site with the help of the main navigation menu','avisio'); ?></p> 
			<!--end entry-content-->
			</div>


	 			
	 		<!--end entry -->	
 			</div>
 			
	
		<!--end content-->
		</div>	
			
		
		<?php
		$k_option['showSidebar'] = 'page';
		 get_sidebar(); ?>
		
		<!--end main-->
		</div>
		
		
<?php get_footer();  ?>