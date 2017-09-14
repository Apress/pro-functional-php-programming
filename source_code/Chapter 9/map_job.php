#!/usr/bin/env php
<?php

require('job_functions.php');

# Compose our analysis function

$hadoop_analyze = compose(

										$get_stream,

										$only_letters_and_spaces,

										'strtolower',

										$analyze_words,

										'json_encode'

);

# Run the analysis function on the input from Hadoop on STDIN
# and write the results to STDOUT

fwrite( STDOUT, $hadoop_analyze(STDIN) );
