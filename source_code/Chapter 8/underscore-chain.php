<?php

# Autoload the library

require __DIR__ . '/vendor/autoload.php';

use Underscore\Underscore;

# Run a set of chained functions. Note that we're *not* composing
# a function to be run later, but executing the series of functions
# right here.

# Some data to work with

$foods = [ 'Cheese' => 'Cheddar',
					 'Milk' => 'Whole',
					 'Apples' => 'Red',
					 'Grapes' => 'White'
				 ];

# The ::from function "loads" an array of data into the chain

$result = Underscore::from($foods)

						# Let's map a function to uppercase each value and prepend the
						# array key to it.

						->map(function($item,$key) {

																				return strtoupper($key.' - '.$item);

																				})

						# Invoke invokes a function over each element like map

						->invoke(function($item) { var_dump($item);})

						# Shuffle the order of the array

						->shuffle()

						# Finally generate the return value for the function chain which
						# is the array returned by shuffle()

						->value();

# Output the final array

var_dump($result);
