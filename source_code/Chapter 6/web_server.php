<?php

# Let's get all of our functions that implement our
# business logic

require('server_functions.php');

# Now we're ready to build up our event framework

# First we create an "EventBase", which is libevent's vehicle for holding
# and polling a set of events.

$base = new EventBase();

# Then we add an EventHttp object to the base, which is the Event
# extension's helper for HTTP connections/events.

$http = new EventHttp($base);

# We'll choose to respond to just GET  HTTP requests

$http->setAllowedMethods( EventHttpRequest::CMD_GET );

# Next we'll tie our functions we created above to specific URIs using
# function callbacks. We've created them all as anonymous/closure functions
# and so we just bind the variable holding them to the URI. We
# could use named functions if we want, suppling the name in "quotes".
# In fact, you can use any kind of callable here. All will be called
# with the EventHttpRequest object representing the current request as
# the first paramter. If you need other parameters here for your callback,
# you can specify them as an optional third parameter below.

# Our set of maths functions...

$http->setCallback("/add", $add);

$http->setCallback("/subtract", $subtract);

$http->setCallback("/multiply", $multiply);

$http->setCallback("/divide", $divide);

$http->setCallback("/floor", $floor);

# A function to shut down the server, which needs access to the server $base

$http->setCallback("/close_server", $close_server, $base);

# A utility function to explore the headers your browser is sending

$http->setCallback("/show_headers", $show_headers);

# And a compulsory function for all internet connected devices

$http->setCallback("/really/cute", $send_cat);


# Finally we'll add a default function callback to handle all other URIs.
# You could, in fact, just specify this default handler and not those
# above, and then handle URIs as you wish from inside this function using
# it as a router function.

$http->setDefaultCallback($default_handler);

# We'll bind our script to an address and port to enable it to listen for
# connections. In this case, 0.0.0.0 will bind it to the localhost, and
# we'll choose port 12345

$http->bind("0.0.0.0", 12345);

# Then we start our event loop using the loop() function of our base. Our
# script will remain in this loop indefinitely, servicing http requests
# with the functions above, until we exit it by killing the script or,
# more ideally, calling $base->exit() as we do in the close_server()
# function above.

$base->loop();

# We'll only hit this point in the script if some code has called
# $base->exit();

echo "Server has been gracefully closed\n";
