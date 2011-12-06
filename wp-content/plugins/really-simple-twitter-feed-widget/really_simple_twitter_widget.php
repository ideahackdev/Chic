<?php
/*
Plugin Name: Really Simple Twitter Feed Widget
Plugin URI: http://www.whiletrue.it/
Description: Displays your public Twitter messages in the sidbar of your blog. Simply add your username and all your visitors can see your tweets!
Author: WhileTrue
Version: 1.2.3
Author URI: http://www.whiletrue.it/
*/

/*
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2, 
    as published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/


// Display Twitter messages
function really_simple_twitter_messages($options) {
	include_once(ABSPATH . WPINC . '/rss.php');
	
	// CHECK OPTIONS
	
	if ($options['username'] == '') {
		return __('RSS not configured','rstw');
	} 
	
	if (!is_numeric($options['num']) or $options['num']<=0) {
		return __('Number of tweets not valid','rstw');
	}

	// SET THE NUMBER OF ITEMS TO RETRIEVE - IF "SKIP TEXT" IS ACTIVE, GET MORE ITEMS
	$max_items_to_retrieve = $options['num'];
	if ($options['skip_text']!='') {
		$max_items_to_retrieve *= 3;
	}
	
	// MODIFY FEED CACHE LIFETIME ONLY FOR THIS FEED (30 minutes)
	add_filter( 'wp_feed_cache_transient_lifetime', create_function( '$a', 'return 1800;' ) );

	//$rss = fetch_feed('http://twitter.com/statuses/user_timeline/'.$options['username'].'.rss');
	// USE THE NEW TWITTER REST API
	$rss = fetch_feed('http://api.twitter.com/1/statuses/user_timeline.rss?screen_name='.$options['username'].'&count='.$max_items_to_retrieve);


	// RESET STANDARD FEED CACHE LIFETIME (12 hours)
	remove_filter( 'wp_feed_cache_transient_lifetime', create_function( '$a', 'return 1800;' ) );

	if (is_wp_error($rss)) {
		return __('WP Error: Feed not created correctly','rstw');
	}

	$max_items_retrieved = $rss->get_item_quantity(); 

	if ($max_items_retrieved==0) {
		return __('No public Twitter messages','rstw');
	}
	
	// SET THE MAX NUMBER OF ITEMS  
	$num_items_shown = $options['num'];
	if ($max_items_retrieved<$options['num']) {
		$num_items_shown = $max_items_retrieved;
	}
		
	$out = '<ul class="really_simple_twitter_widget">';

	// BUILD AN ARRAY OF ALL THE ITEMS, STARTING WITH ELEMENT 0 (FIRST ELEMENT).
	$rss_items = $rss->get_items(0, $max_items_retrieved); 

	$i = 0;
	foreach ($rss_items as $message) {
		if ($i>=$num_items_shown) {
			break;
		}
		$msg = " ".substr(strstr($message->get_description(),': '), 2, strlen($message->get_description()))." ";
		
		if ($options['skip_text']!='' and strpos($msg, $options['skip_text'])!==false) {
			continue;
		}
		if($options['encode_utf8']) $msg = utf8_encode($msg);
				
		$out .= '<li>';

		if ($options['hyperlinks']) { 
			// match protocol://address/path/file.extension?some=variable&another=asf%
			$msg = preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"$1\" class=\"twitter-link\">$1</a>", $msg);
			// match www.something.domain/path/file.extension?some=variable&another=asf%
			$msg = preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"http://$1\" class=\"twitter-link\">$1</a>", $msg);    
			// match name@address
			$msg = preg_replace('/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i',"<a href=\"mailto://$1\" class=\"twitter-link\">$1</a>", $msg);
			//NEW mach #trendingtopics
			$msg = preg_replace('/#([\w\pL-.,:>]+)/iu', '<a href="http://twitter.com/#!/search/\1" class="twitter-link">#\1</a>', $msg);

			//OLD mach #trendingtopics
			//$msg = preg_replace('/([\.|\,|\:|\¡|\¿|\>|\{|\(]?)#{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/#!/search/$2\" class=\"twitter-link\">#$2</a>$3 ", $msg);
			//$msg = preg_replace('/([\.|\,|\:|\¡|\¿|\>|\{|\(]?)#{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/#search?q=$2\" class=\"twitter-link\">#$2</a>$3 ", $msg);
		}
		if ($options['twitter_users'])  { 
			$msg = preg_replace('/([\.|\,|\:|\¡|\¿|\>|\{|\(]?)@{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/$2\" class=\"twitter-user\">@$2</a>$3 ", $msg);
		}
          					
		$link = $message->get_permalink();
		if($options['linked'] == 'all')  { 
			$msg = '<a href="'.$link.'" class="twitter-link">'.$msg.'</a>';  // Puts a link to the status of each tweet 
		} else if ($options['linked'] != '') {
			$msg = $msg . '<a href="'.$link.'" class="twitter-link">'.$options['linked'].'</a>'; // Puts a link to the status of each tweet
		} 
		$out .= $msg;
		
		if($options['update']) {				
			$time = strtotime($message->get_date());
			$h_time = ( ( abs( time() - $time) ) < 86400 ) ? sprintf( __('%s ago', 'rstw'), human_time_diff( $time )) : date(__('Y/m/d'), $time);
			$out .= ', '.sprintf( __('%s', 'rstw'),' <span class="twitter-timestamp"><abbr title="' . date(__('Y/m/d H:i:s', 'rstw'), $time) . '">' . $h_time . '</abbr></span>' );
		}          
                  
		$out .= '</li>';
		$i++;
	}
	$out .= '</ul>';
	return $out;
}



/**
 * ReallySimpleTwitterWidget Class
 */
