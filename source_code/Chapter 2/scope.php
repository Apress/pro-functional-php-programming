<?php

# Define some variables in the "Global" scope
$a = 2;
$b = 6;

function double($a) {

  # In this function's scope, we'll double $a
  $a = $a * 2;

  return $a;

}

# This is like the function above, except
# we've passed in the variable by reference
# (note the & before $a in the parameters)
function double_ref(&$a) {

  $a = $a * 2;

  return $a;

}

function double_add($a) {

  # We'll pull in $b from the global scope
  global $b;

  # and double it
  $b = $b * 2;

  # and double $a from the local function scope
  $a = $a * 2;

  return $a + $b;

}

# a in the global scope = 2
echo("a = $a \n");

# a in the function scope, doubled, = 4
echo("double a = ". double($a). " \n");

# but a in the global scope still = 2
echo("a = $a \n");

# now we pass it in by reference
echo("double_ref a = ". double_ref($a). " \n");

# and now $a = 4;
echo("a = $a \n");

# b in the global scope = 6
echo("b = $b \n");

# doubled and added = 8 + 12 = 20
echo("double_add a+b = ". double_add($a). " \n");

# a is still = 4 in the global scope
echo("a = $a \n");

# but b in the global scope is now doubled = 12
echo("b = $b \n");
