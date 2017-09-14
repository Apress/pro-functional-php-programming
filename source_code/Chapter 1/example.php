<?php

require_once('image_functions.php');

require_once('stats_functions.php');

require_once('data_functions.php');


$csv_data = file_get_contents('my_data.csv');


$chart = make_chart_image (

					generate_stats (

						data_to_array (

								$csv_data
						)

					)

				);

file_put_contents('my_chart.png', $chart);
