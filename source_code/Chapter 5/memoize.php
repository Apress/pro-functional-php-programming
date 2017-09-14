<?php

# We're going to cache our results on disk, so let's
# define a directory and file prefix

define('CACHE_PREFIX', sys_get_temp_dir().'/memo-cache-');

# This is a helper function to read a cached file
# from disk. I've broken it out as a separate function
# as it is necessarily impure. You can replace it
# with an IO monad or similar in production if you wish

$get_value = function($hash) {

	# return null if the file doesn't exist

	if (!file_exists(CACHE_PREFIX.$hash)) { return null;  }

	# read the file into $value

	$value = file_get_contents(CACHE_PREFIX.$hash);

	# return null if the file exists but couldn't be read

	if ($value === false) { return null; }

	# return our value if all is good

	return $value;

};

# Likewise, this is an impure helper function to write
# the value to a cache file.

$store_value = function($hash, $value) {

	if (file_put_contents(CACHE_PREFIX.$hash, $value) === false) {

		$value = null;

	}

	# return the value that was stored, or null if the
	# storage failed

	return $value;

};

# Finally, this is our actual memoization function.
# It returns a closure which is a "memoized" version
# of the function you call it on, i.e. a version
# of your function which automatically caches return
# values and automatically uses those cached values
# without further coding from you.

# $func is the function (closure or other callable) that
# you want to memoize

$memoize = function($func) use ($get_value, $store_value)
{
		# We're returning a memoized function

    return function() use ($func, $get_value, $store_value)
    {

				# Get the parameters you (the end user) call
				# your memoized function with

        $params = func_get_args();

				# Get a unique hash of those parameters, to
				# use as our cache's key. We needs to convert
				# the params array to a string first, we use
				# json_encode rather than serialize here as
				# it is a lot faster in most cases

		    $hash = sha1( json_encode( $params ) );

				# Check the cache for any return value that
				# has already been cached for that particular
				# set of input parameters (as identified by
				# its hash)

				$value = $get_value($hash);

				# If there was no pre-cached version available,
				# $value will be null. We check this with the ??
				# null coalescing operator, returning either :
				# a) the cached $value if it's not null, or
				# b) the results of actually calling the user
				# function. Note that we wrap the call in the
				# $store_value function to cache the results,
				# and $store_value passes the value back
				# through as its result and so it is also
				# returned to the user in this case

				return $value ?? $store_value(

									$hash, call_user_func_array($func, $params)

							 );
    };

};
