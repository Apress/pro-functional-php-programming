<?php

require('MonadPHP/Monad.php');
require('MonadPHP/Maybe.php');

use MonadPHP\Maybe;

# We'll use the shopping list array from the previous chapter.
# It's a nested array, and not all elements have the
# same level of nesting.

$shopping_list = [
	"fruits" => [ "apples" => [ "red" => 3, "green" => 4], "pears" => 4, "bananas" => 6 ],
	"bakery" => [ "bread" => 1, "apple pie" => 2],
	"meat" => [ "sausages" =>
								["pork" => ["chipolata" => 5, "cumberland" => 2], "beef" => 3],
								 "steaks" => 3, "chorizo" => 1 ]
];

# Let's create some functions.

# This function takes a category (e.g. fruits) and returns either
# a) a closure that returns that category from the supplied list
# or
# b) null if the category doesn't exist.

$get_foods = function ($category) {

	return function ($list) use ($category) {

		echo("get_foods return closure called\n");

		return isset($list[$category]) ? $list[$category] : null;

	};

};

# This function does the same, except it returns a closure that returns
# the  foods (e.g. apples, pears...) from the category (fruit), or null


$get_types = function ($food) {

	return function ($category) use ($food) {

		echo("get_types return closure called\n");

		return isset($category[$food]) ? $category[$food] : null;

	};

};

# and lastly another function of the same type to get the types of food
# (e.g. red, green) from the food, or null

$get_count = function ($type) {

	return function ($types) use ($type) {

		echo("get_count return closure called\n");

		return isset($types[$type]) ? $types[$type] : null;

	};

};

# Now let's create a Maybe monad, encapsulating our
# shopping list as its value.

$monad = Maybe::unit($shopping_list);

# We'll repeatedly bind our functions against it as
# we did in the previous example.

var_dump( $monad  ->bind($get_foods('fruits'))
									->bind($get_types('apples'))
									->bind($get_count('red'))
									->extract() # returns 3
				);

# None of our closures test for null parameters, so what
# happens if we try to look for something that doesn't exist?

var_dump( $monad  ->bind($get_foods('fruits'))
									->bind($get_types('apples'))
									->bind($get_count('purple')) # doesn't exist
									->extract() # returns null
				);

var_dump( $monad  ->bind($get_foods('cheeses')) # doesn't exist
									->bind($get_types('cheddar')) # doesn't exist
									->bind($get_count('mature')) # doesn't exist
									->extract() # returns null
				);

var_dump( $monad  ->bind($get_foods('bakery'))
									->bind($get_types('pastries')) # doesn't exist
									->bind($get_count('danish')) # doesn't exist
									->extract() # returns null
				);
