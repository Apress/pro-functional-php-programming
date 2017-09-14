<?php

# Create a higher order function to return a
# function to "add" two variables using a user selectable
# method

function add($method) {

	if ($method == 'sum') {

		# our return value is actually an anonymous function

		return function($a, $b) { return $a+$b;};

	} else {

		# this is returning a different function object

		return function($a, $b) { return $a.$b; };

	}

}

# Let's call the function. Note, that as the function
# returns a function, we can simply stick an extra
# set of parentheses on the end with some parameters
# to call that newly returned function.

print_r( add('sum')(2,3) ."\n" );
print_r( add('concatenate')('hello ', 'world!') ."\n" );

# We can also pass the function to returned to other
# higher order functions like array_map

$a = [1, 2, 'cat', 3, 'orange', 5.4];
$b = [6, 3, 'ch', 9.5, 'ish', 6.5];

print_r( array_map(add('sum'), $a, $b) );
print_r( array_map(add('concatenate'), $a, $b) );

# and we can assign the returned function to a
# variable as with any anonymous function

$conc = add('concatenate');

print_r( array_map($conc, $a, $b) );

print_r( $conc("That's all, ", "folks!\n") );
