<?php
session_start();

require __DIR__ . "/vendor/autoload.php";
include 'config.php'; 

$stripe_secret_key = "sk_test_51OXG0DHvmpzzkeNycpzDkhosUr8Rcjciy3ZQZYWYEZ5ZH2gEsBMuu5Ra9sAjOrGqluQ5oDeC6R4fiECCyVPNZbAs009frNnzmy";

\Stripe\Stripe::setApiKey($stripe_secret_key);

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM cart WHERE userid = '$user_id'";
$result = mysqli_query($conn, $query);

$line_items = [];

while ($row = mysqli_fetch_assoc($result)) {
    $item_id = $row['itemid'];
    $item_query = "SELECT * FROM products WHERE id = '$item_id'";
    $item_result = mysqli_query($conn, $item_query);
    $item_details = mysqli_fetch_assoc($item_result);

    $line_items[] = [
        "quantity" => $row['quantity'],
        "price_data" => [
            "currency" => "lkr",
            "unit_amount" => $row['newprice'] * 100,
            "product_data" => [
                "name" => $item_details['name']
            ]
        ]
    ];
}

$checkout_session = \Stripe\Checkout\Session::create([
    "mode" => "payment",
    "success_url" => "http://localhost/happyfarm/vegefoods-master/orderplace.php",
    "cancel_url" => "http://localhost/happyfarm/vegefoods-master/errorpay.php",
    "locale" => "auto",
    'shipping_options' => [
        [
          'shipping_rate_data' => [
            'type' => 'fixed_amount',
            'fixed_amount' => [
              'amount' => 40000,
              'currency' => 'lkr',
            ],
            'display_name' => 'Delivery Fees',
            'delivery_estimate' => [
              'minimum' => [
                'unit' => 'business_day',
                'value' => 2,
              ],
              'maximum' => [
                'unit' => 'business_day',
                'value' => 3,
              ],
            ],
          ],
        ]
      ],
    "line_items" => $line_items 
]);

http_response_code(303);
header("Location: " . $checkout_session->url);
?>