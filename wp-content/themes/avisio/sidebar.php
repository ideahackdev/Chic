<?php 
global $k_option, $custom_widget_area;
if ($k_option['custom']['bodyclass'] == "") // check if its a full width page, if full width dont show the sidebar content
{
			##############################################################################
			# Display the sidebar menu
			##############################################################################

				$default_sidebar = true;
				
				echo "<div class='sidebar'>";
				echo "<span class='sidebar_top'><!-- needed for smooth start of sidebar background--></span>";
				echo "<span class='sidebar_bottom'><!-- needed for smooth end of sidebar background--></span>";
					
					
				//Frontpage sidebars:
				if ($k_option['showSidebar'] == 'frontpage' && dynamic_sidebar('Frontpage Sidebar') ) : $default_sidebar = false; endif;
				
				// general blog sidebars
				if ($k_option['showSidebar'] == 'blog' && dynamic_sidebar('Sidebar Blog') ) : $default_sidebar = false; endif;
								
				// general pages sidebars
				if ($k_option['showSidebar'] == 'page' && dynamic_sidebar('Sidebar Pages') ) : $default_sidebar = false; endif;
				
				
				
				//unique Page sidebars:
				if (function_exists('dynamic_sidebar') && dynamic_sidebar('Page: '.$custom_widget_area) ) : $default_sidebar = false; endif;
				
				//unique Category sidebars
				if (function_exists('dynamic_sidebar') && dynamic_sidebar('Category: '.$custom_widget_area) ) : $default_sidebar = false; endif;
								
				//sidebar area displayed everywhere
				if (function_exists('dynamic_sidebar') && dynamic_sidebar('Displayed Everywhere')) : $default_sidebar = false; endif;
				
				//default dummy sidebar
				if ($default_sidebar && $k_option['includes']['dummy_sidebars'] == 1)
				{
					
					if(is_page()){
					?>
					<div class="box_small box widget community_news"><h3 class="widgettitle">Features we offer</h3>		
						<div class="entry box_entry">
						<p><strong>Absolutley Striking Designs</strong><br/>Lorem ipsum dolor sit amet, usmod tempor incididunt ut labore et dolore magna aliqua.</p>
						</div>
					
						<div class="entry box_entry">
						<p><strong>Multiple color options</strong><br/>Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
						</div>
						
						<div class="entry box_entry">
						<p><strong>Unique Features</strong><br/>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor. Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
						</div>
					
					<!--end box-->
					</div>	
					<?php dummy_widget(1); ?>
					
					
					<?php }else{ ?>
					<?php dummy_widget(1); ?>
					<?php dummy_widget(2); ?>
					<?php dummy_widget(3); ?>

				<?php
					}
				}
				echo "</div>";

}	       	?>	          