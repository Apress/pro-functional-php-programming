<?php

# Require the library

require('pramda/src/pramda.php');

# Start timing

$start_time = microtime(true);

# The same $match_word function

$match_word = function($word, $str) {

	return preg_match("/[^a-z]${word}[^a-z]/i", $str);

};

# we'll replace str_len with a composition of P::size and str_split.
# it provides no advantage here, other than to demostrate the composition
# of functions (and the fact that there's more than one way to skin a cat).
# Note that Pramda's compose method operates "right to left", i.e. it
# executes functions in the opposite order to the compose function
# we've used up to this point. Also note that we call the composed function
# immediately upon creation on the $str.

$longer_than = function($len, $str) {

	return P::compose(
								 'P::size',
								 'str_split'
								 )($str) > $len;

};

# Create a function to get lines with the word hero in. Pramda doesn't have
# a simple partial function, so instead we curry the function.

$match_hero = P::curry2($match_word)('hero');

# Ditto with a function to get lines with more than 60 chars

$over_sixty = P::curry2($longer_than)(60);

# Pramda's own functions are mostly auto-currying (where it make sense),
# and so we can simply call the P::filter method (similar to array_filter)
# with just a callback, which creates a partial/curried function that
# just needs an array to be called with. We don't need to explicitly
# call a currying function on it.

$filter_hero = P::filter($match_hero);

$filter_sixty = P::filter($over_sixty);

$first_three = P::slice(0,3);

# Now we'll compose these together. Note that we use P::pipe and not P::compose,
# as mentioned above P::compose operates right-to-left, whereas it's easier
# to read left-to-right (or top-to-bottom as we've laid the code out here).
# If you look at the Pramda source code, P::pipe simply reverses the arguments
# and calls P::compose on them!

$three_long_heros = P::pipe(
														'P::file', //lazy file reader
 														$filter_hero,
 														$filter_sixty,
 														$first_three
											     );

# We call the composed function in the normal way

$result = $three_long_heros('../Chapter 5/all_shakespeare.txt');

print_r($result);

echo 'Time taken : '.(microtime(true) - $start_time);
