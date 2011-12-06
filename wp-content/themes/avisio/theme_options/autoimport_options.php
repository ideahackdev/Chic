<?php

#options to get
$options = array();
$options["page"] = array('Blog','Portfolio','Portfolio 1 Column','Portfolio 2 Columns','Portfolio 3 Columns','Portfolio 4 Columns','Portfolio 4 Columns Sortable','Contact','About the theme','Why Avisio?','Tab Example','Even more Tabs');
$options["category"] = array('infos');
$options["portfolio_entries"] = array('video','css','html','psd','javascript');
$termNames = array('Video','CSS','HTML','PSD','Javascript');

#values to save:

//pages: pagename for database option, id of the field, value to get from results array
$save_options[] = array('pagename'=>'blog'		,'id'=>'blog_page'					, 'value'=>array('page','Blog'));
$save_options[] = array('pagename'=>'mainpage'	,'id'=>'buttonLink'					, 'value'=>array('page','Portfolio'));
$save_options[] = array('pagename'=>'contact'	,'id'=>'contact_page'				, 'value'=>array('page','Contact'));
$save_options[] = array('pagename'=>'mainpage'	,'id'=>'about'						, 'value'=>array('page','About the theme'));

$save_options[] = array('pagename'=>'portfolio'	,'id'=>'matrix_page_slider_port_0'	, 'value'=>array('page','Portfolio'));
$save_options[] = array('pagename'=>'portfolio'	,'id'=>'matrix_page_slider_port_1'	, 'value'=>array('page','Portfolio 1 Column'));
$save_options[] = array('pagename'=>'portfolio'	,'id'=>'matrix_page_slider_port_2'	, 'value'=>array('page','Portfolio 2 Columns'));
$save_options[] = array('pagename'=>'portfolio'	,'id'=>'matrix_page_slider_port_3'	, 'value'=>array('page','Portfolio 3 Columns'));
$save_options[] = array('pagename'=>'portfolio'	,'id'=>'matrix_page_slider_port_4'	, 'value'=>array('page','Portfolio 4 Columns'));
$save_options[] = array('pagename'=>'portfolio'	,'id'=>'matrix_page_slider_port_5'	, 'value'=>array('page','Portfolio 4 Columns Sortable'));


//portfolio Entries
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_0_0', 'value'=>array('portfolio_entries','video'));
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_0_1', 'value'=>array('portfolio_entries','html'));
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_0_2', 'value'=>array('portfolio_entries','css'));
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_0_3', 'value'=>array('portfolio_entries','psd'));
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_0_4', 'value'=>array('portfolio_entries','javascript'));

//portfolio Entries
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_1_0', 'value'=>array('portfolio_entries','video'));
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_1_1', 'value'=>array('portfolio_entries','html'));
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_1_2', 'value'=>array('portfolio_entries','css'));
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_1_3', 'value'=>array('portfolio_entries','psd'));
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_1_4', 'value'=>array('portfolio_entries','javascript'));

//portfolio Entries
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_2_0', 'value'=>array('portfolio_entries','video'));
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_2_1', 'value'=>array('portfolio_entries','html'));
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_2_2', 'value'=>array('portfolio_entries','css'));
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_2_3', 'value'=>array('portfolio_entries','psd'));
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_2_4', 'value'=>array('portfolio_entries','javascript'));

//portfolio Entries
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_3_0', 'value'=>array('portfolio_entries','video'));
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_3_1', 'value'=>array('portfolio_entries','html'));
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_3_2', 'value'=>array('portfolio_entries','css'));
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_3_3', 'value'=>array('portfolio_entries','psd'));
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_3_4', 'value'=>array('portfolio_entries','javascript'));

//portfolio Entries
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_4_0', 'value'=>array('portfolio_entries','video'));
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_4_1', 'value'=>array('portfolio_entries','html'));
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_4_2', 'value'=>array('portfolio_entries','css'));
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_4_3', 'value'=>array('portfolio_entries','psd'));
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_4_4', 'value'=>array('portfolio_entries','javascript'));

//portfolio Entries
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_5_0', 'value'=>array('portfolio_entries','video'));
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_5_1', 'value'=>array('portfolio_entries','html'));
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_5_2', 'value'=>array('portfolio_entries','css'));
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_5_3', 'value'=>array('portfolio_entries','psd'));
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_5_4', 'value'=>array('portfolio_entries','javascript'));


//portfolio entries number
$save_options[] = array('pagename'=>'portfolio','id'=>'super_matrix_count', 'value'=>6);
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_0_hidden', 'value'=>5+1);
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_1_hidden', 'value'=>5+1);
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_2_hidden', 'value'=>5+1);
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_3_hidden', 'value'=>5+1);
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_4_hidden', 'value'=>5+1);
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_5_hidden', 'value'=>5+1);



//portfolio template style
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_column_slider_port_0', 'value'=>'3$one_third$M3$sort');
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_column_slider_port_1', 'value'=>'1$full_size$L$nosort');
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_column_slider_port_2', 'value'=>'2$one_half$M2$nosort');
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_column_slider_port_3', 'value'=>'3$one_third$M3$nosort');
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_column_slider_port_4', 'value'=>'4$one_fourth$M$nosort');
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_column_slider_port_5', 'value'=>'4$one_fourth$M$sort');

//portfolio page count
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_number_slider_port_0', 'value'=>12);
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_number_slider_port_1', 'value'=>6);
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_number_slider_port_2', 'value'=>6);
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_number_slider_port_3', 'value'=>9);
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_number_slider_port_4', 'value'=>12);
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_number_slider_port_5', 'value'=>12);

//matrix save of all portfolio entries
$save_options[] = array('pagename'=>'portfolio','id'=>'matrix_slider_port_final', 'matrixvalue'=>array(
					 'matrix_page_slider_port_0'=>'portfolio_entries',
					 'matrix_page_slider_port_1'=>'portfolio_entries',
					 'matrix_page_slider_port_2'=>'portfolio_entries',
					 'matrix_page_slider_port_3'=>'portfolio_entries',
					 'matrix_page_slider_port_4'=>'portfolio_entries',
					 'matrix_page_slider_port_5'=>'portfolio_entries'

));



//frontpage multidropdown
$save_options[] = array('pagename'=>'mainpage','id'=>'mainpage_content_hidden', 'value'=>4);
$save_options[] = array('pagename'=>'mainpage','id'=>'mainpage_content_0', 'value'=>array('page','Why Avisio?'));
$save_options[] = array('pagename'=>'mainpage','id'=>'mainpage_content_1', 'value'=>array('page','Tab Example'));
$save_options[] = array('pagename'=>'mainpage','id'=>'mainpage_content_2', 'value'=>array('page','Even more Tabs'));
$save_options[] = array('pagename'=>'mainpage','id'=>'mainpage_content_final', 'matrixvalue'=>array(
														 'Why Avisio?'=>'page',
														 'Tab Example'=>'page',
														 'Even more Tabs'=>'page'));



