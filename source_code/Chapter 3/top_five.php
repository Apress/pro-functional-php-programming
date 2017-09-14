<?php

require_once('print_first.php');

# Some data ...
$best_names = ["Rob", "Robert", "Robbie", "Izzy", "Ellie", "Indy",
	"Parv", "Mia", "Joe", "Surinder", "Lesley"];

# Calling the function in full

print_first($best_names, 5);

# Now let's define a partial function, print_top_list, which
# binds the value 5 to the second parameter of print_first

function print_top_list($list) {
	print_first($list, 5);
};

# Calling the new partial function will give the same
# output as the full function call above.

print_top_list($best_names);
