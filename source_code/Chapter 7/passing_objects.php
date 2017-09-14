<?php

# Create a class to encapsulate a value

class my_class
{

		# The value we want to encapsulate

    private $value = 0;

		# Constructor to set the value (or default to -1)

		public function __construct($initial_value = -1) {

			$this->value = $initial_value;

		}

		# Method to get the value

    public function get_value() {

        return $this->value;

    }

		# Method to set the value

		public function set_value($new_value) {

        $this->value = $new_value;

    }
}

# Let's create a new object with a value of 20

$my_object = new my_class(20);

# Check the value

var_dump ($my_object->get_value()); # int(20)

# Demonstrate we can mutate the value to 30

$my_object->set_value(30);

var_dump ($my_object->get_value()); # int (30)

# Now let's create a function which doubles the value
# of the object. Note that the function parameter
# doesn't have a "&" to indicate it's passed by reference

$double_object = function ($an_object) {

	# Get the value from $an_object, double it and set it back

	$an_object->set_value( $an_object->get_value() * 2 );

	# return the object

	return $an_object;

};

# Now we call the function on our $my_object object from
# above, and assign the returned object to a new variable

$new_object = $double_object($my_object);

# Check that the returned object has double the value (30)
# of the object we passed in as a parameter

var_dump( $new_object->get_value() ); # int(60)

# Let's just check the value on the original object

var_dump( $my_object->get_value()); # int(60)

# It's also changed. Let's var_dump the original object
# and returned object, and check their object reference number
# (look for the number after the #)

var_dump ($my_object); # #1

var_dump ($new_object); # #1

# They're both the same. Just for clarity, create a new
# object from scratch and check it's reference number

$last_object = new my_class();

var_dump ($last_object); # #3 (#2 was our closure object $double_object)
