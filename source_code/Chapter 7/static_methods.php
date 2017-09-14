<?php

# use our trusty compose function

include('../Chapter 3/compose.php');

# The same class as before, but with an added static method

class new_class
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

		# a static method to halve the provided value

		public static function halve($value) {

			return $value / 2;

		}

}

# Let's create a new object with an initial value of 25

$my_object = new new_class(73.4);

# Let's stack some math functions together including our
# static method above

$do_math = compose (

							'acosh',
							'new_class::halve',
							'floor'
	);

# Now let's actually do the math. We set the object value
# to the result of $do_math being called on the original value.

$my_object->set_value(

											$do_math(

																$my_object->get_value()

																)
										 );

# Show that our object value has been changed. Note that nothing changed
# while we were in our functional (compose) code.

var_dump ( $my_object->get_value() ); # float(2)
