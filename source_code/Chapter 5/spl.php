<?php

# Borrow our simple generator example

function gen_range($start, $end, $step) {

  for ($i = $start; $i <= $end; $i += $step) {

    yield $i;

  }

};

# Call the generator...

$gen_obj = gen_range(1,10,1);

# ... and check what we have is a generator object
print_r($gen_obj);

# Generators are iterators, so when we need a full array
# of data instead of a generator, we can convert
# it to an array using SPL's iterator_to_array function

$array = iterator_to_array($gen_obj);

print_r($array);

# An SplFixedArray is SPLs fixed size array data structure.
# Let's create an empty SPL fixed array and a standard PHP array.
# Note we need to specify a size for the SPL array

$spl_array = new SplFixedArray(10000);

$std_array = [];

# Let's create a function to fill an array with data. As both
# array types can be written to in the same way, we can
# use the same function here for both

$fill_array = function($array, $i = 0) use (&$fill_array) {

	# recursively fill the $array with data

	if ($i < 10000) {

		$array[$i] = $i * 2;

		return $fill_array($array, ++$i);

	};

	return ($array);

};

# Let's do some operations with the arrays. We'll measure
# the memory in use before and after each operation.

$mem1 = memory_get_usage();

# Fill the standard array with data

$std_array = $fill_array($std_array);

$mem2 = memory_get_usage(); # 528384 bytes

# Fill the SPL array with data

$spl_array = $fill_array($spl_array);

$mem3 = memory_get_usage(); # 0 bytes

# It took no memory to fill!
# This is because this type of array allocates all of its memory
# up-front when you create it

# Create a new SPL array and fill with data

$spl_array2 = new SplFixedArray(10000);

$spl_array2 = $fill_array($spl_array2);

$mem4 = memory_get_usage(); # 163968 bytes

# This time it did, as we declared it within the section we
# were measuring

# Create a new empty standard array

$std_array2 = [];

$mem5 = memory_get_usage(); # 56 bytes - a small amount

# Create a new empty SPL array

$spl_array3 = new SplFixedArray(10000);

$mem6 = memory_get_usage(); # 163968 bytes - for an empty array!

# This shows that you need to use it with care. A Standard
# array may use more memory for the same amount of data, but
# the memory also shrinks with the array contents too.

echo "Filled Standard Array : ".($mem2 - $mem1). " bytes \n";

echo "1st Filled SPLFixedArray : ".($mem3 - $mem2). " bytes \n";

echo "2nd Filled SPLFixedArray : ".($mem4 - $mem3). " bytes \n";

echo "Empty Standard Array : ".($mem5 - $mem4). " bytes \n";

echo "Empty SPLFixedArray : ".($mem6 - $mem5). " bytes \n";

# The SPL provides various iterator classes that you can extend
# to work with iterable structures like the SPLFixedArray and
# generators

# Let's create a class to filter for values that are divisible by three

class by_three extends FilterIterator {

	# We extend the FilterIterator class, and implement the accept() class
	# with our filtering function

  public function accept()
  {

    $value = $this->current();


    if ($value % 3 == 0) {

			# return true to include the value in the output

      return true;

    }

		 # or false to filter it out

    return false;
  }

};

# Let's use it to filter our previous SPL array

$nums = new by_three($spl_array);

var_dump(iterator_count($nums)); # int(3334) (~third of the array is returned)
