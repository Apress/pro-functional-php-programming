<?php

# Set up some arrays of data

$ingredients = [
  "cod", "beef", "kiwi", "egg", "vinegar"
];

$dish_types = [
  "pie", "smoothie", "tart", "ice cream", "crumble"
];

$baked = [
  "pie", "tart", "crumble", "cake"
];


# A function which creates a "recipe" by combining
# an ingredient with a type of dish

$make_recipe = function ($ingredient, $dish) {

  return $ingredient.' '.$dish;

};


# A function to check if a recipe involves baked
# goods by seeing if it has any of the words in
# the $baked array in it

$is_baked = function ($recipe) use ($baked) {

	# We need to return a value that evaluates to
	# true or false. We could use a foreach to loop
	# through each $baked item and set a flag to true
	# but instead we'll do it the functional way and
	# filter the $baked array using a function that calls
	# strpos on each element. At the end, if no match is
	# made, array_filter returns an empty array which
	# evaluates to false, otherwise it returns an array of
	# the matches which evaluate to true

  return array_filter($baked,
								function($item) use ($recipe) {

									return strpos($recipe, $item) !== false;

								}

						);


};

# A function which returns the longest of $current_longest or $recipe

$get_longest = function ($current_longest, $recipe) {

  return strlen($recipe) > strlen($current_longest) ?
	 						$recipe : $current_longest;

};

# the PHP function shuffle is not immutable, it changes the array it is
# given. So we create our own function $reshuffle which is immutable.
# Note that shuffle also has a side effect (it uses an external source
# of entropy to randomise the array), and so is not referentially
# transparent. But it will do for now.

$reshuffle = function ($array) { shuffle($array); return $array;};

# Now we actually do some work.

# We'll take a shuffled version of $ingredients and $dish_types (to add
# a little variety) and map the $make_recipe function over them, producing
# a new array $all_recipes with some delicious new dishes

$all_recipes = array_map($make_recipe,
									$reshuffle($ingredients),
									$reshuffle($dish_types)
								);

print_r($all_recipes);

# Everyone knows that only baked foods are nice, so we'll filter
# $all_recipes using the $is_baked function. If $is_baked returns
# false for a recipe, it won't appear in the $baking_recipes output array.

$baking_recipes = array_filter($all_recipes, $is_baked);

print_r($baking_recipes);

# Finally we need to pick our favorite dish, and everyone knows that food
# with the longest name tastes the best. $get_longest compares two strings
# and returns the longest. Array_reduce applies the $get_longest
# function to each element of $baking_recipes in turn, supplying the result
# of the last call to $get_longest and the current array element. After all
# elements have been processed, the result of the last $get_longest call
# must be the longest of all of the elements. It is returned as the output

$best_recipe = array_reduce($baking_recipes, $get_longest, '');

print_r($best_recipe);
