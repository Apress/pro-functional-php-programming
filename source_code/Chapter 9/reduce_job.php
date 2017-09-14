#!/usr/bin/env php
<?php

require('job_functions.php');

# Compose our reduce function

$reduce = compose (

					$get_stream_results,

					$combine_results,

					$sort_results,

					'array_reverse',

					$top_ten
);

# Call our reduce function on the results of the map jobs which Hadoop
# provides on STDIN, and print out the final result which Hadoop will
# save to disk

print_r( $reduce(STDIN) );
