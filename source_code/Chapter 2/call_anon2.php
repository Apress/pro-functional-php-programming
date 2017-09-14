<?php

# Define a function that is assigned to a variable,
# that takes a function as its first parameter
# and a parameter to call that function with as its
# second

$function_caller = function ($function, $parameter) {

	$function($parameter);

};

# Define a named function

function double($a) {

	echo ($a * 2)."\n";

}

# use the anonymous function to call the named function
# using the Variable Function technique

$function_caller('double', 4);

# this time, define a new anonymous function right in the
# calling parameter code

$function_caller( function($a) { echo 'Function says ' . $a . "\n"; },
 	'Hello There');

# Do it again, but with a different anonymous function. Note that
# the anonymous function no longer exits once the function
# has finished executing.

$function_caller( function($a) { echo $a . ' backwards is '. strrev($a) . "\n"; },
 	'Banana');

# It's not only our own functions that can accept inline definitions
# of anonymous functions ...

var_dump(
	array_map( function($a) { return $a * 2; }, [1,2,3,4])
);
