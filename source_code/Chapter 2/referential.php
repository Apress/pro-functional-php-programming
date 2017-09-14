<?php

# This function is Referentially Transparent. It has no
# side effects, and its output is fully determined
# by its parameters.

function is_RT($arg1, $arg2) {

	return $arg1 * $arg2;

}

# This function is not RT, it uses the rand() function
# which introduces a value (a side effect) that
# isn't passed in through the parameters

function is_not_RT($arg1, $arg2) {

	return $arg1 * $arg2 * rand(1,1000);

}

# So let's call our RT function with the values 3 and 6
$val = is_RT(3,6);

# if it really is RT, then in an expression like the
# following, we can replace the function call...
$a = is_RT(3,6) + 10; # with itself
$b = $val + 10; # with the value it returned earlier
$c = 18 + 10; # with the hard coded value

# and all output should be the same
var_dump( $a == $b ); # true
var_dump( $a == $c ); # true

# The following demonstrates that this is not the case
# for non-RT functions
$val = is_not_RT(3,6);

$a = is_not_RT(3,6) + 10;
$b = $val + 10;
$c = 2372 + 10;
#(2372 was the value from my first run of this script)

var_dump( $a == $b ); # false
var_dump( $a == $c ); # false
