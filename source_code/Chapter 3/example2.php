<?php

require_once('image_functions.php');

require_once('stats_functions.php');

require_once('data_functions.php');

require_once('compose.php');

$csv_data = file_get_contents('my_data.csv');

$make_chart = compose(

'data_to_array',

'generate_stats',

'make_chart_image'

);

file_put_contents('my_chart.png', $make_chart( $csv_data ) );
