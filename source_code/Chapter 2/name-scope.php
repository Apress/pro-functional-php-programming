<?php

function a() {

	function b() {

		return "a -> b";

	}

	return "a";

}

function c() {

	function d() {

		function e() {

			return "c -> d -> e";

		}

		return "c -> d";

	}

	return "c";

}

var_dump( a() );

var_dump( b() );

var_dump( c() );

var_dump( d() );

var_dump( e() );
