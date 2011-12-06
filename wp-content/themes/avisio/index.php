
<?php get_header(); ?>
<div class="wrapper wrapper_shadow ie6fix" id='wrapper_featured_area'>
<div class='overlay_top ie6fix'></div>
<div class='overlay_bottom ie6fix'></div>
	<div class="center ie6fix">
				
		<!-- ###################################################################### -->
		<div class="feature_wrap">
		<!-- ###################################################################### -->
			
			
			<?php 
			//this class creates the slideshow				
			// SET SLIDER OPTIONS
			$slideshow = new kclass_display_slideshow();
			$slideshow->setQueryType('slideshow');
			$slideshow->setQueryNumber($k_option['slideshow']['feature_count']);
			$slideshow->setSlideshowSize('XL');
			$slideshow->setSlideshowClass('aviaslider');
			$slideshow->setCaption('_img_excerpt');
			$slideshow->setWelcome("You can add Slides manually at your backend <a href='".get_option('siteurl')."/wp-admin/edit.php?post_type=slideshow' title=''>here</a> or you can use the <a href='".get_option('siteurl')."/wp-admin/options.php?page=options.php' title=''>dummy content installer</a> to create some slides for you so you see how it is done ;)");
			$slideshow->show();

			?>		

		<!-- ###################################################################### -->
		</div><!-- end featuredwrap -->
		<!-- ###################################################################### -->
			
			
			
<div id="fontpagebottom">
	
	    <?php wp_nav_menu( array( 'theme_location' => 'menu-2' ) ); ?>
	
</div>	
		
		
	<!-- end center-->
	</div>
<!--end wrapper-->
</div>

<!-- <div class="wrapper" id='wrapper_featured_stripe'> -->

	<!-- <div class="center"> -->
	
			<?php
			
			
			
			$slideshow->setSlideshowSize('S');
			// $slideshow->showThumbnails();	// ideahack - don't show the thumbnails
			
			
			?>
			
			<!-- <div id="tagline_text"><h1 class='fptab'>Premium experiences worldwide.<h1></div>    	ideahack -->
			
			<?php
			
			// if($k_option['mainpage']['buttonText'])
			// 					{
			// 						echo '<a href="'.get_permalink($k_option['mainpage']['buttonLink']).'" class="big_button heading ie6fix">';
			// 						echo '<strong class="ie6fix">'.$k_option['mainpage']['buttonText'].'</strong><span class="buttonBg dynamicBg"></span></a>';
			// 					}
							
		?>
		
		
	<!-- end center-->
	<div>

<!--end wrapper-->
</div>


		


<?php

$row = 1;
if (($handle = fopen("users-final.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
        for ($c=0; $c < $num; $c++) {
            echo $data[$c] . "<br />\n";
        }
    }
    fclose($handle);
}

?>


<div class="wrapper fullwidth" id='wrapper_main'>

	<div class="center">		
		
		<div id="main">
		
			<div class="frontpagetabs">
			
			<div class='entry'>
			<?php 
			
			#query the pags do display on the starting page
			if($k_option['mainpage']['mainpage_content_final'] != "")
			{
				$id_order = explode(',', $k_option['mainpage']['mainpage_content_final']);
				$args = array(
				  'post_type' => 'page',
				  'post__in' => $id_order
				  );

			
				$additional_loop = new WP_Query($args);
				
				#sorts the array so it reflects the order selceted in the backend
				foreach($additional_loop->posts as $the_post)
				{
					foreach($id_order as $key => $value)
					{
						if($value == $the_post->ID)
						{
							$tempArray[$key] = $the_post;
						}
					}
				}
				$additional_loop->posts = $tempArray;

				
				#output loop
				$counter = 1;
				$firstContainer = 'fpactive_tab_content';
				$firstTab = 'fpactive_tab';
				while ($additional_loop->have_posts()) : $additional_loop->the_post(); 
				?>
								
				<h1 class='fptab <?php echo $firstTab; ?>'><!--<a href="<?php the_permalink(); ?>"> --><!-- <?php the_title(); ?> <ideahack> --><!--</a>--></h1>
								
				<div class='fptab_content tab<?php echo $counter. " ".$firstContainer; ?>'>
				<?php the_content('Read more'); edit_post_link('Edit', '', '');?>
				</div>
				
				<?php  
				$firstContainer = $firstTab = "";
				$counter ++;
				endwhile; 
			}
			else
			{
				echo "<h1>Welcome and Thanks for installing Avisio!</h1>";
				echo "It seems you didnt set up your frontpage by now. You can do that in your wordpress backend at Avisio Options &raquo; <a href='".get_option('siteurl')."/wp-admin/options.php?page=mainpage.php' title=''>Mainpage Options</a>";
			}
			
			?>
			<!--end enty -->
			</div>
			<!-- <span class="hr"></span>			 -->
			
			</div>

		<!--end main-->
		</div>

	
<?php get_footer(); ?>