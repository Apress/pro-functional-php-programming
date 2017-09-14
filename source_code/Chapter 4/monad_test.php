<?php

require('MonadPHP/Monad.php');
require('MonadPHP/Identity.php');

use MonadPHP\Identity;

# 1. bind( unit($i), $func ) == $func( $i )

// define some test variables and functions

$i = 10;
$func = function ($i) {	return $i*2; };

// create a new monad to test

$monad = Identity::unit($i);

// see if the 1st Axiom holds (should output true)

var_dump ( $monad->bind($func)->extract() == $func($i) );

# 2. bind($monad, unit) == $monad

// and see if the 2nd Axiom also holds

var_dump ( $monad->bind(Identity::unit) == $monad );

# 3. bind ( bind($monad, $f1), $f2) ==
#          bind ($monad, function($i) { return bind( $f1($i), $f2($i) } )


// create some more test functions

$f1 = function ($i)  { return Identity::unit($i); }; // returns a monad
$f2 = function ($i) { return $i*6; };

// and see if Axiom 3 holds

var_dump (

     $monad->bind($f1)->bind($f2) ==
          $monad->bind(function ($i) use ($f1, $f2)
                          { return $f1($i)->bind($f2); }
                      )

);
