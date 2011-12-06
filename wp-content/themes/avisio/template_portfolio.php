<?php
/*
Template Name: Portfolio
*/
global $k_option, $more;

//default settings for archive pages
$portfolioInfo = array('4','one_fourth','M','nosort');


//parameters for querying portfolio entries
$more = 0;
$overview_post_id = $post->ID;
$posts_per_page = 9999;
$query_string =  "posts_per_page=".$posts_per_page;
$query_string .= "&post_type=portfolio";
if(isset($useTemplate)) $query_string .= "&portfolio_entries=".$useTemplate;
//$query_string .= "&portfolio_entries=".$k_option['portfolio']['matrix_slider_port_final'][$post->ID]; //doesnt work in wp3.0

// send query
$additional_loop = new WP_Query($query_string); 


//get portfolio categories used on this page
$categories = get_categories('title_li=&orderby=name&hide_empty=0&taxonomy=portfolio_entries&include='.$k_option['portfolio']['matrix_slider_port_final'][$overview_post_id]);

//get portfolio information like column count and sortable
for($i = 0; $i < $k_option['portfolio']['super_matrix_count']; $i ++)
{
	if ($k_option['portfolio']['matrix_page_slider_port_'.$i] == $overview_post_id)
	{
		$portfolioNumber = $i;
	}
}

$portfolioInfoNew =  explode('$',$k_option['portfolio']['matrix_column_slider_port_'.$portfolioNumber]);

if(isset($portfolioInfoNew[1])) $portfolioInfo = $portfolioInfoNew;

//if portfolio is sortable replace heading with sort options
if($portfolioInfo[3] == 'sort')
{
	$output = "<div id='js_sort_items'>";
	
	$hide = "hidden";
	if (isset($categories[1])){ $hide = ""; }
	
	$output .= "<div class='sort_by_cat $hide '>";
	$output .= "<span>".__('Show:','avisio')."</span>";
	$output .= "<a href='#' id='all_sort' class='active_sort'>".__('All','avisio')."</a>";
	
	foreach($categories as $category)
	{
	$output .= "<a href='#' id='".$category->category_nicename."_sort'>".$category->cat_name."</a>";
	}
	
	$output .= "</div>";
	
	
	$output .= "<div class='sort_by_val'>";
	$output .= "<span>".__('Sort by:','avisio')."</span>";
	$output .= "<a href='#' id='date_sort' class='active_sort reversed'>".__('Date','avisio')."</a>";
	$output .= "<a href='#' id='name_sort'>".__('Name','avisio')."</a>";
	$output .= "</div></div>";
	
	
	
	$k_option['custom']['headlineContent'] = $output;
	$paginationNumber = 0;
}



//pagination workaround to solve wordpress 3 incompletness

$real_posts_per_page = $k_option['portfolio']['matrix_number_slider_port_'.$portfolioNumber];
if(!$real_posts_per_page) $real_posts_per_page = get_option('posts_per_page');
$all_posts_count = 0;
$offset = 0;
if(!$paged) $paged = 1;

$catarray = explode(',',$k_option['portfolio']['matrix_slider_port_final'][$overview_post_id]); 


if($additional_loop->have_posts()) : while ($additional_loop->have_posts()) : $additional_loop->the_post(); 

if(!isset($useTemplate))
{
	$item_categories = get_the_terms( $id, 'portfolio_entries' );
	
	$all_posts_count ++;
	
	if(is_object($item_categories) || is_array($item_categories))
	{
		foreach ($item_categories as $cat)
		{
			$class_add[$id] .= $cat->slug.'_sort ';
			if(in_array($cat->term_id, $catarray))
			{
				$displayPost[$id] = true;
			}
		}
	}
}
else
{
	$displayPost[$id] = true;
	$all_posts_count ++;
}

endwhile; endif;
wp_reset_query();


#non sortable items get pagination
if($portfolioInfo[3] != 'sort')
{
	$show_posts_count = count($displayPost);
	$paginationNumber = ceil($show_posts_count/$real_posts_per_page);
	
	$loopCount = 0;
	if(is_array($displayPost))
	{
		foreach ($displayPost as $key=>$value)
		{
			$loopCount++;
			if(($loopCount <= ($paged-1)*$real_posts_per_page) || $loopCount > $paged *$real_posts_per_page)
			{
				unset($displayPost[$key]);
			}
			
		}
	}
}
//end workaround



get_header();

?>

		
<div class="wrapper fullwidth" id='wrapper_main'>

	<div class="center">		
				
		<div id="main" class='portfolio'>
			
			<?php 
			
			if($additional_loop->have_posts()) :
			
			$columns = $portfolioInfo[0]; // how many items beside each other?
			
			$count = 1;
			$last = '';
			
			$openImage = 'lightbox';
			if($k_option['portfolio']['portfolio_click'] == 2) $openImage = 'permalink';
			
			while ($additional_loop->have_posts()) : $additional_loop->the_post(); 


			if($displayPost[$id])
			{
				
				if($count == 1) echo '<div class="entry portfolio_entry entry_'.$portfolioInfo[1].'">';
				if($count == $columns) $last = 'last';
				
				
				
				$prev_image = kriesi_post_thumb($post->ID, array('size'=> array($portfolioInfo[2],'_preview_medium'),
																 'wh' => $k_option['custom']['imgSize'][$portfolioInfo[2]],
																 'display_link' => array($openImage), 
																'linkurl' => array ('XL','_preview_big'),
																'link_attr' => array('class'=>'preloading')
																));
										
			
					echo "<div class='".$portfolioInfo[1]." sortable all_sort ".$class_add[$id]." $last'>";
					
					if($prev_image != "") echo "<span class='framed framed_".$portfolioInfo[1]."'><span>".$prev_image."</span></span>";
					echo "<div class='portfolio_content'>";
					echo "<h3 class='name_sort'><a href='".get_permalink()."' title='".get_the_title()."'>".get_the_title()."</a></h3>";
					echo "<span class='date_sort hidden'>";
					the_time('Y m d H i s');
					
					echo "</span>";
					
					the_excerpt();  
					
					echo "<a href='".get_permalink()."' class='more-link'>".__('Read more','avisio')."</a>";
					echo "</div></div>";
					
				
				
				
				if($count == $columns) 
				{
					$last = '';
					$count = 0;
					echo "</div>";
				}
				$count ++;
			}
			endwhile; 
			
			if($count != 1) echo "</div>";
			
			endif;
			kriesi_pagination($paginationNumber);
			wp_reset_query();
			?>

<!--end main-->
		</div>
				
		

	
<?php get_footer(); ?>
	
		
		
		
		
		
		