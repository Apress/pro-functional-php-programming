<?php

$my_func = function ($par) {

  static $sta;
  global $glo;

  var_dump( "static : ". $sta += 1 );
  var_dump( "global : ". $glo += 1 );
  var_dump( "param  : ". $par += 1 );
  var_dump( "normal : ". $nor += 1 );

  return $sta;

};

while ( $my_func(1) < 5) { echo "-----\n"; };

echo "*****\n";

var_dump( "static : ". $sta );
var_dump( "global : ". $glo );
var_dump( "param  : ". $par );
var_dump( "normal : ". $nor );
