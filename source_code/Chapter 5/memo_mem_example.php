<?php

# Exactly the same as memo_exampe.php, but
# including our memory based memoization function

require('memoize-mem.php');

$fibonacci =

		function ($n) use (&$fibonacci) {

		usleep(100000); # make this time-expensive!

    return ($n < 2) ? $n : $fibonacci($n - 1) + $fibonacci($n - 2);

	};


$memo_fibonacci = $memoize(

		function ($n) use (&$memo_fibonacci) {

		usleep(100000);

    return ($n < 2) ? $n : $memo_fibonacci($n - 1) + $memo_fibonacci($n - 2);


		}

);


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
