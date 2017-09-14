<?php

# Examples of non-strict typing

# Our function accepts two nullable ints, and returns an int

$add = function (int $a = null, int $b = null) : int {

	return $a + $b;

};

var_dump( $add(7, 3) ); #10

var_dump( $add(2.5, 4.9) ); #6, not 7.4

var_dump( $add("5Three", "6Four") ); #11, plus Notices thrown

var_dump( $add(true, false) ); #1 (true == 1, false == 0)

var_dump( $add(null, null) ); # 0 (null is coerced to 0)

var_dump( $add("Three", "Four") ); # Type Error
