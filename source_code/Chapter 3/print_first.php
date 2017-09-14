<?php

function print_first($items, $count) {

		echo "Showing $count of ".sizeof($items)." items: \n";

		for ($counter=0; $counter<$count; $counter++) {

			echo ($counter+1).". ${items[$counter]} \n";

		}
}
