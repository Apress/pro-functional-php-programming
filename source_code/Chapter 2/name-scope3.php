<?php

function f() {

	function g() {

		return "1st g()";

	};

	return "f()";

}

function h() {

	function g() {

		return "2nd g()";

	};

	return "h()";

}

var_dump( f() );

var_dump( g() );

var_dump( h() );
