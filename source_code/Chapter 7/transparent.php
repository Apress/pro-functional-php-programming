<?php

# Grab our compose function

require('../Chapter 3/compose.php');

# Define some maths functions

$add_two = function ( $a ) {

		return $a + 2;

};

$triple = function ( $a ) {

	return $a * 3;

};


# Now we're going to create a "dirty" function to do some logging.

$log_value = function ( $value ) {

	# Do our impure stuff.

	echo "Impure Logging : $value\n";

	# Oops, we mutated the parameter value...

	$value = $value * 234;

	# ...and returned it even more mutated

	return $value.' is a number';

};

# Now we're going to create a higher-order function which returns a
# wrapped function which executes our impure function but returns
# the original input parameter rather than any output from our impure
# function. Note that we must pass $value to $impure_func by value and
# not by reference (&) to ensure it doesn't mess with it. Also see
# the sections on the mutability of objects if you pass those through,
# as the same concerns will apply here.

$transparent = function ($impure_func) {

	return function ($value) use ($impure_func) {

			$impure_func($value);

			return $value;

	};

};

# Compose the maths functions together, with the $log_value impure function
# made transparent by our wrapper function

$do_sums = compose(
			$add_two,
			$transparent($log_value),
			$triple,
			$transparent($log_value)
	);

# We should get the expected result

var_dump( $do_sums(5) ); # 21
