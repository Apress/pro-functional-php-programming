<?php

require('shopping_list1.php');

$total = 0;

foreach ($shopping as $group) {

	foreach ($group as $food => $count) {

		$total += $count;

	}

}

echo "Total items to purchase : $total\n";
