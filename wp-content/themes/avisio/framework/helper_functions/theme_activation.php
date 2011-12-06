<?php

add_action( 'admin_init','kfw_theme_actiovation');

#code that should be executed on theme activation
function kfw_theme_actiovation()
{
	global $pagenow;
	if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) 
	{
		#set frontpage to display_posts
		update_option('show_on_front', 'posts');
	}
}