<?php

$oranges = 3;

function count_fruit($apples, $bananas) {

	global $oranges;

	$num_fruit = $apples + $bananas + $oranges;

	return $num_fruit;

}

function get_date() {

	return trim ( shell_exec('date') );

}

var_dump( count_fruit(6,7) );

var_dump( get_date() );
