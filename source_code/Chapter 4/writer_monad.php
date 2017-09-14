<?php

include('src/Writer.php');
include('monoid.php');

use PhpFp\Writer\Writer;

function double($number) {

	$log = new Monoid(["Doubling $number"]);

	return Writer::tell($log)->map(

			function () use ($number)
			{
					return $number * 2;
			}
	);
};


function negate($number) {

	$log = new Monoid(["Negating $number"]);

	return Writer::tell($log)->map(

			function () use ($number)
			{
					return -$number;
			}
	);
 };

function add_two($number) {

	$log = new Monoid(["Adding 2 to $number"]);

	return Writer::tell($log)->map(

			function () use ($number)
			{
					return $number + 2;
			}
	);

};


list ($mango_temp, $log) = double(6)->chain('negate')->chain('add_two')->run();

echo $mango_temp."°C\nLog :\n";

print_r($log->value);
