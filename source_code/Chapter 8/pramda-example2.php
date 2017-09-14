<?php

# Get the library

require('pramda/src/pramda.php');

# Define our menu data

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

# Let's get a list of all the distinct ingredients used in the menu

$all_ingredients = P::pipe(

														# get just the ingredient array from each element

														P::pluck('Ingredients'),

														# reduce them into a single array

														P::reduce('P::merge', []), #

														# grab just the keys (the ingredient names)
														# which will be unique due to the merge above

														'array_keys'

													);

var_dump( $all_ingredients($menu) );

# This time we want to count the quantity of fruit used in our menu, if
# we were making one of each dish

$fruit = ['Apples' => true, 'Strawberries' => true, 'Plums' => true];

# A function to get only items who contain fruit

$get_only_fruit = function($item) use ($fruit) {

		# P::prop returns an array element with a particular key, in this
		# case the element holding an array of Ingredients, from which
		# we get the elements which intersect with the keys in $fruit

		return array_intersect_key(P::prop('Ingredients', $item), $fruit);

};



$count_fruit = P::pipe ( # compose a function which...

											  P::map( # ... maps a function onto the input which

															  P::pipe(

																			  $get_only_fruit, # gets the fruits and

																			  'P::sum' # sums the quantities

																		   ) # for each element/item

														   ),

											  'P::sum' # ...and then sums all the quantities

										    );



var_dump( $count_fruit($menu) ); #28 (3 apples, 20 strawberries, 5 strawberries)

# Now let's say we want to get a dessert menu, ordered by price,
# starting with the most expensive to increase our profits

$dessert_menu = P::pipe(

											# First, sort the data by price

											P::sort( P::prop('Price') ),

											# Reverse the results so the most expensive is first

											'P::reverse',

											# Filter the results so that we only have
											# desserts

											P::filter(

												function ($value, $key) {

																			return P::contains('Dessert', $value);

												}

											),

											# P::filter returns a generator, but because we need
											# to iterate over it twice below, we need to convert
											# to an array first

											'P::toArray',

											# Now let's pick out just the information we want to
											# display in our menu

											function ($items) {

														# Get an array of Item names to use as keys,
														# and an array of Prices to use as values,
														# and array_combine them into a single array.
														# Again, P:pluck returns a generator, we want
														# an array.

														return array_combine(

																		 P::toArray( P::pluck('Item',$items) ),

																		 P::toArray( P::pluck('Price',$items) )

																	 );

											}
	);

print_r( $dessert_menu($menu) );
