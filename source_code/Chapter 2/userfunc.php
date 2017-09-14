<?php

function list_fruit($item) {

	return ['apple','orange','mango'][$item];

}

function list_meat($item) {

	return ['pork','beef','human'][$item];

}

$the_list = 'list_fruit';

var_dump( call_user_func($the_list, 2) );

$the_list = 'list_meat';

var_dump( call_user_func($the_list, 1) );
