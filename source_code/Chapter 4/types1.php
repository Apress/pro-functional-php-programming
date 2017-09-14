<?php

declare(strict_types=1);

function my_function(bool $a) {

var_dump($a);

$a = $a * 22;

var_dump($a);

};

my_function(true);
