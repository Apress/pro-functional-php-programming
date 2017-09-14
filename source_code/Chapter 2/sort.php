<?php

function immutable_sort($array) {

	sort($array);

	return $array;

}

$vegetables = ['Carrot', 'Beetroot', 'Asparagus'];

# Sort using our immutable function

$ordered = immutable_sort( $vegetables );

print_r( $ordered );

# Check that $vegetables remains unmutated

print_r( $vegetables );

# Do it the mutable way

sort( $vegetables );

# And see that the original array is mutated

print_r( $vegetables );
