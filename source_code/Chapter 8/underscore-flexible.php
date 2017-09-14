<?php

# Autoload the library

require __DIR__ . '/vendor/autoload.php';

# We're going to use the Arrays type

use Underscore\Types\Arrays;

# Some data

$data = [10, 25, 38, 99];

# A helper function, returns true if $number is Equivalent

$is_even = function ($number) {

	return $number % 2 == 0;

};

# We can call the library functions as static methods

var_dump( Arrays::average($data) ); # 43

# We can chain them together, here we load our data with from(),
# filter out the odd number (25 & 99) with our $is_even function,
# and then sum the remaining even numbers

var_dump ( Arrays::from($data)
															->filter($is_even)
															->sum()
				 ); #10+38 = 48

# We can also instantiate an object to encapsulate our data,
# and call the methods directly on that (which is effectively what the
# static methods do in the background.

$array = new Arrays($data);

var_dump( $array->filter($is_even)->sum() ); #48 again

# The following chain contains a "reverse" function. However no such
# function exists in the library. The library will attempt to use
# native PHP functions for such calls, for arrays it tries to find
# a native function with the same name prefixed by array_, so in
# this case it will use the native array_reverse function.

var_dump( Arrays::from($data)->reverse()->obtain() );
