<?php

function get_multiplier($count) {

  return function ($number)  {

    return $number * $count;
    
  };

}

$times_six = get_multiplier(6);

print_r( $times_six(3) );
