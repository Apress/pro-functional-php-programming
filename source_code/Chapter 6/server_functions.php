<?php

# We'll create a set of functions that implement the logic that should
# occur in response to the events that we'll handle.

# Use our trusty partial function generator

require('../Chapter 3/partial_generator.php');

# A generic function to output an HTTP header. $req is an object representing
# the current HTTP request, which ensures that our function deals with the
# right request at all times.

$header = function ($name, $value, $req) {

	$req->addHeader ( $name , $value, EventHttpRequest::OUTPUT_HEADER );

};

# We are going to be serving different types of content (html, images etc.)
# so we need to output a content header each time. Let's create a
# partial function based on $header...

$content_header = partial($header, 'Content-Type' );

# and then make it specific for each type of content...

$image_header = partial($content_header, "image/jpeg");

$text_header  = partial($content_header, "text/plain; charset=ISO-8859-1");

$html_header = partial($content_header, "text/html; charset=utf-8");

# The following function creates a "buffer" to hold our $content and
# then sends it to the browser along with an appropriate HTTP status
# code (Let's assume our requests always work fine so send 200 for everything).
# Note that it's a pure function right up until we call sendReply. You could
# return the EventBuffer instead, and wrap it all into an IO or Writer monad to
# put the impure sendReply at the end if you wish.

$send_content = function($req, $content) {

	$output = new EventBuffer;

  $output->add($content);

  $req->sendReply(200, "OK", $output);

};

# The input parameters for our maths functions are held in the URI parameters.
# The URI is held in the $req request object as a string. Let's get the
# URI and parse out the parameters into an associative array.

$parse_uri_params = function ($req) {

	$uri = $req->getUri();

	parse_str(

		# Grab just the parameters (everything after the ?)

		substr( $uri, strpos( $uri, '?' ) + 1 ),

		# and parse it into $params array

		$params);

	return $params;

};

# Get the URI "value" parameter

$current_value = function($req) use ($parse_uri_params) {

	return $parse_uri_params($req)["value"];

};

# Get the URL "amount" parameter

$amount = function($req) use ($parse_uri_params) {

	return $parse_uri_params($req)["amount"];

};

# A function to send the results of one of our maths functions which follow.

$send_sum_results = function($req, $result) use ($html_header, $send_content) {

  # Create some HTML output, with the current result, plus some links
	# to perform more maths functions. Note the uri parameters contain
	# all of the state needed for the function to give a deterministic,
	# reproducable result each time. We also include some links to
	# the other utility functions. When you visit them, note that you
	# can use your browser back button to come back to the maths functions
	# and carry on where you left off, as the parameters the functions
	# need are provided by the URI parameters and no "state" has been
	# altered of lost

	$output = <<<ENDCONTENT

	<p><b>The current value is : $result</b></p>

	<p><a href="/add?value=$result&amount=3">Add 3</a></p>
	<p><a href="/add?value=$result&amount=13">Add 13</a></p>
	<p><a href="/add?value=$result&amount=50">Add 50</a></p>
	<p><a href="/subtract?value=$result&amount=2">Subtract 2</a></p>
	<p><a href="/subtract?value=$result&amount=5">Subtract 5</a></p>
	<p><a href="/multiply?value=$result&amount=2">Multiply by 2</a></p>
	<p><a href="/multiply?value=$result&amount=4">Multiply by 4</a></p>
	<p><a href="/divide?value=$result&amount=2">Divide by 2</a></p>
	<p><a href="/divide?value=$result&amount=3">Divide by 3</a></p>
	<p><a href="/floor?value=$result">Floor</a></p>

	<p><A href="/show_headers">[Show headers]</a>&nbsp;
	<a href="/really/cute">[Get cat]</a>&nbsp;
	<a href="/close_server">[Close down server]</a></p>

ENDCONTENT;

  # Send the content header and content.

	$html_header($req);

	$send_content($req, $output);

};

# These are our key maths functions. Each one operates like a good Functional
# function by only using the values supplied as input parameters, in this
# case as part of $req. We call a couple of helper functions ($current_value
# and $amount) to help extract those values, $req isn't necessarily
# immutable (we could alter values or call methods), but we'll use
# our discipline to keep it so right up until we're ready to send_contents.
# While we don't formally "return" a value, $send_sum_results effectively
# acts a return statement for us. Any return value would simply go back to
# libevent (which is the caller, and it just ignore it).
# If we want to keep to strictly using explicit return statements, we could
# wrap this in another function that does the same as $send_sum_results, (and
# for the same reason wouldn't have a return statement) or we could create an
# Writer monad or similar to gather the results and only output to the browser
# at the end. For this simple example we'll go with using $send_sum_results
# though for simplicity and clarity.

$add = function ($req) use ($send_sum_results, $current_value, $amount) {

  $send_sum_results($req, $current_value($req) + $amount($req) );

};

$subtract = function ($req) use ($send_sum_results, $current_value, $amount) {

  $send_sum_results($req, $current_value($req) - $amount($req) );

};

$multiply = function ($req) use ($send_sum_results, $current_value, $amount) {

  $send_sum_results($req, $current_value($req) * $amount($req) );

};

$divide = function ($req) use ($send_sum_results, $current_value, $amount) {

  $send_sum_results($req, $current_value($req) / $amount($req) );

};

$floor = function ($req) use ($send_sum_results, $current_value) {

  $send_sum_results($req, floor($current_value($req)) );

};

# Now we'll define some utility functions

# Grab the HTTP headers from the current request and return them as an array

$get_input_headers = function ($req) {

	return $req->getInputHeaders();

};

# A recursive function to loop through an array of headers and return
# an HTML formatted string

$format_headers = function ($headers, $output = '') use (&$format_headers) {

	# if we've done all the headers, return the $output

	if (!$headers) {

		return $output;

	} else {

		# else grab a header off the top of the array, add it to the
		# $output and recursively call this function on the remaining headers.

		$output .= '<pre>'.array_shift($headers).'</pre>';

		return $format_headers($headers, $output);

	};

};

# Use the function above to format the headers of the current request for
# viewing

$show_headers = function ($req) use ($html_header, $send_content, $format_headers) {

	$html_header($req);

	$send_content($req, $format_headers( $req->getInputHeaders() ) );

};

# Let's handle all requests, so there are no 404's

$default_handler = function ($req) use ($html_header, $send_content) {

	$html_header($req);

	$output = '<h1>This is the default response</h1>';
	
	$output .= '<p>Why not try <a href="/add?value=0&amount=0">some math</a></p>';

	$send_content($req, $output);

};

# Ensure that there are sufficient supplies of cat pictures available
# in all corners of the Internet

$send_cat = function($req) use ($image_header, $send_content) {

	# Note we send a different header so that the browser knows
	# a binary image is coming

 	$image_header($req);

	# An impure function, you could alway use an IO monad or
	# embed the image binary data here!

	$send_content($req, file_get_contents('cat.jpg'));

};

# A function to shut down the web server script by visiting a particular URI.

$close_server = function($req, $base) use ($html_header, $send_content) {

	$html_header($req);

	$send_content($req, '<h1>Server is now shutting down</h1>');

	$base->exit();

};
