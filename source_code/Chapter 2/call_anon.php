<?php

# create an anonymous function and assign it to a variable
$double = function ($a) { return $a * 2; };

var_dump( $double );

# call the anonymous function
var_dump( $double(4) );

var_dump( call_user_func($double, 8) );

# Copy it to another variable;

$two_times = $double;

var_dump( $two_times(4) + $double(6) );

# pass it as a parameter to another function

$numbers = [1,2,3,4];

var_dump( array_map( $two_times, $numbers ) );

# redefine it

$double = function ($a) { return $a * 4; };

var_dump( $double(10) );

# but the earlier copy is definitely a copy not a reference

var_dump( $two_times(10) );

# destroy it

unset($double);

var_dump( $double(9) );
