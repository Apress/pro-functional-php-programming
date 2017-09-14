<?php

# Our function to create a partial function. $func is
# a "callable", i.e. a closure or the name of a function, and
# $args is one or more arguments to bind to the function.

function partial($func, ...$args) {

		# We return our partial function as a closure

    return function() use ($func, $args) {

				# The partial function we return consists of
				# a call to the full function using "call_user_func_array"
				# with a list of arguments made up of our bound
				# argument(s) in $args plus any others supplied at
				# calltime (via func_get_args)

        return call_user_func_array($func, array_merge($args, func_get_args() ) );

    };
}

# The partial function generator above binds the given
# n arguments to the *first* n arguments. In our case
# we want to bind the *last* argument, so we'll create
# another function that returns a function with the
# arguments reversed.

function reverse($func) {

	return function() use ($func) {

				return call_user_func_array($func,
									array_reverse(func_get_args()));

	};

}
