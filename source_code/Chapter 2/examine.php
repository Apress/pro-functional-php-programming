<?php

define('MY_CONSTANT', 'banana');

$my_function = function ($data) {
	return $data;
};

$my_array = [1,2,'apple',MY_CONSTANT,$my_function];

echo "print_r output :\n\n";

print_r($my_array);

echo "\n\n var_dump output :\n\n";

var_dump($my_array);
