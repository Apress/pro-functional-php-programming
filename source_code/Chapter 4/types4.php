<?php

# Turn on strict typing

declare(strict_types=1);

# Declare two functions that are EXACTLY
# the same apart from the return type (and name).
# intdiv returns an integer. (int) casting
# ensures that even if we've somehow messed
# up, intdiv returns an int into $a, and
# the return value is forced to int.

$the_func_int = function () : int {

	$a = (int)intdiv(10,2);
	return (int)$a;

};

$the_func_float = function () : float {

	$a = (int)intdiv(10,2);
	return (int)$a;

};

var_dump( $the_func_int() ); # int(5). As expected.
var_dump( $the_func_float() ); # float(5). Errr?!
