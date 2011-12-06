<?php
add_action('wp_print_scripts', 'Kriesi_nav_admin_includes');

function Kriesi_nav_admin_includes()
{	
	
	if(basename( $_SERVER['PHP_SELF']) == "nav-menus.php" && is_admin())
	{	
		//wp_enqueue_style('kriesi_navCss', KFWINC_URI . 'kriesi_meta_box/kriesi_custom_fields.css');
		wp_enqueue_script('kriesi_navJS', KFWINC_URI . 'nav_menu.js');
	}
}



add_action( 'init', 'register_my_menu' );
function register_my_menu() {
	register_nav_menu( 'theme-menu', __( 'Theme Menu' ) );
}