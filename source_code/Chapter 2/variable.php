<?php

function vehicles( $index ) {

	$types = ["car", "motorbike", "tractor"];

	return $types[$index];

}

function animals( $index ) {

	$types = ["cow", "pig", "chicken", "horse"];

	return $types[$index];

}


$get_thing = 'animals'; # string with the name of a function

var_dump( $get_thing(2) ); # add ($index) to call it

$get_thing = 'vehicles'; # change the function

var_dump( $get_thing(2) ); #same "code", different function

# Just to show that $get_thing is just a
# standard string, and nothing special...

$get_thing = strrev('selcihev'); # do string things

var_dump( $get_thing ); # it's a string

var_dump( $get_thing(2) ); # call it

var_dump( $get_thing ); # afterwards, still just a string

unset( $get_thing ); # we can destroy it, because it's a string

var_dump( $get_thing );

var_dump( vehicles(2) ); # But the function still exists

# However, it needs to be set to a function that exists

$get_thing = 'people';

var_dump( $get_thing(2) );
