<?php

include('Curry/Placeholder.php');
include('Curry/functions.php');

use Cypress\Curry as C;

# Let's make a function place an order with our chef
# for some delicious curry (the food, not the function)

$make_a_curry = function($meat, $chili, $amount, $extras, $where) {

	return [
					"Meat type"=>$meat,
					"Chili hotness"=>$chili,
				  "Quantity to make"=>$amount,
					"Extras"=>$extras,
				  "Eat in or take out"=>$where
				 ];
};

# We think that everyone will want a mild Rogan Josh, so
# let's curry the function with the first two parameters

$rogan_josh = C\curry($make_a_curry, 'Lamb','mild');

# $rogan_josh is now a closure that will continue to
# curry with the arguments we give it

$dishes = $rogan_josh("2 portions");

# likewise $dishes is now a closure that will continue
# to curry

$meal = $dishes('Naan bread');

# and so on for meal. However, we only have 1 parameter
# which we've not used, $where, and so when we add
# that, rather than returning another closure, $meal
# will execute and return the result of $make_a_curry

$order  = $meal('Eat in');

print_r( $order );

# To show that our original function remains unmutated, when
# we realize that actually people only want 1 portion of curry
# at a time, with popadoms, and they want to eat it at home, we
# can curry it again. This time, the parameters we want to bind
# are at the end, so we use curry_right.

$meal_type = C\curry_right($make_a_curry, 'Take out', 'Poppadoms', '1 portion');

$madrass = $meal_type('hot', 'Chicken');

print_r( $madrass );

# We could curry the function with all of the parameters
# provided, this creates a parameter-less closure but doesn't
# execute it until we explicitly do so.

$korma = C\curry($make_a_curry,
						'Chicken', 'Extra mild', 'Bucket full', 'Diet cola', 'Eat in');

print_r($korma());
