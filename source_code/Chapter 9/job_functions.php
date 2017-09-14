<?php

# All functions in this file are the same as in the Parallel example in
# Chapter 5, except for $get_stream and $get_stream_results

# Hadoop splits our input and provides it to each instance of the map job as
# a stream of text. Let's grab that text.

$get_stream = function ($stream) {

	return stream_get_contents( $stream );

};

# Hadoop sends the results from our map jobs (in no particular order) to
# the reduce job as a stream of lines of text. This function reads the
# stream and formats it into an array suitable for our combine_results
# function

$get_stream_results = function ($stream) {

	# Map...

	return array_map(

						# ...json_decode...

						function ($string) { return json_decode($string, true); },

						# ... onto the contents of the stream which have been
						# exploded into an array to make it easier to parse by
						# the following functions

						explode( PHP_EOL , stream_get_contents( $stream ) )

					);

};

# All of the following functions are unchanged from the parallel script

$analyze_words = function ($string) {

	$array = preg_split('/ /i', $string, -1, PREG_SPLIT_NO_EMPTY);

	$filtered = array_filter($array, function ($word)  {

		return (

							preg_match('/[shakespeare]/', $word) != false)

							&& (similar_text($word, 'William is the best bard bar none') > 1)

							&& (metaphone($word) == metaphone('bard'))

							&& ( (strlen($word) > 3 )

						);
	});

	return array_count_values($filtered);

};


$only_letters_and_spaces = function($string) {

	return preg_replace('/[^A-Za-z]+/', ' ', $string);

};

$sort_results = function($array)  {

			asort($array, SORT_NUMERIC);

			return $array;

};

$top_ten = function ($array) {

	return array_slice($array, 0 ,10);

};

$combine_results = function ($results) {

 return	array_reduce($results, function($output, $array) {

			foreach ($array as $word => $count) {

			isset($output[$word]) ?
												$output[$word] += $count  :
												$output[$word] = $count ;
		  }

    return $output;

	}, []);

};

function identity ($value) { return $value; };

function compose(...$functions)
{
    return array_reduce(


        $functions,


		    function ($chain, $function) {

		        return function ($input) use ($chain, $function) {

		            return $function( $chain($input) );

		        };

		    },

		    'identity'

		);
}
