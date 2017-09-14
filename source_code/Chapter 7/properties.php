<?php

# Get our compose function
require '../Chapter 3/compose.php';

# This class will provide a set of methods to work with tax

class tax_functions {

  # Store the rate of tax

  private $tax_rate;

  # Our constructor sets the tax rate initially

  public function __construct($rate) {

    $this->tax_rate = $rate;

  }

  # Provide a method to set the tax rate at any point

  public function set_rate($rate) {

    $this->tax_rate = $rate;

  }

  # A method to add tax at the $tax_rate to the $amount

  public function add_tax($amount) {

    return $amount * (1 + $this->tax_rate / 100);

  }

  # A method to round the $amount down to the nearest penny

  public function round_to($amount) {

    return floor($amount * 100) / 100;

  }

  # A function to format the $amount for display

  public function display_price($amount) {

    return '£'.$amount.' inc '.$this->tax_rate.'% tax';

  }

}

# So let's create an object for our program containing the
# methods, with the tax rate set at 10%

$funcs = new tax_functions(10);

# Now let's compose our methods into a flow that adds tax, rounds
# the figure and then formats it for display.

# Note that to pass a method of an object as a callable, you need
# to give an array of the object and method name. If you are using
# static class methods, you can use the class::method notation instead

$add_ten_percent = compose (

    [$funcs, 'add_tax'],

    [$funcs, 'round_to'],

    [$funcs, 'display_price']

  );

# We've composed our $add_ten_percent function, but we may not want to use it
# until much later in our script.

# In the mean-time, another programmer inserts the following line in our
# code in between...

$funcs->set_rate(-20);

# and then we try to use our $add_ten_percent function to add
# tax to 19.99, hopefully getting the answer £21.98 inc 10% tax

var_dump( $add_ten_percent(19.99) ); # £15.99 inc -20% tax
