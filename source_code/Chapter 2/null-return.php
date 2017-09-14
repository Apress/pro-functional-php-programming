<?php

function reverse($string) {

 $string = strrev($string);

}

function capitals($string) {

	if ($string != 'banana') {

		$string  = strtoupper($string);

		return $string;

	}

}

# no return statement
var_dump( reverse('hello') );

# returns a value
var_dump( capitals('peaches') );

# execution flow misses return statement
var_dump( capitals('banana') );
