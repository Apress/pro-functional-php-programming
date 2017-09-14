<?php

# Define some data. I should stop writing code
# when I'm hungry...

$fruits = ['apple', 'banana', 'blueberry', 'cherry'];
$meats = ['antelope','bacon','beef','chicken'];
$cheeses = ['ambert','brie','cheddar','daralagjazsky'];


# Create a function that filters an array and picks out the
# elements beginning with a specified letter

$letter_filter = function($list, $letter) {

  # Rather than a foreach loop or similar, we'll use PHP's
	# higher-order array_filter function. Note it takes two
	# paramters, an array ($list in our case) and a
	# function (which we've defined inline)

	return array_filter($list, function($item) use ($letter)  {

		return $item[0] == $letter;

	});

};

# We can call the function on our data as normal.

print_r( $letter_filter($fruits,'a') );
print_r( $letter_filter($meats,'b') );
print_r( $letter_filter($cheeses,'c') );


# But let's use a single call to the higher-level array_map function
# to demonstrate a simple "loop" over three arrays & parameters.
# It should give the same output as the three functions above,
# wrapped up into a single array.

print_r(
	array_map( $letter_filter, [$fruits, $meats, $cheeses], ['a', 'b', 'c'])
);
