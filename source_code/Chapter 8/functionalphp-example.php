<?php

# Autoload the library

require __DIR__ . '/vendor/autoload.php';

# The recommended way to use the library (only in PHP 5.6+) is to
# import the individual functions as function names so that you
# don't need to qualify them in the code

use function Functional\select;
use function Functional\reject;
use function Functional\contains;
use function Functional\map;
use function Functional\pick;
use function Functional\sort;
use function Functional\drop_last;
use function Functional\select_keys;

# Our trusty menu data

$menu = [

	[	'Item' => 'Apple Pie',
 		'Category' => 'Dessert',
		'Price' => 4.99,
		'Ingredients' => ['Apples' => 3, 'Pastry' => 1, 'Magic' => 100]
	],

	[	'Item' => 'Strawberry Ice Cream',
 		'Category' => 'Dessert',
		'Price' => 2.22,
		'Ingredients' => ['Strawberries' => 20, 'Milk' => 10, 'Sugar' => 200]
	],

	[	'Item' => 'Chocolate and Strawberry Cake',
 		'Category' => 'Dessert',
		'Price' => 5.99,
		'Ingredients' => ['Chocolate' => 4, 'Strawberries' => 5, 'Cake' => 4]
	],

	[	'Item' => 'Cheese Toasty',
 		'Category' => 'Main Courses',
		'Price' => 3.45,
		'Ingredients' => ['Cheese' => 5, 'Bread' => 2, 'Butter' => 6]
	]
];

# Define a function to check if a food is a dessert, using the contains
# function. Returns true if it's a dessert

$is_dessert = function ($food) {
	return contains($food, 'Dessert');
};

# Using the function above, we can apply it in two different ways to our menu
# data using the select and reject functions.

$desserts = select($menu, $is_dessert);

$mains = reject($menu, $is_dessert);

# A helper function using map and pick to return an array of just item names

$list_foods = function ($foods) {

	return map($foods, function ($item) {

		 return pick($item, 'Item');

	 });

};

# Output the results of the select and reject statements above, using our
# helper function so we don't dump the whole array contents

echo "Desserts:\n";

print_r ( $list_foods( $desserts ) );

echo "Main Courses:\n";

print_r ( $list_foods( $mains ) );

# Our restaurant is struggling, so we want to dump our cheapest dishes.
# First, we need to use the libraries sort function (with a custom callback
# function) to sort our $menu based on $price.

$sorted = sort($menu, function($item1,$item2) {

	return $item1["Price"] < $item2["Price"];

}, true);

# Now we want to drop any items that cost less than 3. We use the drop_last
# function to drop the last elements of our sorted array that are >=3

$expensive_items = drop_last($sorted, function ($item) {

	return $item["Price"] >= 3;

});

# Let's see what we're left with :s

echo "Expensive Items:\n";

print_r( $list_foods( $expensive_items ) );

# To create our menu, we want to pick out just the Item and Price, so
# we'll map the select_keys function against each element to pick those out.

$new_menu = map($expensive_items, function ($item) {

	 return select_keys($item, ['Item','Price']);

 });

echo "New menu:\n";

print_r($new_menu);
