<?php

include('compose.php');

function double($number) { return $number * 2; };

function negate($number) { return -$number; };

function add_two($number) { return $number + 2; };

$mango_temp = compose(

	'double',
	'negate',
	'add_two'

);

echo $mango_temp(6)."°C\n\n	";

print_r ($mango_temp);
