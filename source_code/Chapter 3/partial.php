<?php

require_once('print_first.php');

require_once('partial_generator.php');

$foods = ["mango", "apple pie", "cheese", "steak", "yoghurt", "chips"];

$print_top_five  = partial(reverse('print_first'), 5);

$print_top_five($foods);

$print_best = partial(reverse('print_first'), 1);

$print_best($foods);
