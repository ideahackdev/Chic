=== Really Simple Twitter Feed Widget ===
Contributors: whiletrue
Donate link: http://www.whiletrue.it/
Tags: twitter, twitter sidebar, sidebar, social sidebar, widget, plugin, posts, links, twitter widget, twitter feed, simple twitter
Requires at least: 2.9+
Tested up to: 3.1
Stable tag: 1.2.3

Shows the latest tweets from a Twitter account in a sidebar widget.

== Description ==
This plugin displays the latest posts from a Twitter account in a sidebar widget. 
Easy customization of number of posts shown and replies detection.

For more informations: http://www.whiletrue.it/en/projects/wordpress/25-really-simple-twitter-feed-widget-per-wordpress.html

Do you like this plugin? Give a chance to our other works:

* [Most and Least Read Posts](http://www.whiletrue.it/en/projects/wordpress/29-most-and-least-read-posts-widget-per-wordpress.html "Most and Least Read Posts")
* [Random Tweet Widget](http://www.whiletrue.it/en/projects/wordpress/33-random-tweet-widget-per-wordpress.html "Random Tweet Widget")
* [Reading Time](http://www.whiletrue.it/en/projects/wordpress/17-reading-time-per-wordpress.html "Reading Time")
* [Really Simple Facebook Twitter Share Buttons](http://www.whiletrue.it/en/projects/wordpress/22-really-simple-facebook-twitter-share-buttons-per-wordpress.html "Really Simple Facebook Twitter Share Buttons")
* [Tilted Twitter Cloud Widget](http://www.whiletrue.it/en/projects/wordpress/26-tilted-twitter-cloud-widget-per-wordpress.html "Tilted Twitter Cloud Widget")


== Installation ==
1. Upload the `really-simple-twitter-widget` directory into the `/wp-content/plugins/` directory
2. Activate the plugin through the `Plugins` menu in WordPress
3. Inside the `Themes->Widget` menu, place the Really Simple Twitter Widget inside a sidebar, customize the settings and save
4. Enjoy!

== Frequently Asked Questions == 

= Does the widget show my tweets in real time? =
Yes they're shown in real time, although you have to refresh the page for them to appear.

= How can I modify the styles? =

The plugin follows the standard rules for "ul" and "li" elements in the sidebar. You can set your own style modifying or overriding these rules:
ul.really_simple_twitter_widget { /* your stuff */ }
ul.really_simple_twitter_widget li { /* your stuff */ }

== Credits ==

The initial release of the plugin was based on previous work of Max Steel (Web Design Company, Pro Web Design Studios), which was based on Pownce for Wordpress widget.

The release 1.2.3 is based on the work of Frank Gregor.


== Screenshots ==
1. Sample content, using default options (e.g. no active links)  
2. Options available in the Settings menu 

== Changelog ==

= 1.2.3 =
* Changed: a bit of UI
* Added: switch for setting on/off a link of the title to the twitter user
* Added: German translation

= 1.2.2 =
* Fixed: Broken 1.2.1 regular expression cleaning

= 1.2.1 =
* Fixed: Better hashtag handling

= 1.2.0 =
* Changed: FB Widget API adoption (carries multiple Widgets support)

= 1.1.1 =
* Changed: direct to the twitter.com search link

= 1.1.0 =
* Changed: Use the new Twitter REST API
* Changed: Error handling cleaning

= 1.0.2 =
* Changed: Feed cache lifetime shortening to 30 minutes (default is 12 hours)

= 1.0.1 =
* Changed: Some more code cleaning and security option control

= 1.0.0 =
* Added: Option to skip tweets containing certain text
* Changed: New Wordpress Feed API adoption
* Changed: Code cleaning


== Upgrade Notice ==

= 1.2.2 =
A blocking bug appeared in the 1.2.1 release is fixed

= 1.2.0 =
Due to the FB Widget API adoption, existing widgets need to be recreated

= 1.0.0 =
Initial release


== Upcoming features ==

* Target link choice (same window, new window)
