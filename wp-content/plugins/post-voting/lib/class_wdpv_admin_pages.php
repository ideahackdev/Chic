<?php
/**
 * Handles all Admin access functionality.
 */
class Wdpv_AdminPages {
	var $model;
	var $data;

	function __construct () {
		$this->model = new Wdpv_Model;
		$this->data = new Wdpv_Options;
	}
	function Wdpv_AdminPages () { $this->__construct(); }

	/**
	 * Main entry point.
	 *
	 * @static
	 */
	function serve () {
		$me = new Wdpv_AdminPages;
		$me->add_hooks();
	}

	function create_site_admin_menu_entry () {
		if (@$_POST && isset($_POST['option_page']) && 'wdpv' == @$_POST['option_page']) {
			if (isset($_POST['wdpv'])) {
				$this->data->set_options($_POST['wdpv']);
			}
			$goback = add_query_arg('settings-updated', 'true',  wp_get_referer());
			wp_redirect($goback);
		}
		add_submenu_page('settings.php', 'Post Voting', 'Post Voting', 'manage_network_options', 'wdpv', array($this, 'create_admin_page'));
		add_dashboard_page('Voting Stats', 'Voting Stats', 'manage_network_options', 'wdpv_stats', array($this, 'create_stats_page'));
	}

	function register_settings () {
		$form = new Wdpv_AdminFormRenderer;

		register_setting('wdpv', 'wdpv');
		add_settings_section('wdpv_voting', 'Voting settings', create_function('', ''), 'wdpv_options_page');
		add_settings_field('wdpv_allow_voting', 'Allow post voting', array($form, 'create_allow_voting_box'), 'wdpv_options_page', 'wdpv_voting');
		add_settings_field('wdpv_allow_visitor_voting', 'Allow voting for unregistered users', array($form, 'create_allow_visitor_voting_box'), 'wdpv_options_page', 'wdpv_voting');
		add_settings_field('wdpv_use_ip_check_link', 'Use IP check', array($form, 'create_use_ip_check_box'), 'wdpv_options_page', 'wdpv_voting');
		add_settings_field('wdpv_show_login_link', 'Show login link for visitors', array($form, 'create_show_login_link_box'), 'wdpv_options_page', 'wdpv_voting');
		add_settings_field('wdpv_voting_position', 'Voting box position', array($form, 'create_voting_position_box'), 'wdpv_options_page', 'wdpv_voting');
		add_settings_field('wdpv_voting_appearance', 'Appearance', array($form, 'create_voting_appearance_box'), 'wdpv_options_page', 'wdpv_voting');
		//add_settings_field('wdpv_disable_buttons_after', 'Disable buttons after voting', array($form, 'create_disable_buttons_after_box'), 'wdpv_options_page', 'wdpv_voting');
		add_settings_field('wdpv_front_page_voting', 'Voting on Front Page', array($form, 'create_front_page_voting_box'), 'wdpv_options_page', 'wdpv_voting');
	}

	function create_blog_admin_menu_entry () {
		add_options_page('Post Voting', 'Post Voting', 'manage_options', 'wdpv', array($this, 'create_admin_page'));
		add_dashboard_page('Voting Stats', 'Voting Stats', 'manage_options', 'wdpv_stats', array($this, 'create_stats_page'));
	}

	/**
	 * Creates Admin menu page.
	 *
	 * @access private
	 */
	function create_admin_page () {
		include(WDPV_PLUGIN_BASE_DIR . '/lib/forms/plugin_settings.php');
	}

	/**
	 * Creates Admin Stats page.
	 *
	 * @access private
	 */
	function create_stats_page () {
		$limit = 2000;
		$overall = WP_NETWORK_ADMIN ? $this->model->get_popular_on_network($limit) : $this->model->get_popular_on_current_site($limit);
		include(WDPV_PLUGIN_BASE_DIR . '/lib/forms/plugin_stats.php');
	}

	function json_record_vote () {
		$status = false;
		if (isset($_POST['wdpv_vote']) && isset($_POST['post_id'])) {
			$vote = (int)$_POST['wdpv_vote'];
			$post_id = (int)$_POST['post_id'];
			$this->model->update_post_votes($post_id, $vote);
		}
		header('Content-type: application/json');
		echo json_encode(array(
			'status' => (int)$status,
		));
		exit();
	}

	function json_vote_results () {
		$data = false;
		if (isset($_POST['post_id'])) {
			$data = $this->model->get_votes_total((int)$_POST['post_id']);
		}
		header('Content-type: application/json');
		echo json_encode(array(
			'status' => ($data ? 1 : 0),
			'data' => (int)$data,
		));
		exit();
	}

	function add_hooks () {
		// Step0: Register options and menu
		add_action('admin_init', array($this, 'register_settings'));
		if (WP_NETWORK_ADMIN) {
			add_action('network_admin_menu', array($this, 'create_site_admin_menu_entry'));
		} else {
			add_action('admin_menu', array($this, 'create_blog_admin_menu_entry'));
		}

		// Step1: add AJAX hooks
		if ($this->data->get_option('allow_voting')) {
			// Step1a: add AJAX hooks for visitors
			if ($this->data->get_option('allow_visitor_voting')) {
				add_action('wp_ajax_nopriv_wdpv_record_vote', array($this, 'json_record_vote'));
				add_action('wp_ajax_nopriv_wdpv_vote_results', array($this, 'json_vote_results'));
			}
			// Step1b: add AJAX hooks for registered users
			add_action('wp_ajax_wdpv_record_vote', array($this, 'json_record_vote'));
			add_action('wp_ajax_wdpv_vote_results', array($this, 'json_vote_results'));
		}
	}
}