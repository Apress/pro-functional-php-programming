<?php

# Get the library

require('Underscore.php/underscore.php');

# Create a simple function to output a dot

$write = function ($text) { echo '.'; };

# create a new function which is a throttled version of
# $write. It will execute at a maximum once per 1000ms.
# Any other calls during that 1000ms will be ignored.

$throttled_write = __::throttle( $write, 1000);

# Let's call $throttled_write 10 million times. On my
# system that takes a little over 7 seconds, but as it will
# only *actually* execute once every 1000ms (1sec) we
# will get a line of 7 dots printed.

__::times(10000000, $throttled_write);
