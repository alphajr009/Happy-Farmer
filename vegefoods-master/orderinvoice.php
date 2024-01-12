<?php
include 'config.php';


function sanitizeInput($input) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars($input));
}


if (isset($_GET['orderid'])) {
    $orderId = sanitizeInput($_GET['orderid']);

    
    $orderDetailsQuery = "SELECT * FROM order_details WHERE order_id = '$orderId'";
    $orderDetailsResult = mysqli_query($conn, $orderDetailsQuery);

    if ($orderDetailsResult) {
        $orderDetails = mysqli_fetch_assoc($orderDetailsResult);

        $userId = sanitizeInput($orderDetails['user_id']);
        $userDetailsQuery = "SELECT * FROM users WHERE user_id = '$userId'";
        $userDetailsResult = mysqli_query($conn, $userDetailsQuery);

        if ($userDetailsResult) {
            $userDetails = mysqli_fetch_assoc($userDetailsResult);

            $orderItemsJSON = $orderDetails['order_items'];
            $orderItems = json_decode($orderItemsJSON, true);

            echo '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Happy Farmer</title>
                    <link rel="stylesheet" href="css/styleinvoice.css">
                </head>
                <body>
                    <div class="container">
                        <div class="brand-section">
                            <div class="row">
                                <div class="col-6">
                                    <h1 class="text-white">HAPPY FARMER</h1>
                                </div>
                                <div class="col-6">
                                    <div class="company-details">
                                        <p class="text-white">Maligathena Farming Udawela,</p>
                                        <p class="text-white">Mandaramnuwara,NuwaraEliya.</p>
                                        <p class="text-white">+94 0523536868</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="body-section">
                            <div class="row">
                                <div class="col-6">
                                    <h2 class="heading">Invoice No : ' . $orderId . '</h2>
                                    <p class="sub-heading">Order Date: ' . $orderDetails['order_date'] . '</p>
                                    <p class="sub-heading">Email Address: ' . $userDetails['email'] . '</p>
                                </div>
                                <div class="col-6">
                                    <p class="sub-heading">Name: ' . $userDetails['name'] . '</p>
                                    <p class="sub-heading">Address: ' . $userDetails['address'] . '</p>
                                    <p class="sub-heading">Phone Number: ' . $userDetails['mobile'] . '</p>
                                    <p class="sub-heading">Province, Postcode: ' . $userDetails['province'] . ', ' . $userDetails['postcode'] . '</p>
                                </div>
                            </div>
                        </div>

                        <div class="body-section">
                            <h3 class="heading">Ordered Items</h3>
                            <br>
                            <table class="table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Size</th>
                                        <th class="w-20">Price</th>
                                        <th class="w-20">Quantity</th>
                                        <th class="w-20">Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>';

            foreach ($orderItems as $item) {
                $productId = sanitizeInput($item['itemid']);
                $productDetailsQuery = "SELECT * FROM products WHERE id = '$productId'";
                $productDetailsResult = mysqli_query($conn, $productDetailsQuery);

                if ($productDetailsResult) {
                    $productDetails = mysqli_fetch_assoc($productDetailsResult);

                    echo '<tr>
                            <td>' . $productDetails['name'] . '</td>
                            <td>' . $item['size'] . '</td>
                            <td>' . $item['newprice'] . '</td>
                            <td>' . $item['quantity'] . '</td>
                            <td>' . ($item['newprice'] * $item['quantity']) . '</td>
                        </tr>';
                }
            }

            echo '</tbody>
                    </table>
                    <br>
                    <div class="align-right">
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-9 text-right">Sub Total &nbsp; &nbsp;:</div>
                            <div class="col-3" style="margin-left: 15px;">Rs. ' . $orderDetails['total_amount']-400 . '</div>
                        </div>
                        <div class="row" style="margin-bottom: 10px;">
                        <div class="col-9 text-right">Delivery &nbsp; &nbsp; &nbsp;:</div>
                        <div class="col-3" style="margin-left: 15px;">Rs.400</div>
                    </div>
    
                    <div class="row">
                        <div class="col-9 text-right">TOTAL &nbsp; &nbsp; &nbsp;&nbsp;:</div>
                        <div class="col-3" style="margin-left: 15px;">Rs. ' . $orderDetails['total_amount'] . '</div>
                    </div>
                    </div>
                    <br>
            <h3 class="heading">Payment Status: Paid</h3>
            <h3 class="heading">Payment Mode: Online Card Payment</h3>
            
                </div>
                <div class="body-section">
                <p>&copy; Copyright 2023 - Happy Farmer. All rights reserved.
                    <a href="https://www.fundaofwebit.com/" class="float-right">www.happyfarmer.com</a>
                </p>
          
                </div>
                </body>

                <div class="center">
                <form action="index.php" method="get">
                    <button type="submit" class="buttongo">Go to Home</button>
                </form>
            </div>

              
                
            
            
                </html>';
        }
    }
}

mysqli_close($conn);
?>