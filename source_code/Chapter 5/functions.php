<?php

# Borrow some utility functions from previous examples

require('../Chapter 3/compose.php');
require('repeat.php');


# To simplify our analysis, replace anything that's not
# a letter with a space.

$only_letters_and_spaces = function($string) {

	return preg_replace('/[^A-Za-z]+/', ' ', $string);

};

# This is the "expensive" deliberately un-optimized function
# that does our "analysis".

$analyze_words = function ($string) {

	# Split our text into an array, one word per element

	$array = preg_split('/ /i', $string, -1, PREG_SPLIT_NO_EMPTY);

	# Filter our array for words that...

	$filtered = array_filter($array, function ($word)  {

		return (

							# ... contain any of the letters from the word shakespeare

							preg_match('/[shakespeare]/', $word) != false)

							# ... AND has at least 1 character in common with this sentence

							&& (similar_text($word, 'William is the best bard bar none') > 1)

							# ... AND sound like the word "bard"

							&& (metaphone($word) == metaphone('bard'))

							# ... AND have more than three characters in them

							&& ( (strlen($word) > 3 )

						);
	});

	# Finally, count up the number of times each of the filtered
	# words appears in the analyzed text, and return that

	 return array_count_values($filtered);

};


# Slice the top 10 items off the top of the array

$top_ten = function ($array) {

	return array_slice($array, 0 ,10);

};

# Sort the results numerically

# asort mutates the array, so we wrap it in a function

$sort_results = function($array)  {

			asort($array, SORT_NUMERIC);

			return $array;

};

# The following functions manage the execution of parallel client scripts

# A function to split the text into chunks and launch the
# appropriate number of clients to process it

$launch_clients = function ($string) {

		# Split the string into chunks of 1 million characters,
		# a value which I found by trial and error to give the
		# best results on this machine for this process

		$strings = str_split($string, 1000000);

		# An array to hold the resource identifiers for the client scripts

		$clients = [];

		# Descriptors for "pipes" to read/write the data to/from our client
		# scripts

		$descriptors = [
   											0 => ["pipe", "r"], #STDIN, to get data
   											1 => ["pipe", "w"]  #STDOUT, to send data
								  	];

		# Iterate through the chunks...

		foreach ($strings as $key => $string) {

			# $key will be the array index, 0, 1, 2, 3... etc.
			# We'll use it as a handy way to number our clients

			# Define the command that runs the client

			$command = "php client.php";

			# Open the clients with proc_open. This returns a resource identifier.
			# We'll store it, although our script won't actually use it.

			$clients[$key]["resource"] = proc_open( $command,
			 																				$descriptors,
																							$clients[$key]["pipes"]
																						);
			# Note the third parameter above is a variable passed by reference.
			# This is used by proc_open to store an array of file pointers
			# identifying PHP's end of the pipes that are created.

			# We use that info here to write our text chunk to. This writes
			# it to STDOUT, and our client script reads it in through STDIN
			# at its end of the pipe.

			fwrite($clients[$key]["pipes"][0], $string);

			# Close the pipe now we're done writing to this client.

    	fclose($clients[$key]["pipes"][0]);


		};

		# Once all of the clients have been launched, return their
		# resource identifiers and pipe details

		return $clients;
};

# Simple impure function to report how many clients were
# launched. You could use a writer monad instead if you wanted

$report_clients = function ($clients) {

	# The escape code at the end minimizes our output when
	# when running the script many times, by going up one line
	# and overwriting the output each time.

	echo("Launched ".sizeof($clients)." clients\n\033[1A");

	return $clients;

};

# A function to get the results back from the clients.
# The clients will send a JSON encoded array back to us

$get_results = function ($clients) {

	# An array to gather the results. Each clients' result
	# will be stored as an element of the array

	$results = [];

	# Iterate through the client resource identifiers

	foreach ($clients as $key => $client) {

				# Clients write output to STDOUT, which corresponds to the
				# STDIN Pipe at our end. We'll read that JSON data and
				# decode it to a PHP array. Each client's results will be
				# stored as a separate element of the $results array.

				$results[] = json_decode(

																stream_get_contents($client["pipes"][1]),

																true);

				# We've done reading from the client, so we can close the pipe.

				fclose($clients[$key]["pipes"][1]);

			};

			# And finally return all of the results from all of the clients

			return $results;

};

# This function takes the results array from $get_results above and
# combines it into a single array

$combine_results = function ($results) {

# Reduce and return the input array by...

 return	array_reduce($results, function($output, $array) {

	 	#... iterating over each individual clients results array
		# and either creating or adding the count for each word to
		# the output depending on whether that word already exists in
		# the output

		foreach ($array as $word => $count) {

			isset($output[$word]) ?
												$output[$word] += $count  :
												$output[$word] = $count ;
		  }

		# return $output through to the next iteration of array_reduce

    return $output;

	}, []); # starting with a blank array [] as output

};
