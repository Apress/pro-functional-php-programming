<?php

function my_function ( $parameter_1, $parameter_2) {

		$sum =  $parameter_1 + $parameter_2;

		return $sum;

}

$value1 = my_function(10,20);

var_dump( $value1 );

$value2 = my_function(6,9);

var_dump( $value2 );
