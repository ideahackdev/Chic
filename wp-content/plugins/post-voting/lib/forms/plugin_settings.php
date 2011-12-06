<div class="wrap">
	<h2>Post Voting settings</h2>

<?php if (WP_NETWORK_ADMIN) { ?>
	<form action="settings.php" method="post">
<?php } else { ?>
	<form action="options.php" method="post">
<?php } ?>

	<?php settings_fields('wdpv'); ?>
	<?php do_settings_sections('wdpv_options_page'); ?>
	<p class="submit">
		<input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
	</p>
	</form>

<h3>Shortcodes</h3>

<p>Regardless of your <em>Voting box position settings</em>, you can always use the shortcodes to insert
post voting in your content (as long as you have post voting allowed, obviously).</p>

<p>There are several shortcodes that offer a fine-grained control over what is displayed.</p>

<p><em>Tag:</em> <code>[wdpv_vote]</code></p>
<p><em>Attributes:</em> none</p>
<p>This is the main voting shortcode. It will display all parts of voting gadget - "Vote up" link, "Vote down" link and results.</p>
<p>
	<em>Example:</em>
	<code>[wdpv_vote]</code> - will display all parts of voting gadget - "Vote up" link, "Vote down" link and results.
</p>
<p><strong>Note:</strong> if you don't allow voting, only the results will be displayed.</p>

<p>If you wish to customize the gadget appearance, you may want to use one or more of the other shortcodes listed below.</p>

<p><em>Tag:</em> <code>[wdpv_vote_up]</code></p>
<p><em>Attributes:</em> none</p>
<p>This will display just the "Vote up" link.</p>
<p>
	<em>Example:</em>
	<code>[wdpv_vote_up]</code> - will display just the "Vote up" link.
</p>
<p><strong>Note:</strong> if you don't allow voting, nothing will be displayed.</p>

<p><em>Tag:</em> <code>[wdpv_vote_down]</code></p>
<p><em>Attributes:</em> none</p>
<p>This will display just the "Vote down" link.</p>
<p>
	<em>Example:</em>
	<code>[wdpv_vote_down]</code> - will display just the "Vote down" link.
</p>
<p><strong>Note:</strong> if you don't allow voting, nothing will be displayed.</p>

<p><em>Tag:</em> <code>[wdpv_vote_result]</code></p>
<p><em>Attributes:</em> none</p>
<p>This will display just the voting results.</p>
<p>
	<em>Example:</em>
	<code>[wdpv_vote_result]</code> - will display just the voting results.
</p>
<p><strong>Note:</strong> results will be displayed even if you don't allow voting.</p>

<p><em>Tag:</em> <code>[wdpv_popular]</code></p>
<p><em>Attributes:</em>
	<ul>
		<li><code>limit</code> - <em>(optional)</em> Show only this many posts. Defaults to 5</li>
		<li><code>network</code> - <em>(optional)</em> Show posts from entire network. Set to <code>yes</code> if you wish to display posts from entire network.</li>
	</ul>

</p>
<p>This will display the list of posts with highest number of votes.</p>
<p>
	<em>Examples:</em>
	<ul>
		<li><code>[wdpv_popular]</code> - will display 5 highest rated posts on the current blog.</li>
		<li><code>[wdpv_popular limit="3"]</code> - will display 3 highest rated posts on the current blog.</li>
		<li><code>[wdpv_popular network="yes"]</code> - will display 5 highest rated posts on entire network.</li>
		<li><code>[wdpv_popular limit="10" network="yes"]</code> - will display 10 highest rated posts on entire network.</li>
	</ul>
</p>
<p><strong>Note:</strong> popular posts will be displayed even if you don't allow voting.</p>


<h3>Template tags</h3>

<p>Template tags can be used in your themes within The Loop, regardless of your <em>Voting box position settings</em>.</p>

