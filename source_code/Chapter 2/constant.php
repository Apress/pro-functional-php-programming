<?php

define('MY_CONSTANT', 4);

var_dump(MY_CONSTANT);

$six  = MY_CONSTANT + 2;

var_dump($six);

define('MY_OTHER_CONSTANT', 'orange');

var_dump(MY_OTHER_CONSTANT);

define('ADD_NINE', function ($num) { return $num + 9; });

$eleven = ADD_NINE(2);

var_dump($eleven);
