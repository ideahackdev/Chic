<?php

function wdpv_vote_up ($standalone=true) {
	if (!class_exists('Wdpv_Codec')) return false;

	$codec = new Wdpv_Codec;
	$standalone = $standalone ? 'yes' : 'no';
	echo $codec->process_vote_up_code(array('standalone'=>$standalone));
}

function wdpv_vote_down ($standalone=true) {
	if (!class_exists('Wdpv_Codec')) return false;

	$codec = new Wdpv_Codec;
	$standalone = $standalone ? 'yes' : 'no';
	echo $codec->process_vote_down_code(array('standalone'=>$standalone));
}

function wdpv_vote_result ($standalone=true) {
	if (!class_exists('Wdpv_Codec')) return false;

	$codec = new Wdpv_Codec;
	$standalone = $standalone ? 'yes' : 'no';
	echo $codec->process_vote_result_code(array('standalone'=>$standalone));
}

function wdpv_vote ($standalone=true) {
	if (!class_exists('Wdpv_Codec')) return false;

	$codec = new Wdpv_Codec;
	$standalone = $standalone ? 'yes' : 'no';
	echo $codec->process_vote_widget_code(array('standalone'=>$standalone));
}

function wdpv_popular ($limit=5, $network=false) {
	if (!class_exists('Wdpv_Codec')) return false;

	$codec = new Wdpv_Codec;
	echo $codec->process_popular_code(array('limit'=>$limit, 'network'=>$network));
}