<?php

# Borrow some functions from Chapter 3,
# and our repeat function

require('../Chapter 3/compose.php');
require('../Chapter 3/partial_generator.php');
require('repeat.php');

# A helper function to fix parameters from the right,
# as we'll otherwise call partial(reverse()) a lot below.

$partial_right = function ($func, ...$params) {

	return partial(reverse($func), ...$params);

};

# Get the start time, to see how long the script takes

$start_time = microtime(true);

# A function to return true if $word is in $str
# (not comprehensive, but matches a word bounded
# by non-A-Z chars, so matches "hero" but not "heroes")

$match_word = function($word, $str) {

	return preg_match("/[^a-z]${word}[^a-z]/i", $str);

};

# A function to return true if $str is longer than $len chars

$longer_than = function($len, $str) {

	return strlen($str) > $len;

};

# A partial function, fixing hero as the word to search for

$match_hero = partial($match_word, 'hero');

# Another partial function, picking out strings longer than 60 chars

$over_sixty = partial($longer_than, 60);

# A partial function which uses array_filter to apply $match_hero
# to all elements of an array and return only those with 'hero' in

$filter_hero = $partial_right('array_filter', $match_hero );

# Similarly, we'll filter an array with the $over_sixty function

$filter_sixty = $partial_right('array_filter', $over_sixty );

# A function to grab the first 3 elements from an array

$first_three = $partial_right('array_slice', 3, 0);

# Let's now compose the function above to create a
# function which grabs the first three long
# sentences mentioning hero.

$three_long_heros = compose(
															$filter_hero,
															$filter_sixty,
															$first_three
											     );

# Finally, let's actually call our composed function 100 times
# on the contents of all_shakespeare.txt
# Note that calling file() as a parameter means that it is
# only evaluated once (and not 100 times), so the time for disk
# IO won't be a major element of our timings

$result = $repeat(
								   $three_long_heros,
									 file('all_shakespeare.txt'),
									 100
								 );

# Print out the result of the last call (which should be the
# same as all of the rest, as all of our composed functions are
# pure and are called on exactly the same input parameter)

print_r($result);

# and the time taken

echo 'Time taken : '.(microtime(true) - $start_time);
