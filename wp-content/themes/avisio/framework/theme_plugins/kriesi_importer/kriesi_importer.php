<?php

if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);



// Load Importer API
require_once ABSPATH . 'wp-admin/includes/import.php';
$kfw_importerError = false;

//check if wp_importer, the base importer class is available, otherwise include it
if ( !class_exists( 'WP_Importer' ) ) {
	$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	if ( file_exists( $class_wp_importer ) )
	{
		require_once($class_wp_importer);
	}
	else
	{
		$kfw_importerError = true;
	}
}

//check if the wp import class is available, this class handles the wordpress XML files. If not include it
//make sure to exclude the init function at the end of the file in kriesi_importer
if ( !class_exists( 'WP_Import' ) ) {
	$class_wp_import = KFWPLUGINS . 'kriesi_importer/wordpress_importer.php';
	if ( file_exists( $class_wp_import ) )
	{
		require_once($class_wp_import);
	}
	else
	{
		$kfw_importerError = true;
	}
}

if($kfw_importerError !== false)
{
	echo "The Auto importing script could not be loaded. please use the wordpress importer and import the XML file that is located in your themes folder manually.";
}
else
{
	if ( class_exists( 'WP_Import' )) 
	{
		include_once('wp_kriesi_import_class.php');
	}
	
	
	if(!is_file($values['file']))
	{
		echo "The XML file containing the dummy content is not available or could not be read in <pre>".TEMPLATEPATH."</pre><br/> You might want to try to set the file permission to chmod 777.<br/>If this doesn't work please use the wordpress importer and import the XML file (should be located in your themes folder: dummy.xml) manually <a href='/wp-admin/import.php'>here.</a>";
	}
	else
	{

		$wp_import = new WP_Kriesi_Import();
		$wp_import->fetch_attachments = true;
		$wp_import->import_file($values['file']);
		$wp_import->saveOptions();
	}
}




