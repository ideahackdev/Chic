<?php
class WP_Kriesi_Import extends WP_Import
{
	var $preStringOption; 
	var $results;
	var $getOptions;
	var $saveOptions;
	var $termNames;
	
	function saveOptions()
	{	
		#get values from config
		include_once(KFWOPTIONS.'autoimport_options.php');
		$this->getOptions = $options;
		$this->saveOptions = $save_options;
		$this->termNames = $termNames;
		######
		
		$this->preStringOption= 'kriesi_'.THEMENAME."_";
		
		$this->results = $this->getValues();
		$this->saveValues();
		$this->fallbackAddCategories();
	}
	
	
	function getValues()
	{
		
		foreach ($this->getOptions as $key => $option)
		{
			foreach ($option as $name)
			{
				switch($key)
				{
					case 'page': 
						$the_page = get_page_by_title($name);
						$results[$key][$name] = $the_page->ID;
					break;
					
					default:
						$the_category = get_term_by('slug', $name, $key);
						$results[$key][$name] = $the_category->term_id;
					break;
				}
			}
		}

	return $results;
	}
	
	function saveValues()
	{	
		$optionContainer;
		
		foreach ($this->saveOptions as $option)
		{	
			$optionname = $this->preStringOption.$option['pagename'];
			$oldOptions = get_option($optionname);
			$newOptions = array();
			$results = "";
			
			//if value is an array use the results array, else use the direct input that is set in the config file
			if(isset($option['value']) && is_array($option['value']))
			{
				$newOptions[$option['id']] = $this->results[$option['value'][0]][$option['value'][1]];
				$optionContainer[$option['id']] = $this->results[$option['value'][0]][$option['value'][1]];
			}
			else if(isset($option['value'])) 
			{
				$newOptions[$option['id']] = $option['value'];
				$optionContainer[$option['id']] = $option['value'];
			}
			else if(isset($option['matrixvalue']))
			{				
				foreach($option['matrixvalue'] as $id_field => $catarray)
				{	
					if($catarray == 'page')
					{

						$resultArrayMatrix .= $this->results[$catarray][$id_field].", ";
					}
					else
					{
						$results = '';
						foreach($this->getOptions[$catarray] as $cat)
						{
							$the_category = get_term_by('slug', $cat, $catarray);
							$results .= $the_category->term_id.", ";
						}
						$results = substr_replace($results ,"",-2);
						$resultArrayMatrix[$optionContainer[$id_field]] = $results;
					}

				}
				if(is_string($resultArrayMatrix)) $resultArrayMatrix = substr_replace($resultArrayMatrix ,"",-2);
				
				$newOptions[$option['id']] = $resultArrayMatrix;
				$resultArrayMatrix = '';
			}
			
			
			//if value is saved overwrite, else create
			if(is_array($oldOptions))
			{
				$saveOption = array_merge($oldOptions, $newOptions);
			}
			else
			{
				$saveOption = $newOptions;
			}
			
			update_option( $optionname, $saveOption );
			
		}
	}
	
	function fallbackAddCategories()
	{	
		if(is_array($this->termNames))
		{
			$posts_per_page = 9999;
			$query_string =  "posts_per_page=".$posts_per_page;
			$query_string .= "&post_type=portfolio";
			
			$additional_loop = new WP_Query($query_string); 
			$categories = get_categories('title_li=&orderby=name&hide_empty=0&taxonomy=portfolio_entries');
	
			while ($additional_loop->have_posts()) : $additional_loop->the_post();
			
			$rand_keys = array_rand($this->termNames, 3);		
			wp_set_object_terms(get_the_ID(), array($this->termNames[$rand_keys[0]],$this->termNames[$rand_keys[1]],$this->termNames[$rand_keys[2]]), 'portfolio_entries', false );
	
			endwhile;
		}

	}
	
	
}