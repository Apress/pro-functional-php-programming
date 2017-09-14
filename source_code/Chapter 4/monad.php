<?php

require('MonadPHP/Monad.php');
require('MonadPHP/Identity.php');

# Use the namespace

use MonadPHP\Identity;

# Define a couple of pure functions

$double = function ($n) {	return $n*2; };

$add_ten = function ($n) { return $n+10; };

# Create a monad by calling the static unit method,
# with a value (33). The unit method is a constructor
# which checks if what we are passing in is already
# an instance of this monad, or create a new one if
# not by calling the _construct method to bind
# our value (33) and return a monad object

$monad_a = Identity::unit(33);

# Let's check it is an object of class MonadPHP\Identity
# encapsulating the value 33

var_dump( $monad_a );

# Now we bind one of our functions to the monad

$monad_b = $monad_a->bind($double);

# $monad_b should be a new monad object.
# Let's check that it is and that we haven't
# just mutated monad1

var_dump( $monad_a ); # should be the same as above

var_dump( $monad_b ); # should be a new monad encapsulating 66

# This library includes a helper method "extract" to
# get the encapsulated value back out of the monad

var_dump( $monad_b->extract() ); #66

# Let's bind that function again to the new monad...

$monad_c = $monad_b->bind($double);

var_dump( $monad_c->extract() ); #132

# ... and check that monad_b is unchanged

var_dump( $monad_b->extract() ); #66

# finally, bind the function again to monad_b,
# to demonstrate again that its encapsulated value
# isn't mutated.

$monad_d = $monad_b->bind($double);

var_dump( $monad_d->extract() ); #132

# Let's now repeatedly bind methods
# in a chain

$monad_e = $monad_d->bind($double)  # *2
								->bind($add_ten)  # +10
								->bind($add_ten); # +10

var_dump( $monad_e->extract() ); # 284

# and take a look at the returned monad_e,
# take note of the object identifier (#7)

var_dump( $monad_e );
