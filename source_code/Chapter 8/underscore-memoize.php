<?php

# Get the library

require('Underscore.php/underscore.php');

# The code below is exactly the same as in Chapter 5, except where noted

$fibonacci =

		function ($n) use (&$fibonacci) {

		usleep(100000);

    return ($n < 2) ? $n : $fibonacci($n - 1) + $fibonacci($n - 2);

	};

# Here we memoize using the underscore memoize function rather than our own

$memo_fibonacci = __::memoize($fibonacci);

$timer = function($func, $params) {

	$start_time = microtime(true);

	$results = call_user_func_array($func, $params);

	$time_taken = round(microtime(true) - $start_time, 2);

	return [ "Param" => implode($params),
					 "Result" => $results,
					 "Time" => $time_taken ];

};

print_r( $timer(  $fibonacci, [6, '*'] ) );

print_r( $timer(  $memo_fibonacci, [6] ) );

print_r( $timer(  $fibonacci, [6, '*'] ) );

print_r( $timer(  $memo_fibonacci, [6] ) );

print_r( $timer(  $memo_fibonacci, [10] ) );

print_r( $timer(  $memo_fibonacci, [11] ) );

print_r( $timer(  $memo_fibonacci, [8] ) );

# We'll add an extra call with parameter 8

print_r( $timer(  $memo_fibonacci, [8] ) );
