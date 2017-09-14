<?php

require_once('recipe_functions.php');

$ingredients = [
  "cod", "beef", "kiwi", "egg", "vinegar"
];

$dish_types = [
  "pie", "smoothie", "tart", "ice cream", "crumble"
];

$all_recipes = combine($ingredients, $dish_types);

print_first($all_recipes, 5);
