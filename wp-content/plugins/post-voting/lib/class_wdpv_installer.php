<?php
/**
 * Installs the database, if it's not already present.
 */
class Wdpv_Installer {

	/**
	 * @public
	 * @static
	 */
	function check () {
		$is_installed = get_site_option('wdpv', false);
		$is_installed = $is_installed ? $is_installed : get_option('wdpv', false);
		if (!$is_installed) Wdpv_Installer::install();
	}

	/**
	 * @private
	 * @static
	 */
	function install () {
		$me = new Wdpv_Installer;
		if (!$me->has_database_table()) {
			$me->create_database_table();
		}
		$me->create_default_options();
	}

	/**
	 * @private
	 */
	function has_database_table () {
		global $wpdb;
		$table = $wpdb->base_prefix . 'wdpv_post_votes';
		return ($wpdb->get_var("show tables like '{$table}'") == $table);
	}

	/**
	 * @private
	 */
	function create_database_table () {
		global $wpdb;
		$table = $wpdb->base_prefix . 'wdpv_post_votes';
		$sql = "CREATE TABLE {$table} (
			id INT(10) NOT NULL AUTO_INCREMENT,
			blog_id INT(10) NOT NULL,
			site_id INT(10) NOT NULL,
			post_id INT(10) NOT NULL,
			user_id INT(10) NOT NULL,
			user_ip INT(10) NOT NULL,
			vote INT(1) NOT NULL,
			UNIQUE KEY (id)
		);";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}

	/**
	 * @private
	 */
	function create_default_options () {
		update_site_option('wdpv', array (
			'allow_voting' => 1,
			'allow_visitor_voting' => 1,
			'use_ip_check' => 1,
			'show_login_link' => 0,
			'voting_position' => 'top',
			'front_page_voting' => 1,
			'voting_appearance' => '',
		));
	}
}