class ReallySimpleTwitterWidget extends WP_Widget {
	private /** @type {string} */ $languagePath;

    /** constructor */
    function ReallySimpleTwitterWidget() {
		$this->languagePath = basename(dirname(__FILE__)).'/languages';
        load_plugin_textdomain('rstw', 'false', $this->languagePath);

		$this->options = array(
			array(
				'name'	=> 'title',
				'label'	=> __( 'Title', 'rstw' ),
				'type'	=> 'text'
			),
			array(
				'name'	=> 'username',
				'label'	=> __( 'Twitter Username', 'rstw' ),
				'type'	=> 'text'
			),
			array(
				'name'	=> 'num',
				'label'	=> __( 'Show # of Tweets', 'rstw' ),
				'type'	=> 'text'
			),
			array(
				'name'	=> 'linked',
				'label'	=> __( 'Show this linked text for each Tweet', 'rstw' ),
				'type'	=> 'text'
			),
			array(
				'name'	=> 'skip_text',
				'label'	=> __( 'Skip tweets containing this text', 'rstw' ),
				'type'	=> 'text'
			),
			array(
				'name'	=> 'link_title',
				'label'	=> __( 'Link above Title with Twitter user', 'rstw' ),
				'type'	=> 'checkbox'
			),
			array(
				'name'	=> 'update',
				'label'	=> __( 'Show timestamps', 'rstw' ),
				'type'	=> 'checkbox'
			),
			array(
				'name'	=> 'hyperlinks',
				'label'	=> __( 'Find and show hyperlinks', 'rstw' ),
				'type'	=> 'checkbox'
			),
			array(
				'name'	=> 'twitter_users',
				'label'	=> __( 'Find Replies in Tweets', 'rstw' ),
				'type'	=> 'checkbox'
			),
			array(
				'name'	=> 'encode_utf8',
				'label'	=> __( 'UTF8 Encode', 'rstw' ),
				'type'	=> 'checkbox'
			),
		);

        parent::WP_Widget(false, $name = 'ReallySimpleTwitterWidget');	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {		
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		echo $before_widget;  
		if ( $title ) {
			if ( $instance['link_title'] === true )
				echo $before_title . '<a href="http://twitter.com/' . $instance['username'] . '" class="twitter_title_link">'. $instance['title'] . '</a>' . $after_title;
			else
				echo $before_title . $instance['title'] . $after_title;
		}
		echo really_simple_twitter_messages($instance);
		echo $after_widget;
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
		$instance = $old_instance;
		
		foreach ($this->options as $val) {
			if ($val['type']=='text') {
				$instance[$val['name']] = strip_tags($new_instance[$val['name']]);
			} else if ($val['type']=='checkbox') {
				$instance[$val['name']] = ($new_instance[$val['name']]=='on') ? true : false;
			}
		}
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
		if (empty($instance)) {
			$instance['title']			= __( 'Last Tweets', 'rstw' );
			$instance['username']		= '';
			$instance['num']			= '5';
			$instance['update']			= true;
			$instance['linked']			= '#';
			$instance['hyperlinks'] 	= true;
			$instance['twitter_users']	= true;
			$instance['skip_text']		= '';
			$instance['encode_utf8']	= false;
		}					
	
		foreach ($this->options as $val) {
			$label = '<label for="'.$this->get_field_id($val['name']).'">'.$val['label'].'</label>';
			if ($val['type']=='text') {
				echo '<p>'.$label.'<br />';
				echo '<input class="widefat" id="'.$this->get_field_id($val['name']).'" name="'.$this->get_field_name($val['name']).'" type="text" value="'.esc_attr($instance[$val['name']]).'" /></p>';
			} else if ($val['type']=='checkbox') {
				$checked = ($instance[$val['name']]) ? 'checked="checked"' : '';
				echo '<input id="'.$this->get_field_id($val['name']).'" name="'.$this->get_field_name($val['name']).'" type="checkbox" '.$checked.' /> '.$label.'<br />';
			}
		}
	}

} // class ReallySimpleTwitterWidget

// register ReallySimpleTwitterWidget widget
add_action('widgets_init', create_function('', 'return register_widget("ReallySimpleTwitterWidget");'));
