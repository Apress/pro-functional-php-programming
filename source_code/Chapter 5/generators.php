<?php

# Get our repeat function

require('repeat.php');

# PHP's native function range() takes a
# $start int, $end in and $step value, and
# returns an array of ints from $start to $end
# stepping up by $step each time. We'll create
# a generator version that takes the same
# parameters and does the same task, called gen_range()

function gen_range($start, $end, $step) {

  for ($i = $start; $i <= $end; $i += $step) {

		# yield turns this function into a generator

    yield $i;

  }

};

# We'll create a function to run either range() or
# gen_range() (as specified in $func) with the
# same paramters, and to iterate through the
# returned values until we find a number exactly
# divisible by 123 (which in this case is 369)

$run = function ($func) {

	# Get a range from 1 to ten million in steps of 4,
	# so 1,4,9,13,18,...,9999989,9999993,9999997

  foreach ( $func(1, 10000000, 4) as $n ) {

    if ($n % 123 == 0) {

				# exit the function once we've found one, reporting
				# back the memory in use (as it will be freed once
				# we have returned).

        return memory_get_usage();

    };

  };

};

# A function to get the time/memory use for the runs

$profile = function ($func, ...$args) {

	$start = ["mem" => memory_get_usage(), "time" => microtime(true)];

  $end = ["mem" => $func(...$args),  "time" => microtime(true)];

	return [
           "Memory" => $end["mem"] - $start["mem"],
           "Time" => $end["time"] - $start["time"]
         ];
};

# Finally let's run each of range() and gen_range() 100 times,
# and output the time taken for each and memory used

Echo "*** range() ***\n";

print_r ( $profile($repeat, $run, 100, 'range') );

Echo "*** gen_range() ***\n";

print_r ( $profile($repeat, $run, 100, 'gen_range') );
