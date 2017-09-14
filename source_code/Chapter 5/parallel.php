<?php

# Get a set of functions that we'll look at shortly

require('functions.php');

# The text to work on.

$shakespeare = file_get_contents('all_shakespeare.txt');

# How many times we're going to run each function, for
# benchmarking purposes

$repeats = 100;

# Compose our single process "standard" function.

$analyze_single = compose(

					$only_letters_and_spaces, # simplify the text

					'strtolower', # all lowercase, please

					$analyze_words, # do the analysis

					$sort_results, # sort the results

					'array_reverse', # get the results in descending order

					$top_ten # return the top ten results
);

# Run the single process version $repeats time on $shakespeare input
# Time the runs

$checkpoint1 = microtime(true);

print_r( $repeat($analyze_single, $repeats, $shakespeare) );

$checkpoint2 = microtime(true);

# Now create a parallel process version

$analyze_parallel = compose (

					$launch_clients, # Launch a set of client processes to do
													 # the analysis

					$report_clients, # Tell us how many clients were launched

					$get_results, # Get the results back from the clients

					$combine_results, # Combine their results into one set

					$sort_results, # sort the combined results

					'array_reverse', # get the results in descending order

					$top_ten # return the top ten results
);

# Run the parallel version and time it

$checkpoint3 = microtime(true);

print_r ( $repeat($analyze_parallel, $repeats, $shakespeare) );

$checkpoint4 = microtime(true);

# Finally, dump the timings for comparison

var_dump( 'Single : '.($checkpoint2 - $checkpoint1));

var_dump( 'Parallel : '.($checkpoint4- $checkpoint3));
