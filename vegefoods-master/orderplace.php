<?php
session_start();
@include 'config.php';

if (isset($_SESSION['user_id'])) {

    $userId = $_SESSION['user_id'];

    $query = "SELECT * FROM users WHERE user_id = '$userId'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $userDetails = mysqli_fetch_assoc($result);
    }

    $cartQuery = "SELECT * FROM cart WHERE userid = '$userId'";
    $cartResult = mysqli_query($conn, $cartQuery);

    $subtotal = 0;

    if ($cartResult) {
        while ($cartItem = mysqli_fetch_assoc($cartResult)) {
            $quantity = $cartItem['quantity'];
            $newPrice = $cartItem['newprice'];

            $itemSubtotal = $quantity * $newPrice;

            $subtotal += $itemSubtotal;
        }
    }

    $deliveryCharge = 400;
    $total = $subtotal + $deliveryCharge;

    $name = $userDetails['name'];
    $address = $userDetails['address'];
    $province = $userDetails['province'];
    $postcode = $userDetails['postcode'];
    $phone = $userDetails['mobile'];
    $email = $userDetails['email'];

    $orderItems = array();

    $cartQuery2 = "SELECT * FROM cart WHERE userid = '$userId'";
    $cartResult2 = mysqli_query($conn, $cartQuery2);

    if ($cartResult2) {
        while ($cartItem = mysqli_fetch_assoc($cartResult2)) {
            $itemDetails = array(
                'itemid' => $cartItem['itemid'],
                'quantity' => $cartItem['quantity'],
                'size' => $cartItem['size'],
                'newprice' => $cartItem['newprice']
            );
            $orderItems[] = $itemDetails;
        }
    }

    $orderItemsJSON = json_encode($orderItems);

    $insertOrderQuery = "INSERT INTO order_details (user_id, name, address, province, postcode, phone, email,  total_amount, order_items) 
                        VALUES ('$userId', '$name', '$address', '$province', '$postcode', '$phone', '$email', '$total', '$orderItemsJSON')";

    $insertOrderResult = mysqli_query($conn, $insertOrderQuery);

    if ($insertOrderResult) {
        $orderid = mysqli_insert_id($conn);
        $clearCartQuery = "DELETE FROM cart WHERE userid = '$userId'";
        mysqli_query($conn, $clearCartQuery);

        header('Location: orderinvoice.php?orderid=' . $orderid);

        exit();
    } else {
        echo "Error placing the order.";
    }
} else {
    header('Location: login.php');
    exit();
}

mysqli_close($conn);
?>