<?php

require_once('partial_generator.php');

# First define a generic adding function

function add($a,$b) {

	return $a + $b;

}

# Then create our inc and dec as partial functions
# of the add() function.

$inc = partial('add', 1);

$dec = partial('add', -1);

var_dump( $inc(3) );
var_dump( $dec(3) );

# Creating variations is then a simple one-liner

$inc_ten = partial('add', 10);

var_dump( $inc_ten(20) );

# and we still have our add function. We can start
# to build more complex functional expressions

$answer = add( $inc(3), $inc_ten(20) );

var_dump ( $answer );
