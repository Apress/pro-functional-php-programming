<?php

# Start an IIFE

(

	# Execute the io_monad.php file to get the monad

	require('io_monad.php')

	# At this stage, we have a monad full of functions
	# that have not been called (and so haven't done)
	# any "impure" work

# Finally call the unsafePerform() method on the monad to
# call the "impure" functions

)->unsafePerform();
