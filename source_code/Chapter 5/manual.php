<?php

# A script to do some "busywork", filling
# some strings with some characters.

# Let's create a "checkpoint" by recording the current time and memory
# usage

$time1 = microtime(true);

$memory1 = memory_get_usage();

# Now let's do a loop 10 times, having a quick usleep and
# adding just a little data to our variable each time

$a_string = (function () {

  $output = '';

  for ($counter = 0; $counter < 10; $counter++) {

     usleep(10);

     $output .= 'a';

  };

  return $output;

})(); //we execute the function straightaway

# Now create a second checkpoint

$memory2 = memory_get_usage();

$time2 = microtime(true);

# Let's do this second loop 1000 times, having a longer
# sleep and adding lots of data to our variable each time

$b_string = (function () {

  $output = '';

  for ($counter = 0; $counter < 10; $counter++) {

     usleep(100);

     $output .= str_repeat('abc',1000);

  };

  return $output;

})(); //again we execute straight away

# and create a final checkpoint

$memory3 = memory_get_usage();

$time3 = microtime(true);

# Now let's output the time and memory used after each function.

echo "1st function : ".($time2-$time1)." secs, ".
    ($memory2-$memory1)." bytes\n";

echo "2nd function : ".($time3-$time2)." secs, ".
    ($memory3-$memory2)." bytes\n";

echo ("Peak memory usage : ". memory_get_peak_usage()." bytes\n");
