<?php

require('functions.php');

# Get the chunk of text for the client to analyze
# by reading the contents of STDIN which are piped to
# this script by the fwrite($clients[$key]["pipes"][0], $string)
# line in the $launch_clients function in the parent process

$string = stream_get_contents(STDIN);

# Compose a function to do the analysis. This is the same
# as the first three steps of the single process analysis
# function, with a step to encode the results as JSON at
# the end so we can safely pass them back

$client_analyze = compose(

										$only_letters_and_spaces,

										'strtolower',

										$analyze_words,

										'json_encode'

);

# Run the function and write the results to STDOUT,
# which will be read by the stream_get_contents($client["pipes"][1])
# line in the $get_results function in the parent process. In most cases
# you can use echo to write to STDOUT, but sometimes it can be
# redirected, and so explicitly writing like this is better practice

fwrite(STDOUT, $client_analyze($string) );
