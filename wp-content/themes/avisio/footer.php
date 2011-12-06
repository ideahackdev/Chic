<?php global $k_option; ?>
		<div class="clearboth"></div>

	<!-- end center-->
	</div>
<!--end wrapper-->
</div>


<div class="wrapper footer ie6fix" id='wrapper_footer_top'>
<div class='overlay_top ie6fix'></div>
	<div class='center' id="footer_inside">
	
	<?php 
			$columns = 1;
			foreach ($k_option['custom']['footer'] as $footer_widget) //iterates 3 times creating 3 footer widget areas
			{	
				$last = ""; 
				if($columns == 4){$last = "last"; }
				
				echo '<div class="footerColumn '.$footer_widget.' '.$last.'">';
				if (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer - '.$footer_widget) ) : 
				
				else : dummy_widget($columns); endif; // dummy widgets defined at the bottom of widgets.php
				
				echo '</div>';
				$columns++;
			} 
			
			?>
		
	<!--end footer_inside-->
	</div>
</div>

<div class="wrapper footer ie6fix" id='wrapper_footer_bottom'>	
	<div id="footer_outside">
		<div id="footernavmenu">

		    <?php wp_nav_menu( array( 'theme_location' => 'menu-2' ) ); ?>

		</div>
		
		<span class="copyright">

			Handcrafted by <a href="http://ideahack.com">Ideahack Creative Inc.</a>
		</span>

		<ul class="social_bookmarks">
				<li class='rss'><a class='ie6fix' href="<?php bloginfo('rss2_url'); ?>">RSS</a></li>
				<?php 
				if($k_option['includes']['acc_fb'] != '') 
				echo "<li class='facebook'><a class='ie6fix' href='http://facebook.com/".$k_option['includes']['acc_fb']."'>Facebook</a></li>";
				
				if($k_option['includes']['acc_tw'] != '') 
				echo "<li class='twitter'><a class='ie6fix' href='http://www.twitter.com/".$k_option['includes']['acc_tw']."'>Twitter</a></li>";
				
				if($k_option['includes']['acc_fl'] != '') 
				echo "<li class='flickr'><a class='ie6fix' href='http://www.flickr.com/people/".$k_option['includes']['acc_fl']."'>flickr</a></li>";
				
				?>
			</ul>
		
		<a href="#top" class='scrollTop'>top</a>
	<!--end footer_outside-->
	</div>
	
	
	
<!--end wrapper -->
</div>
<!--end wrapp_all -->
</div>
<?php wp_footer();
if($k_option['general']['analytics'])
echo $k_option['general']['analytics'];
?>
</body>
</html>