<p><em>Tag:</em> <code>wdpv_vote()</code></p>
<p><em>Attributes:</em> Clear the floats, <code>true</code> or <code>false</code>. Defaults to <code>true</code></p>
<p>This is the main voting template tag. It will display all parts of voting gadget - "Vote up" link, "Vote down" link and results.</p>
<p>
	<em>Examples:</em>
	<ul>
		<li><code>&lt;?php wdpv_vote(); ?&gt;</code> - will display all parts of voting gadget - "Vote up" link, "Vote down" link and results.</li>
		<li><code>&lt;?php wdpv_vote(false); ?&gt;</code> - same as above, without clearing the floats.</li>
	</ul>
</p>
<p><strong>Note:</strong> if you don't allow voting, only the results will be displayed.</p>


<p><em>Tag:</em> <code>wdpv_vote_up()</code></p>
<p><em>Attributes:</em> Clear the floats, <code>true</code> or <code>false</code>. Defaults to <code>true</code></p>
<p>This will display just the "Vote up" link.</p>
<p>
	<em>Examples:</em>
	<ul>
		<li><code>&lt;?php wdpv_vote_up(); ?&gt;</code> - will display just the "Vote up" link.</li>
		<li><code>&lt;?php wdpv_vote_up(false); ?&gt;</code> - same as above, without clearing the floats.</li>
	</ul>
</p>
<p><strong>Note:</strong> if you don't allow voting, nothing will be displayed.</p>


<p><em>Tag:</em> <code>wdpv_vote_down()</code></p>
<p><em>Attributes:</em> Clear the floats, <code>true</code> or <code>false</code>. Defaults to <code>true</code></p>
<p>This will display just the "Vote down" link.</p>
<p>
	<em>Examples:</em>
	<ul>
		<li><code>&lt;?php wdpv_vote_down(); ?&gt;</code> - will display just the "Vote down" link.</li>
		<li><code>&lt;?php wdpv_vote_down(false); ?&gt;</code> - same as above, without clearing the floats.</li>
	</ul>
</p>
<p><strong>Note:</strong> if you don't allow voting, nothing will be displayed.</p>


<p><em>Tag:</em> <code>wdpv_vote_result()</code></p>
<p><em>Attributes:</em> Clear the floats, <code>true</code> or <code>false</code>. Defaults to <code>true</code></p>
<p>This will display just the voting results.</p>
<p>
	<em>Examples:</em>
	<ul>
		<li><code>&lt;?php wdpv_vote_result(); ?&gt;</code> - will display just the voting results.</li>
		<li><code>&lt;?php wdpv_vote_result(false); ?&gt;</code> - same as above, without clearing the floats.</li>
	</ul>
</p>
<p><strong>Note:</strong> results will be displayed even if you don't allow voting.</p>


<p><em>Tag:</em> <code>wdpv_popular()</code></p>
<p><em>Attributes:</em>
	<ul>
		<li>int <code>limit</code> - <em>(optional)</em> Show only this many posts. Defaults to 5</li>
		<li>bool <code>network</code> - <em>(optional)</em> Show posts from entire network. Set to <code>true</code> if you wish to display posts from entire network.</li>
	</ul>

</p>
<p>This will display the list of posts with highest number of votes.</p>
<p>
	<em>Examples:</em>
	<ul>
		<li><code>&lt;?php wdpv_popular(); ?&gt;</code> - will display 5 highest rated posts on the current blog.</li>
		<li><code>&lt;?php wdpv_popular(3); ?&gt;</code> - will display 3 highest rated posts on the current blog.</li>
		<li><code>&lt;?php wdpv_popular(5, true); ?&gt;</code> - will display 5 highest rated posts on entire network.</li>
		<li><code>&lt;?php wdpv_popular(10, true); ?&gt;</code> - will display 10 highest rated posts on entire network.</li>
	</ul>
</p>
<p><strong>Note:</strong> popular posts will be displayed even if you don't allow voting.</p>

</div>