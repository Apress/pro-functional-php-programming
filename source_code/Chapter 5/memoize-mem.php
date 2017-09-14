<?php

$memoize = function($func)
{

    return function() use ($func)
    {

				static $cache;

        $params = func_get_args();

		    $hash = sha1( json_encode( $params ) );

				$cache["$hash"] = $cache["$hash"] ??
													call_user_func_array($func, $params);

				return $cache["$hash"];
    };
};
