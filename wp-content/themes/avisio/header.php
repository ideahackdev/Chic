<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php global $k_option, $query_string; $k_option['custom']['real_query'] = $query_string; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">


<!-- basic meta tags -->
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php

   if (function_exists('khelper_follow_nofollow')) khelper_follow_nofollow();
// outputs a rel=follow or nofollow tag to circumvent google duplicate content for archives
// located in framework/helper_functions/lots_of_small_helpers.php

?>



<!-- title -->
<title><?php if (is_home()) { bloginfo('name'); ?><?php } elseif (is_category() || is_page() ||is_single()) { ?> <?php } ?><?php wp_title(''); ?></title>


<!-- feeds and pingback -->
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS2 Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />


<!-- stylesheets -->
<link rel="stylesheet" href="<?php echo bloginfo('template_url'); ?>/js/prettyPhoto/css/prettyPhoto.css" type="text/css" media="screen"/>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />


<?php $skin = $k_option['general']['skin'] != '' ?  $k_option['general']['skin'] : 1; ?>
<link rel="stylesheet" href="<?php echo bloginfo('template_url'); ?>/css/style<?php echo $skin; ?>.css" type="text/css" media="screen"/>

<!-- ideahack stylesheet -->
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/ih.css" type="text/css" media="screen" />

<!-- ########## end css ########## -->	

<!-- scripts -->

<!--[if IE 6]>
<script type='text/javascript' src='<?php echo bloginfo('template_url'); ?>/js/dd_belated_png.js'></script>
<script>DD_belatedPNG.fix('.ie6fix, blockquote');</script>
<style>.box ul li a, li, .hr {zoom:1;}</style>
<![endif]-->
<!--[if lt IE 9]>
<style>.boxed {border:1px solid #fff}</style>
<![endif]-->

<!-- Make Slideshow variables available for Javascript-->
<script type='text/javascript'>
slideShowArray = [];
<?php 
foreach ($k_option['slideshow'] as $key=>$value)
{
	echo "slideShowArray['".$key."'] = '".$value."'; \n";
}
?>
</script>


<?php 
######################################################################
# PHP scripts
######################################################################
// single post comment reply script by wordpress
if ( is_singular() ) wp_enqueue_script( 'comment-reply' );

//wp-head hook, needed for plugins, do not delete
wp_head();

#set the fonts and colors defined at the backend
$applyCustomFontTo = '#top h1, #top  h2, #top h3, #top  h4, #top  h5, #top  h6, #top  legend, .big_button strong, .dynamicFont'; /*ideahack rmvd:  #top .sliderheading, */
$applyBackgroundColorTo = 'body, div .dropcap2, div .dropcap3, div .dynamicBg, body .boxed, div .button, #top div .pagination a:hover';
$applyFontColorTo = 'div a, div a:hover';
$applyBackgroundImage = "body";

$k_option['custom']['styling']->set_cufon_font($applyCustomFontTo, $k_option['general']['font_heading']);
$k_option['custom']['styling']->set_element_background($applyBackgroundColorTo);
$k_option['custom']['styling']->set_element_background_image($applyBackgroundImage);
$k_option['custom']['styling']->set_font_color($applyFontColorTo);
$k_option['custom']['styling']->show();


?>

<!-- ideahack added cufon Optima - write in any replacements here -->
<script type="text/javascript">
	Cufon.replace('#menu-footer li');
	Cufon.replace('#top .nav');
	Cufon.replace('#top .sliderheading');
	Cufon.replace('.siteheading a');
	Cufon.replace('h2');
	Cufon.replace('h3');
	Cufon.replace('.tab');
	
	
	
</script>

<!-- meta tags, needed for javascript -->
<meta name="temp_url" content="<?php echo get_bloginfo('template_url'); ?>" />


</head>

<?php 
######################################################################
# check for custom logo
######################################################################
if (isset($k_option['general']['logo']) && $k_option['general']['logo'] != '')
{
	$logo = '<img class="ie6fix" src="'.$k_option['general']['logo'] .'" alt="'.get_settings('home').'" />';
	$logoclass = 'logoimg';
}
else // default logo
{
	$logo = get_bloginfo('name');
	$logoclass = 'logobg';
}

######################################################################
# check which page and apply classes to body
######################################################################
$k_option['custom']['bodyclass'] = '';

?>

<body id='top' <?php body_class($k_option['custom']['bodyclass']);?> >
<div id='wrap_all' class='<?php echo $k_option['general']['layout_style']; ?>'>
<div class="wrapper" id='wrapper_head'>

	<div class="center">
	
		<div id="head">
		
			<h2 class="logo <?php echo $logoclass; ?>"><a class='ie6fix' href="<?php echo get_settings('home'); ?>/"><?php echo $logo; ?></a></h2>
			
			<!-- Navigation for Pages starts here -->
			<?php 
			wp_nav_menu( array( 'menu' => 'Main', 
								'container' =>false, 
								'menu_class' => 'nav', 
								'echo' => true,
								'fallback_cb' => 'kriesi_fallback_menu', 
								'before' => '', 
								'after' => '', 
								'link_before' => '', 
								'link_after' => '',
								'depth' => 0, 
								'context' => 'frontend',  
								'walker' => new kclass_description_walker())
						);
			?>

		<!--end head-->
		</div>
		
	<!-- end center-->
	</div>
<!--end wrapper-->
</div>

<?php 

#breadcrumb navigation
if(!is_front_page()){

if($k_option['custom']['headlineContent'] == '')
{
	$headline = get_post_meta($post->ID, "_headline", true);
	if($headline != "") $headline = '<h2>'.$headline.'</h2>';
}
else
{
	$headline = $k_option['custom']['headlineContent'];
}
	echo '<div class="wrapper wrapper_heading ie6fix" id="wrapper_featured_area">';
	echo '<div class="overlay_top ie6fix"></div>';
	echo '<div class="overlay_bottom ie6fix">';
	
	echo '</div>';
	
	echo '<div class="center">';
	if($headline != "") echo $headline;
	echo '</div></div>';
	echo '<div class="wrapper" id="wrapper_stripe">';
	if(class_exists('kclass_breadcrumb')){ $bc = new kclass_breadcrumb; }
	echo '</div>';
}
?>
