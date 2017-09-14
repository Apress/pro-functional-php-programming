<?php

include('compose.php');

# A function to format a string for display

function display($string) {
  echo "The string is : ".$string."\n";
};

# Our function to wrap str_repeat.
# Note it takes one parameter, the $count

function repeat_str($count) {

  # This function returns another (closure) function,
  # which binds $count, and accepts a single parameter
  # $string. Note that *this* returned closure is the
  # actual function that gets used in compose().

  return function ($string) use ($count) {

    return str_repeat($string, $count);

  };

};

# Now let's compose those two functions together.

$ten_chars = compose(

    repeat_str(10),
    'display'

  );

# and run our composed function

echo $ten_chars('*');
