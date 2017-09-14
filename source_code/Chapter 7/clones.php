<?php

# use our trusty compose function

include('../Chapter 3/compose.php');

# The same class as previously

class my_class
{

    private $value = 0;

		public function __construct($initial_value = -1) {

			$this->value = $initial_value;

		}

    public function get_value() {

        return $this->value;

    }

		public function set_value($new_value) {

        $this->value = $new_value;

    }

}

# A function to triple the value of the object

$triple_object = function ($an_object) {

	# First clone it to make sure we don't mutate the object that
	# $an_object refers to

	$cloned_object = clone $an_object;

	# Then set the value to triple the current value

	$cloned_object->set_value( $cloned_object->get_value() * 3 );

	# and return the new object

	return $cloned_object;

};

# A function to multiply the value of the object by Pi.
# Again we clone the object first and return the mutated clone

$multiply_object_by_pi = function ($an_object) {

	$cloned_object = clone $an_object;

	$cloned_object->set_value( $cloned_object->get_value() * pi() );

	return $cloned_object;

};

# Let's create an object encapsulating the value 10.

$my_object = new my_class(10);

# We'll compose the above functions together

$more_maths = compose(
											$triple_object,
											$multiply_object_by_pi,
											$triple_object
	);

# and then call that composition on our object.

var_dump ( $more_maths($my_object) );

# Let's check our original object remains unchanged

var_dump ($my_object);
