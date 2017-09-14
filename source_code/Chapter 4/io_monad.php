<?php

include('src/IO.php');

use PhpFp\IO\IO;

# Some functions that define how to create
# some other, impure functions

# Make a random string of hex characters from $length random bytes

$string_maker = function($length) {

    return new IO( function () use ($length) {

    									return bin2hex(random_bytes($length));

										}

								 );
};

# Write a string to $filename on disk

$file_writer = function($filename) {

    return function ($string) use ($filename)  {

        return new IO( function () use ($filename,$string) {

                					file_put_contents($filename,$string);

            						}
        						 );
    				};
};

# Send ($string) to STDOUT

$printer = function($string) {

    return function () use ($string)  {

        return new IO( function () use ($string) {

                					echo($string."\n");

            						}

        						 );
    				};
};

# Chain those functions together, and return the resulting
# monad

return  $string_maker(100)
												->chain($file_writer('random.txt'))
												->chain($printer('All done'));
