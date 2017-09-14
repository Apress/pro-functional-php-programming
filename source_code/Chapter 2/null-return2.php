<?php

function fruits($type) {

	if ($type == 'mango') {

		return 'Yummy!';

	} else {

		return;

	}

}


var_dump( fruits('kiwi') );

var_dump( fruits('pomegranate') );

var_dump( fruits('mango') );
