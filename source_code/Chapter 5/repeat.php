<?php

# For benchmarking results, it's best to repeatedly run the
# function to minimize the effect of any external slowdowns.
# The following function simply calls a function $func $n times
# with arguments $args, and returns the return value of the last
# call.

$repeat = function ($func, $n, ...$args) {

	for ($i=0; $i < $n; $i++) {

		$result = $func(...$args);

	}

	return $result;

};
