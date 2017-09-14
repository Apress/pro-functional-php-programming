<?php

# First let's create core business data.

# Rather than just define arrays, we're going to create functions
# that return arrays. We'll discuss why in the chapter.

# Every sale is either local, within our own country, or beyond

$locations = function () {
  return ['local', 'country', 'global'];
};

# Each category of products that we sell has a different tax rate,
# and that rate varies depending on where our purchaser is located

$rates = function () {
  return [
     'clothes' => ['local' => 0, 'country' => 5, 'global' => 10],
     'books' => ['local' => 0, 'country' => 5, 'global' => 5],
     'cheeses' => ['local' => 20, 'country' => 17.5, 'global' =>2]
  ];
};

# A list of our products, with their category and price

$products = function () {
  return [

     'T-shirt' => [ 'Category' => 'clothes', 'Price' => 15.99 ],
     'Shorts'  => ['Category' => 'clothes', 'Price' => 9.99 ],
     'The Dictionary'  => ['Category' => 'books', 'Price' => 4.99 ],
     'War and Peace' => ['Category' => 'books', 'Price' => 29.45 ],
     'Camembert'  => ['Category' => 'cheeses', 'Price' => 3.50 ],
     'Brie' => ['Category' => 'cheeses', 'Price' => 7.00 ]

  ];
};

# We only sell in dollars, but we format the prices differently
# depending on the location of the purchaser.

$price_formats = function () {
  return [
    'local' => ['symbol' => '$', 'separator' => '.'],
    'country' => ['symbol' => '$', 'separator' => '.'],
    'global' => ['symbol' => 'USD ', 'separator' => ',']
  ];
};
