<?php

function inc($number) {
	$number++;
	return $number;
}

function dec($number) {
	$number--;
	return $number;
}

var_dump( inc(3) );
var_dump( dec(3) );
