<?php


function prepare_text($text) {

	return make_headline($text);

}

function make_headline($text) {

	return add_h_tags( upper_case($text) );

}

function upper_case($text) {

	return strtoupper($text);
	
}

function add_h_tags($text) {

	debug_print_backtrace();

	return '<h1>'.$text.'</h1>';

}

$title = prepare_text('testing');

echo $title;
