<?php
/**
 * Handles data access, checks and sanitization.
 */
class Wdpv_Model {
	var $db;
	var $data;

	function __construct () {
		global $wpdb;
		$this->db = $wpdb;
		$this->data = new Wdpv_Options;
	}
	function Wdpv_Model () { $this->__construct(); }

	/**
	 * Fetches a list of top rated posts from current site.
	 *
	 * @param int Post fetching limit, defaults to 5
	 * @return array A list of posts with post data JOINED in.
	 */
	function get_popular_on_current_site ($limit=5) {
		global $current_blog;
		$site_id = $blog_id = 0;
		if ($current_blog) {
			$site_id = $current_blog->site_id;
			$blog_id = $current_blog->blog_id;
		}
		$limit = (int)$limit;

		return $this->get_popular_on_site($site_id, $blog_id, $limit);
	}

	/**
	 * Fetches a list of post from a specified network/blog.
	 *
	 * @param $site_id int Network ID
	 * @param $blog_id int Blog ID
	 * @param $limit int Post fetching limit, defaults to 5
	 * @return array A list of posts with post data JOINED in.
	 */
	function get_popular_on_site ($site_id, $blog_id, $limit) {
		$site_id = (int)$site_id;
		$blog_id = (int)$blog_id;
		$limit = (int)$limit;
		// Woot, mega complex SQL
		$sql = "SELECT *, SUM(vote) as total FROM " . // SUM(vote) for getting the count - GROUP BY post_id to get to individual posts
			$this->db->base_prefix . "wdpv_post_votes LEFT JOIN " . // Get the post data too - LEFT JOIN what we need
			$this->db->prefix . "posts ON " . $this->db->prefix . "posts.ID=" .	$this->db->base_prefix . "wdpv_post_votes.post_id " .
			"WHERE site_id={$site_id} AND blog_id={$blog_id} " . // Only posts on set site/blog
			"GROUP BY post_id " . // Group by post_id so we get the proper vote sum in `total`
			"ORDER BY total DESC " . // Order them nicely
		"LIMIT {$limit}";
		$result = $this->db->get_results($sql, ARRAY_A);
		return $result;
	}

	/**
	 * Fetches a list of post from the current network.
	 *
	 * This method does NOT!! join post data - it is up to caller to fetch it
	 * using `get_blog_post()`/`get_blog_permalink()` etc.
	 *
	 * @param $limit int Post fetching limit, defaults to 5
	 * @return array A list of posts.
	 */
	function get_popular_on_network ($limit) {
		global $current_blog;
		$site_id = 0;
		if ($current_blog) {
			$site_id = $current_blog->site_id;
		}
		$limit = (int)$limit;
		$sql = "SELECT *, SUM(vote) as total FROM " . // SUM(vote) for getting the count
			$this->db->base_prefix . "wdpv_post_votes " .
			"WHERE site_id={$site_id} AND blog_id<>0 " . // Only posts on multisite sites/blogs
			"GROUP BY post_id, site_id, blog_id " . // Group by post_id so we get the proper vote sum in `total`
			"ORDER BY total DESC " . // Order them nicely
		"LIMIT {$limit}";
		$result = $this->db->get_results($sql, ARRAY_A);
		return $result;
	}

	function get_stats ($post_id, $blog_id, $site_id) {
		$sql_up = "SELECT COUNT(id) FROM " . $this->db->base_prefix . "wdpv_post_votes " .
			"WHERE site_id={$site_id} AND blog_id={$blog_id} AND post_id={$post_id} AND vote>0 ";
		$sql_down = "SELECT COUNT(id) FROM " . $this->db->base_prefix . "wdpv_post_votes " .
			"WHERE site_id={$site_id} AND blog_id={$blog_id} AND post_id={$post_id} AND vote<0 ";
		return array (
			'up' => $this->db->get_var($sql_up),
			'down' => $this->db->get_var($sql_down),
		);
	}

	/**
	 * Gets total sum of votes for a post.
	 *
	 * @param $post_id int Post ID
	 * @param $site_id int Network ID
	 * @param $blog_id int Blog ID
	 * @return int Number of votes.
	 */
	function get_votes_total ($post_id, $site_id=0, $blog_id=0) {
		global $current_blog;
		$post_id = (int)$post_id;
		if (!$post_id) return 0;

		if ((!$site_id || !$blog_id) && $current_blog) { // Requested current blog post
			$site_id = $current_blog->site_id;
			$blog_id = $current_blog->blog_id;
		}

		$sql = "SELECT SUM(vote) FROM " . $this->db->base_prefix . "wdpv_post_votes WHERE post_id={$post_id} AND site_id={$site_id} AND blog_id={$blog_id}";
		return (int)$this->db->get_var($sql);
	}

