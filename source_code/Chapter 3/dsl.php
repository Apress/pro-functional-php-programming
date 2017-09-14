<?php

require_once('partial_generator.php');

# Define a multiply function

function multiply($a,$b) {	return $a * $b;}

# And then create two ways to count in
# dozens, depending on your industry

$programmers_dozens = partial('multiply', 12);
$bakers_dozens = partial('multiply', 13);

var_dump( $programmers_dozens(2) );
var_dump( $bakers_dozens(2) );
