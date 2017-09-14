<?php

# Load via composer, or require the four files below

require('phamda/src/CoreFunctionsTrait.php');
require('phamda/src/Exception/InvalidFunctionCompositionException.php');
require('phamda/src/Collection/Collection.php');
require('phamda/src/Phamda.php');

use Phamda\Phamda as P;

# Same data as before

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

# A function to mark an item as a "special" if it's price is over 5. The
# Phamda functions we use here are :
# P::ifElse - If the first parameter is true, call the second parameter, else
#   call the third
# P::lt - If the first parameter (5) is less than the second, then return true
#   Note that due to auto currying the $price will be supplied as the second
#   parameter, which is why we use lt rather than gt
# P::concat - add the "Special: " string to the price, (called if P::lt returns
#	  true)
# P::identity - the identity function returns the value passed in, so if P::lt
#   returns false this is called, and the price is returned unchanged.
#
# Note that we add ($price) on the end to execute the function straight away

$specials = function ($price) {

		return P::ifElse(P::lt(5), P::concat('Special: '), P::identity())($price);

};

# A function to format the menu item for our menu

$format_item = P::pipe(
												# Get just the fields that we want for the menu

											  P::pick(['Item','Price']),

												# "Evolve" those fields, by applying callbacks to them.
												# Item is made into uppercase letters, and Price
												# is passed through our $specials function above
												# to add Special: to any item that costs over 5

												P::evolve(['Item'=>'strtoupper', 'Price'=>$specials])

												);

# A function to parse our menu data, filter out non-desserts,
# and format the remaining items

$new_dessert_menu = P::pipe(

											# It would be more robust to use P::contains('Dessert')
											# on the P::prop('Category') lest we introduce
											# entrées at a later date, but for now to demonstrate
											# P::not and the scope of P::contains, we'll do this:

											P::filter( P::not ( P::contains('Main Courses') ) ),

											# Map the $format_item function above onto the remaining
											# (hopefully only Dessert) items

											P::map($format_item)

);

# Finally, create our menu

print_r( $new_dessert_menu( $menu ) );
