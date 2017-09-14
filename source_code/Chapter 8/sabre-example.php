<?php

# Autoload the library

require __DIR__ . '/vendor/autoload.php';

# You will need to use the Saber datatypes for all data

use \Saber\Data\IInt32;

# Ordinary PHP variable

$start = 20;

# To work with the value, we need to "box" it into a Saber object
# which encapsulates it in a "strictly typed" object

$boxed_value = IInt32\Type::box($start);

# We can chain functions onto the boxed value (note that the parameters
# for those functions also need to be the correct boxed types)

$boxed_result = $boxed_value -> increment() # 21

						                 -> increment() # 22

														 -> multiply( IInt32\Type::box(3) ) # 66

						                 -> decrement(); # 65

# To get the value back out into a standard PHP variable we need to "unbox" it

var_dump( $boxed_result->unbox() ); # 65

# And check that the original boxed value object that we chained the
# functions on is unmutated

var_dump( $boxed_value->unbox() ); # 20
