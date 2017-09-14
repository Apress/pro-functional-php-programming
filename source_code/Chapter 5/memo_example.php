<?php

# Get our memoize function and helpers

require('memoize.php');

# Define a plain old recursive fibonacci function

$fibonacci =

		function ($n) use (&$fibonacci) {

		usleep(100000); # make this time-expensive!

    return ($n < 2) ? $n : $fibonacci($n - 1) + $fibonacci($n - 2);

	};

# Define the same fibonacci function again in exactly the
# same way (except for the name), but this time wrap the
# function body in a call to $memoize to get a memoized version

$memo_fibonacci = $memoize(

		function ($n) use (&$memo_fibonacci) {

		usleep(100000);

    return ($n < 2) ? $n : $memo_fibonacci($n - 1) + $memo_fibonacci($n - 2);


		}

);

# Let's define a timer function, to time a run of a function,
# and return the parameters, results and timings.

$timer = function($func, $params) {

	$start_time = microtime(true);

	$results = call_user_func_array($func, $params);

	$time_taken = round(microtime(true) - $start_time, 2);

	return [ "Param" => implode($params),
					 "Result" => $results,
					 "Time" => $time_taken ];

};

# And now let's do a set of runs of both our
# ordinary function and it's memoized sister.
# I've added an extra * parameter to the
# non-memoized runs so that you can spot them
# easier in the output (the '*' isn't used
# by the fibonacci functions, it's just passed
# through to the output of the timer function)

print_r( $timer(  $fibonacci, [6, '*'] ) );

print_r( $timer(  $memo_fibonacci, [6] ) );

print_r( $timer(  $fibonacci, [6, '*'] ) );

print_r( $timer(  $memo_fibonacci, [6] ) );

print_r( $timer(  $memo_fibonacci, [10] ) );

print_r( $timer(  $memo_fibonacci, [11] ) );

print_r( $timer(  $memo_fibonacci, [8] ) );
