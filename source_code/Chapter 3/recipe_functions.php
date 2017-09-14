<?php

function combine($a,$b) {

	$combinations = [];

	if (is_array($a)) {
		foreach ($a as $i) {
			$combinations = array_merge( $combinations, combine($i, $b) );
		}
	} else {
			foreach ($b as $i) {
				$combinations[] = $a.' '.$i;
			}
	}

	return $combinations;

}

function print_first($items, $count) {

		echo "Showing $count of ".sizeof($items)." items: \n";

		for ($counter=0; $counter<$count; $counter++) {

			echo ($counter+1).". ${items[$counter]} \n";
			
		}
}
