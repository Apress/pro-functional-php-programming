<?php

# Turn on strict typing

declare(strict_types=1);

# A function which accepts $a of any type,
# and a nullable int $b, and return a
# value of type int

$divide = function ($a, int $b = null) : int {

	if ( ($a / $b) == intdiv($a, $b) )  {

		return intdiv($a, $b); # returns an integer

	} else {

		return $a / $b; # returns a float (not good!)

	}


};

# As we'll be experiencing a lot of errors, lets create
# a function to catch and deal with the errors so the
# script can complete all of our calls without dying

function run($func, $args) {

	try {

		# run the function and var_dump the return result

		var_dump( call_user_func_array($func, $args) );

	} catch ( Error $e ) {

		# print the error message if one occurs

		echo "Caught : ".$e->getMessage()."\n";

	}

};

run( $divide, [10, 2] ); # int(5)

run( $divide, ["10","2"]); # Type Error, as no type coercion

run( $divide, [10, 2.5] ); # Type Error, as no type coercion

run( $divide, [true, false] ); # Type Error, as no type coercion

run( $divide, [23, null] ); # Division by zero warning & intdiv type error.
# Note that our input parameter is declared an int, and intdiv requires
# an int. But we still get an error, because ints are nullable in
# user function parameters, but not in all PHP function parameters

run( $divide, [10,3]); # Return Type Error (float 3.3333333...)

run( $divide, [6.4444 % 4.333, 9.6666 % 2.0003]); # int(2)
# all that matters is the type of the value of an expression passed
# as a parameter, not the types of the operands of that expression.
