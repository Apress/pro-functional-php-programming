<?php

$double = function ($input) {
	return $input * 2;
};


define('DOUBLE',$double);

echo "Double 2 is " . $double(2) . "\n";

echo "Double 2 is " . DOUBLE(2) . "\n";
