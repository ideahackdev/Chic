<?php
/**
 * Renders form elements for admin settings pages.
 */
class Wdpv_AdminFormRenderer {
	function _get_option () {
		return WP_NETWORK_ADMIN ? get_site_option('wdpv') : get_option('wdpv');
	}

	function _create_checkbox ($name) {
		$opt = $this->_get_option();
		$value = @$opt[$name];
		return
			"<input type='radio' name='wdpv[{$name}]' id='{$name}-yes' value='1' " . ((int)$value ? 'checked="checked" ' : '') . " /> " .
				"<label for='{$name}-yes'>" . __('Yes', 'wdpv') . "</label>" .
			'&nbsp;' .
			"<input type='radio' name='wdpv[{$name}]' id='{$name}-no' value='0' " . (!(int)$value ? 'checked="checked" ' : '') . " /> " .
				"<label for='{$name}-no'>" . __('No', 'wdpv') . "</label>" .
		"";
	}

	function _create_radiobox ($name, $value) {
		$opt = $this->_get_option();
		$checked = (@$opt[$name] == $value) ? true : false;
		return "<input type='radio' name='wdpv[{$name}]' id='{$name}-{$value}' value='{$value}' " . ($checked ? 'checked="checked" ' : '') . " /> ";
	}

	function create_allow_voting_box () {
		echo $this->_create_checkbox ('allow_voting');
	}
	function create_allow_visitor_voting_box () {
		echo $this->_create_checkbox ('allow_visitor_voting');
	}
	function create_use_ip_check_box () {
		echo $this->_create_checkbox ('use_ip_check');
		_e(
			'<p>By default, visitors are tracked by IP too in order to prevent multiple voting. However, this can be problematic in certain cases (e.g. multiple users behind a single router).</p>' .
			'<p>Set this to "No" if you don\'t want to use this measure.</p>',
			'wdpv'
		);
	}
	function create_show_login_link_box () {
		echo $this->_create_checkbox ('show_login_link');
		_e(
			'<p>By default, if visitor voting is not allowed, voting will not be shown at all.</p>' .
			'<p>Set this to "Yes" if you wish to have the login link instead.</p>',
			'wdpv'
		);
	}
	function create_voting_position_box () {
		$positions = array (
			'top' => __('Before the post', 'wdpv'),
			'bottom' => __('After the post', 'wdpv'),
			'both' => __('Both before and after the post', 'wdpv'),
			'manual' => __('Manually position the box using shortcode or widget', 'wdpv'),
		);
		foreach ($positions as $pos => $label) {
			echo $this->_create_radiobox ('voting_position', $pos);
			echo "<label for='voting_position-{$pos}'>$label</label><br />";
		}
	}
	function create_front_page_voting_box () {
		echo $this->_create_checkbox ('front_page_voting');
		_e(
			'<p>By default, voting will be shown only on singular pages.</p>' .
			'<p>Set this option to "Yes" to add voting to all posts on the front page.</p>',
			'wdpv'
		);
	}
	function create_voting_appearance_box () {
		$skins = array (
			'' => __('Default', 'wdpv'),
			'arrows' => __('Arrows', 'wdpv'),
			'plusminus' => __('Plus/Minus', 'wdpv'),
			'whitearrow' => __('White arrows', 'wdpv'),
			'qa' => __('Q&amp;A arrows', 'wdpv'),
		);
		foreach ($skins as $skin => $label) {
			echo $this->_create_radiobox ('voting_appearance', $skin);
			echo "<label for='voting_appearance-{$skin}'>$label</label><br />";
			$path_fragment = $skin ? "{$skin}/" : '';
			echo '<div class="wdpv_preview">' . __('Preview:', 'wdpv') .
				' <img src="' . WDPV_PLUGIN_URL . '/img/' . $path_fragment . 'up.png" />' .
				' <img src="' . WDPV_PLUGIN_URL . '/img/' . $path_fragment . 'down.png" />' .
			'</div>';
		}
	}
	/*
	function create_disable_buttons_after_box () {
		echo $this->_create_checkbox ('disable_buttons_after');
		_e(
			'<p>Set this to "Yes" to show buttons in disabled state after voting.</p>' .
			'<p>Set this to "No" to completely remove the buttons after voting.</p>',
			'wdpv'
		);
	}
	*/
}