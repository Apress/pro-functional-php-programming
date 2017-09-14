<?php

# Include and use the trampoline library

include('trampoline/src/Trampoline.php');
include('trampoline/src/functions.php');

use FunctionalPHP\Trampoline as T;

# First define our standard recursive function

$factorial = function ($i, $total = 1) use (&$factorial) {

		# if $i is 1, return the total, otherwise
		# recursively call the function on $i-1,
		# multiplying the accumulating total by $i

    return $i == 1 ? $total : $factorial($i - 1, $i * $total);

		# note that $factorial is the tail call here
		# when it is returned

};

# Now the same function again, but this time using the
# trampoline function. The only difference (other than
# the name!) is that we wrap the tail call in T\bounce()

$bounced_factorial = function ($i, $total = 1) use (&$bounced_factorial) {

    return $i == 1 ? $total : T\bounce($bounced_factorial, $i - 1, $i * $total);

};

# We use T\trampoline() to call the "bounced" function.
# We'll wrap it in a helper function called $trampolined
# for ease of use

$trampolined = function ($i) use ($bounced_factorial) {

	return T\trampoline($bounced_factorial, $i);

};

# We'll create a function to time how long our
# function runs take, in seconds

$timer = function($func, $params) {

	$start_time = microtime(true);

	call_user_func_array($func,$params);

	return round(microtime(true) - $start_time,5);

};

# So let's run our normal recursive function
# and the trampolined version, both to
# calculate the factorial of one hundred thousand.
# The result will be the same, we're only
# interested in the time they take here.

var_dump ( $timer($factorial, [100000]) );

var_dump ( $timer($trampolined, [100000]) );

# Now let's limit the memory we're working with
# and run them again, this time to calculate
# the factorial of one million. We'll run the
# trampolined first, for reasons that you will
# see.

ini_set('memory_limit','100M');

var_dump ( $timer($trampolined, [1000000]) );

var_dump ( $timer($factorial, [1000000]) );
