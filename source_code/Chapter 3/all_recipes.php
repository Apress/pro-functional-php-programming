<?php

$ingredients = [
  "cod", "beef", "kiwi", "egg", "vinegar"
];

$dish_types = [
  "pie", "smoothie", "tart", "ice cream", "crumble"
];

$all_recipes = [];

foreach ($ingredients as $ingredient) {

	foreach ($dish_types as $dish) {

		$all_recipes[] = $ingredient.' '.$dish;

	}

}

print_r($all_recipes);
