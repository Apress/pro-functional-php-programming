<?php

# Again we'll borrow some functions from Chapter 3,
# and our repeat function

require('../Chapter 3/compose.php');
require('../Chapter 3/partial_generator.php');
require('repeat.php');

# and start timing

$start_time = microtime(true);

# We'll now define a lazy version of array_filter, using
# a generator (note the yield statement)

$lazy_filter = function ($func, $array) {

# Loop through the array

	foreach ($array as $item) {

		# Call the function on the array item, and
		# if it evaluates to true, return the item

		if ( $func($item) ) { yield $item; }

	};

};

# The following functions are exactly the same as
# in the non-lazy filter.php example

$match_word = function($word, $str) {

	return preg_match("/[^a-z]${word}[^a-z]/i", $str);

};


$longer_than = function($len, $str) {

	return strlen($str) > $len;

};

$match_hero = partial($match_word, 'hero');

$over_sixty = partial($longer_than, 60);

# Our $filter_hero function is almost the same,
# but note that it calls $lazy_filter instead of
# array_filter (and it uses partial() rather than
# $partial_right, as I've implemented $lazy_filter
# with the parameters in the opposite order to
# array_filter.

$filter_hero = partial($lazy_filter, $match_hero );

# Again $filter_sixty uses $lazy_filter rather than array_filter

$filter_sixty = partial($lazy_filter, $over_sixty );

# As the output from filter_sixty will be a generator object
# rather than an array, we can't use array_slice to
# get the first three items (as data doesn't exist in a
# generator until you call for it). Instead, we'll create
# a $gen_slice function which calls the generator $n times
# and returns the $n returned values as an array. We'll take
# advantage of that fact that a generator is an iterable object,
# and so has current() and next() methods to get each value.
# We'll practice our recursion, rather than just using
# a for loop!

$gen_slice = function ($n, $output = [], $generator) use (&$gen_slice) {

	$output[] = $generator->current();

	$generator->next();

	if ($n > 1) {

				$output = $gen_slice(--$n, $output, $generator);

	}

return $output;

};

# $first_three uses $gen_slice rather than array_slice

$first_three = partial($gen_slice, 3, []);

# We'll compose them together, repeatedly call them
# and output the results using exactly the same
# code as in the non-lazy version

$three_long_heros = compose(
															$filter_hero,
															$filter_sixty,
															$first_three
											     );

$result = $repeat( $three_long_heros, file('all_shakespeare.txt'), 100 );

print_r($result);

echo 'Time taken : '.(microtime(true) - $start_time);
