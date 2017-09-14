<?php

# Create a class to represent an immutable array

# Make the clas "final" so that it can't be extended to add
# methods to mutate our array

final class const_array {

  # Our array property, we use a private property to prevent
  # outside access

  private $stored_array;

  # Our constructor is the one and only place that we set the value
  # of our array. We'll use a type hint here to make sure that we're
  # getting an array, as it's the only "way in" to set/change the
  # data, our other methods can be sure they are then only dealing
  # with an array type

  public function __construct(array $an_array) {

    # PHP allows us to call the __construct method of an already created
    # object whenever we want as if it was a normal method. We
    # don't want this, as it would allow our array to be over written
    # with a new one, so we'll throw an exception if it occurs

    if (isset($this->stored_array)) {

        throw new BadMethodCallException(
                    'Constructor called on already created object'
                  );

    };

    # And finally store the array passed in as our immutable array.

    $this->stored_array = $an_array;

  }

  # A function to get the array

  public function get_array() {

          return $this->stored_array;

  }

  # We don't want people to be able to set additional properties on this
  # object, as it de facto mutates it by doing so. So we'll throw an
  # exception if they try to

  public function __set($key,$val) {

    throw new BadMethodCallException(
                'Attempted to set a new property on immutable class.'
              );

  }

  # Likewise, we don't want people to be able to unset properties, so
  # we'll do the same again. As it happens, we don't have any public
  # properties, and the methods above stop the user adding any, so
  # it's redundant in this case, but here for completeness.

  public function __unset($key) {

              throw new BadMethodCallException(
                          'Attempted to unset a property on immutable object.'
                        );

  }

}

# Let's create a normal array

$mutable_array = ["country" => "UK", "currency" => "GBP", "symbol" => "£"];

# and create an const_array object from it

$immutable_array = new const_array($mutable_array);

var_dump ($immutable_array);

# Let's mutate our original array

$mutable_array["currency"] = "EURO";

# our const_array is unaffected

var_dump ($immutable_array);

# We can read the array values like normal

foreach ( $immutable_array->get_array() as $key => $value) {

    echo "Key [$key] is set to value [$value] \n\n";

};

# And use dereferencing to get individual elements

echo "The currency symbol is ". $immutable_array->get_array()["symbol"]."\n\n";

# Need to copy it? Just clone it like any other object, and the methods
# which make it immutable will be cloned too.

$new_array = clone $immutable_array;

var_dump ($new_array);

# The following operations aren't permitted though, and will throw exceptions

# $immutable_array->stored_array = [1,2,3];
#   BadMethodCallException: Attempted to set a new property on immutable class

# $immutable_array->__construct([1,2,3]);
#   BadMethodCallException: Constructor called on already created object

# unset($immutable_array->get_array);
#   BadMethodCallException: Attempted to unset a property on immutable object.

# $immutable_array->new_prop = [1,2,3];
#    BadMethodCallException: Attempted to set a new property on immutable class

# $test = new const_array();
#    TypeError: Argument 1 passed to const_array::__construct()
#    must be of the type array, none given

# class my_mutable_array extends const_array {
#
#   function set_array ($new_array) {
#
#       $this->stored_array = $new_array;
#
#   }
#
# };
#   Fatal error:  Class my_mutable_array may not inherit from final
#   class (const_array)

# Unfortunately, there is no practical way to stop us overwriting the object
# completely, either by unset()ing it or by assigning a new value to the
# object variable, such as by creating a new const_array on it

$immutable_array = new const_array([1,2,3]);

var_dump($immutable_array); # new values stored