	/**
	 * Updates the post votes.
	 *
	 * Also dispatches the permission checks
	 *
	 * @param $post_id int Post ID
	 * @param $vote int Vote to be recorded
	 * @return (bool)false on permissions failure, or whatever database answers with.
	 */
	function update_post_votes ($post_id, $vote) {
		global $current_blog;
		$site_id = $blog_id = 0;

		if ($current_blog) {
			$site_id = $current_blog->site_id;
			$blog_id = $current_blog->blog_id;
		}

		$post_id = (int)$post_id;
		$vote = (int)$vote;
		if (!$this->check_voting_permissions($site_id, $blog_id, $post_id)) return false;

		$user_id = $this->get_user_id();
		$user_ip = $this->get_user_ip();

		$sql = "INSERT INTO " . $this->db->base_prefix . "wdpv_post_votes (" .
			"blog_id, site_id, post_id, user_id, user_ip, vote" .
			") VALUES (" .
			"{$blog_id}, {$site_id}, {$post_id}, {$user_id}, {$user_ip}, {$vote}" .
		")";
		$res = $this->db->query($sql);

		if ($res) $this->set_voted_cookie($site_id, $blog_id, $post_id);

		return $res;
	}

	/**
	 * Voting permissions checking method.
	 *
	 * Checks cookie (by calling `check_cookie_permissions()`),
	 * user ID and user IP (if allowed) for the current user.
	 *
	 * @param $site_id int Network ID
	 * @param $blog_id int Blog ID
	 * @param $post_id int Post ID
	 * @return bool true if all is good, false if voting not allowed
	 */
	function check_voting_permissions ($site_id, $blog_id, $post_id) {
		if (!$this->data->get_option('allow_voting')) return false;

		if (!$this->check_cookie_permissions($site_id, $blog_id, $post_id)) return false;

		$user_id = $this->get_user_id();
		if (!$user_id && !$this->data->get_option('allow_visitor_voting')) return false;

		$not_voted = true;
		if ($not_voted && $user_id) {
			$result = $this->db->get_var("SELECT COUNT(*) FROM " . $this->db->base_prefix . "wdpv_post_votes WHERE user_id={$user_id} AND site_id={$site_id} AND blog_id={$blog_id} AND post_id={$post_id}");
			$not_voted = $result ? false : true;
		}

		if (!$this->data->get_option('use_ip_check')) return $not_voted;

		if ($not_voted) { // Either not registered user, or not voted yet. Check IPs
			$user_ip = $this->get_user_ip();
			$result = $this->db->get_var("SELECT COUNT(*) FROM " . $this->db->base_prefix . "wdpv_post_votes WHERE user_ip={$user_ip} AND site_id={$site_id} AND blog_id={$blog_id} AND post_id={$post_id}");
			return $result ? false : true;
		} else return false;
	}

	/**
	 * Checks cookie permissions specifically.
	 *
	 * @param $site_id int Network ID
	 * @param $blog_id int Blog ID
	 * @param $post_id int Post ID
	 * @return bool true if all is good, false if voting not allowed
	 */
	function check_cookie_permissions ($site_id, $blog_id, $post_id) {
		if (!isset($_COOKIE['wdpv_voted'])) return true; // No "voted" cookie, we're done here

		$votes = $this->decrypt_cookie_data_array($_COOKIE['wdpv_voted']);
		$str = $this->create_data_string($site_id, $blog_id, $post_id);

		$voted = @in_array($str, $votes);

		return !$voted;
	}

	/**
	 * Sets voted cookie for current network, blog and post.
	 *
	 * @param $site_id int Network ID
	 * @param $blog_id int Blog ID
	 * @param $post_id int Post ID
	 */
	function set_voted_cookie ($site_id, $blog_id, $post_id) {
		$voted = array();
		if (isset($_COOKIE['wdpv_voted'])) {
			$voted = $this->decrypt_cookie_data_array($_COOKIE['wdpv_voted']);
		}
		$voted[] = $this->create_data_string($site_id, $blog_id, $post_id);

		setcookie("wdpv_voted", $this->encrypt_cookie_data_array($voted), time() + 30*24*3600);//, "/", str_replace('http://', '', get_bloginfo('url')));
	}

	/**
	 * Helper method.
	 * Converts list of arguments into a string.
	 */
	function create_data_string () {
		$args = func_get_args();
		return join('|', $args);
	}

	/**
	 * Helper method.
	 * Encrypts cookie data.
	 */
	function encrypt_cookie_data_array ($arr) {
		return base64_encode(str_rot13(serialize($arr)));
	}

	/**
	 * Helper method.
	 * Decrypts cookie data.
	 */
	function decrypt_cookie_data_array ($str) {
		return unserialize(str_rot13(base64_decode(stripslashes($str))));
	}

	/**
	 * Helper method.
	 * Gets current WP user ID.
	 */
	function get_user_id () {
		$user = wp_get_current_user();
		return (int)$user->ID;
	}

	/**
	 * Helper method.
	 * Returns long representation of current users IP address.
	 */
	function get_user_ip () {
		return $user_ip = (int)sprintf("%u", ip2long($_SERVER['REMOTE_ADDR']));
	}
}