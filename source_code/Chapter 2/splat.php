<?php

function my_func($a, ...$b) {

  var_dump($a);

  var_dump($b);

}

# Call it with 4 arguments, $a will be a string
# and $b will be an array of 3 strings

my_func('apples', 'bacon', 'carrots', 'doughnut');

# Define some colorful arrays

$array1 = ['red', 'yellow', 'pink', 'green'];
$array2 = ['purple', 'orange', 'blue'];

# $a will be an array with 4 elements,
# $b will be an array with 1 element, which itself is an
# array of 3 elements

my_func($array1, $array2);

# We can also use the splat operator in reverse when
# calling an array. In this case, the splat
# unpacks $array2 into 3 separate arguments, so
# $b will be an array with 3 elements.

my_func($array1, ...$array2);
