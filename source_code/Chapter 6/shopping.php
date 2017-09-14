<?php

# Import our set of pure functions which encapsulate our business logic.

require('business_logic.php');

# Now we can use them in our not so pure, not so functional code, safe in the
# knowledge that they (should) provide us with consistent, correct results
# regardless of what we do to the global or external state here.

# Let's generate a shopping cart of products for a user in Bolivia

$cart = ['Brie' => 3, 'Shorts' => 1, 'The Dictionary' => 2 ];
$user = ["location" => 'global'];

# One common function is to list the contents of the cart. Let's do
# that here

echo "Your shopping cart contains :\n\n";

echo "Item - Quantity - Net Price Each - Total Price inc. Tax\n";
echo "=======================================================\n\n";

foreach ($cart as $product => $quantity) {

  $net_price = $get_net_price($product);

  $total = $get_gross_price($product, $quantity, $user["location"]);

  echo "$product - $quantity - $net_price - $total \n";

};
echo "=======================================================\n\n";

# In a confirmation e-mail we may want to just list a (formatted) total price...

$total_price = array_reduce(  array_keys($cart),

                  # loop through the cart and add gross price for each item

                  function ($running_total, $product) use
                  ( $user, $get_gross_price, $cart ) {

                      return $running_total +
                             $get_gross_price( $product,
                                              $cart[$product],
                                              $user["location"]);
}, 0);

echo "Thank you for your order.\n";
echo $format_price($total_price, $user["location"]).' will ';
echo "be charged to your card when your order is dispatched.\n\n";

# And on the backend system we may have a routine that keeps details of
# all the tax charged, ready to send to the Government. Let's create a
# summary of the tax for this order.

$tax_summary = array_reduce( array_keys($cart),

    # Loop through each item and add the tax charged to the relevant category

    function ($taxes, $product) use
    ( $user, $get_tax_charged, $cart, $get_category, $get_product_details ) {

          $category = $get_category($get_product_details($product));

          $tax = $get_tax_charged($product, $cart[$product], $user["location"]);

          isset($taxes[$category]) ?
                    $taxes[$category] =+ $tax : $taxes[$category] = $tax;

          return $taxes;

}, []);

echo "Tax Summary for this order :\n\n";

var_dump($tax_summary);
