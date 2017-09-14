<?php

function double($number) { return $number * 2; };

function negate($number) { return -$number; };

function add_two($number) { return $number + 2; };

function mango_temp ($num_mangos) {

		return 	add_two(

							negate (

								double (

									$num_mangos

								)

							)

						);
};

echo mango_temp(6)."°C\n";
