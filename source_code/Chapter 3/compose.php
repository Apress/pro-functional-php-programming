<?php

# This is a special function which simply returns it's input,
# and is called the "identity function" in functional programming.

function identity ($value) { return $value; };

# This function takes a list of "callables" (function names, closures etc.)
# and returns a function composed of all of them, using array_reduce to
# reduce them into a single chain of nested functions.

function compose(...$functions)
{
    return array_reduce(

				# This is the array of functions, that we are reducing to one.
        $functions,

				# This is the function that operates on each item in $functions and
				# returns a function with the chain of functions thus far wrapped in
				# the current one.

		    function ($chain, $function) {

		        return function ($input) use ($chain, $function) {

		            return $function( $chain($input) );

		        };

		    },

				# And this is the starting point for the reduction, which is where
				# we use our $identity function as it effectively does nothing

		    'identity'

		);
}
