<?php

function count_total ($list) {

	  # we start like before, with a variable to hold our total

    $total = 0;

		# and then we loop through each value in our array

    foreach ($list as $food => $value) {

			 # for each value in the array, which check if it
			 # is infact another array ...

        if (is_array ($value)) {

						# ... in which case we call *this* function
						# on the new (sub)array, and add the result
						# to the $total. This is the recursive part.

            $total += count_total ($value);

        } else {

						# ... or if it's just a plain old value
						# we add that straight to the total

            $total += $value;

        }

    }

		# once we've finished the foreach loop, we will have
		# added ALL of the values of the array together, and
		# also called count_total() on all of the sub-arrays
		# and added that to our total (and each of those
		# calls to count_total() will have done the same on
		# any sub-arrays within those sub-arrays, and so on)
		# so we can return the total.

		return $total;

};

# Let's call it on our original shopping list

require('shopping_list1.php');

echo "List 1 : ".count_total($shopping)."\n";

# and then on the list with the apples sub-array

require('shopping_list2.php');

echo "List 2 : ".count_total($shopping)."\n";

# and finally on a new list which has sausages broken
# into pork and beef, with pork broken down to a third
# level between chipolatas and cumberland sausages.

require('shopping_list3.php');

echo "List 3 : ".count_total($shopping)."\n";
