<?php

# Now we're going to create a set of functions which describe our business
# logic. We're going to keep them as simple as possible, and reference
# other functions within this file where possible to keep a
# "single source of truth" for when we need to update them.

# Load our business data

require('business_data.php');

# Fetch the details of a single product from the list of products

$get_product_details = function ($product) use ($products) {

  return  $products()[$product];

};

# Get the category name from the details of a single product

$get_category = function ($product_details)  {

  return $product_details['Category'];

};

# Get the tax rate for a category of products based on the location
# of the purchaser

$get_tax_rate = function ($category, $location) use ($rates) {

  return $rates()[$category][$location];

};

# Get the net (tax exclusive) price of a product by name.

$get_net_price = function ($product) use ($get_product_details) {

  return $get_product_details($product)["Price"];

};

# Roll the above functions together to create a function that gets
# the gross (tax inclusive) price for a certain quantity of products
# based on the location of our purchaser.
# Note that the tax is rounded using the PHP_ROUND_HALF_DOWN constant
# to indicate the particular rounding method.

$get_gross_price = function ($product, $quantity, $location) use
    ($get_net_price, $get_tax_rate, $get_category, $get_product_details)   {

        return round(
                      $get_net_price($product) *
                      $quantity *
                      ( 1 + (
                              $get_tax_rate(
                                $get_category(
                                  $get_product_details($product)
                                ),
                                $location)
                               /100
                             )
                      ),
                      2, PHP_ROUND_HALF_DOWN) ;

};

# A function to get the actual amount of tax charged. Note that this doesn't
# simply use the tax rate, as the actual amount charged may differ depending on
# the rounding performed and any future logic added to $get_gross_price.
# Instead we call $get_net_price and $get_gross_price and return the difference.

$get_tax_charged = function ($product, $quantity, $location) use
                            ($get_gross_price, $get_net_price) {

  return $get_gross_price($product, $quantity, $location) -
          ( $quantity * $get_net_price($product) );

};

# Finally, a function to format a string to display the price, based
# on the purchasers location.

$format_price = function ($price, $location) use ($price_formats) {

  $format = $price_formats()[$location];

  return $format["symbol"] . str_replace('.',
                                         $format["separator"],
                                         (string) $price
                                         );
};
