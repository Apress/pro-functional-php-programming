<?php

# First set some variables in global scope

$a = 25;
$b = 0;

# Do a simple require of the file.

$return_value =  require "procedural.php";

var_dump ( $return_value ); #60 - the script operated on our $a value of 25
var_dump ( $a ); # 25
var_dump ( $b ); # 50 - the script has mutated $b in the global scope

# Reset $b

$b = 0;

# This function executes the file as if it were a function, within the
# scope of the function. You can pass in a set of parameters as an array,
# and the extract line creates variables in the function scope which
# the code in the file can access. Finally, it requires the file and
# returns the files return value as its own.

$file_as_func = function ($filename, $params) {

		extract ($params);

		return require $filename;

};

# We'll call it on our procedural.php file, with a couple of parameters
# that have the same name but different values to our global $a and $b

var_dump ( $file_as_func( 'procedural.php', ['a'=>50, 'b'=>100] ) ); # 110
# this clearly operated on our parameter "a" and not the global $a

var_dump ( $a ); # 25
var_dump ( $b ); # 0 - unchanged this time
