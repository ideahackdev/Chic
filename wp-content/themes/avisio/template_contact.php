<?php
/*
Template Name: Contact Form
*/

global $k_option;
$name_of_your_site = get_option('blogname');
$email_adress_reciever = $k_option['contact']['email'];

$errorC = true;
if(isset($_POST['Send']))
{
	include('send.php');	
}


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
			<form action="" method="post" class="ajax_form">
						<fieldset><?php if (!isset($errorC) || $errorC == true){ ?><h3><span><?php _e('Send us mail','avisio'); ?></span></h3>
						
						<p class="<?php if (isset($the_nameclass)) echo $the_nameclass; ?>" ><input name="yourname" class="text_input is_empty" type="text" id="name" size="20" value='<?php if (isset($the_name)) echo $the_name?>'/><label for="name"><?php _e('Your Name','avisio'); ?>*</label>
						</p>
						<p class="<?php if (isset($the_emailclass)) echo $the_emailclass; ?>" ><input name="email" class="text_input is_email" type="text" id="email" size="20" value='<?php if (isset($the_email)) echo $the_email ?>' /><label for="email"><?php _e('E-Mail','avisio'); ?>*</label></p>
						<p><input name="website" class="text_input" type="text" id="website" size="20" value="<?php if (isset($the_website))  echo $the_website?>"/><label for="website"><?php _e('Website','avisio'); ?></label></p>
						<label for="message" class="blocklabel"><?php _e('Your Message','avisio'); ?>*</label>
						<p class="<?php if (isset($the_messageclass)) echo $the_messageclass; ?>"><textarea name="message" class="text_area is_empty" cols="40" rows="7" id="message" ><?php  if (isset($the_message)) echo $the_message ?></textarea>
						<input name="username" value="" id="username" class="username"/>
						</p>
						
						
						<p>
						
						<input type="hidden" id="myemail" name="myemail" value="<?php echo $email_adress_reciever; ?>" />
						<input type="hidden" id="myblogname" name="myblogname" value='<?php echo $name_of_your_site; ?>' />
						
						<input name="Send" type="submit" value="<?php _e('Send','avisio'); ?>" class="button" id="send" size="16"/></p>
						<?php } else { ?> 
						<p><h3><?php _e('Your message has been sent!','avisio'); ?> </h3> <?php _e('Thank you!','avisio'); ?> </p>
						
						<?php } ?>
						</fieldset>
					</form>
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
			
		
		<?php 
		// $k_option['showSidebar'] = 'page';
		// 	get_sidebar(); ?>
		
		<!--end main-->
		</div>
		
		
<?php get_footer(); ?>