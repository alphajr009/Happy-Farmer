<?php
@include 'config.php';

session_start();

if(isset($_SESSION['user_id'])) {
    $userid = $_SESSION['user_id'];

    if(isset($_POST['itemid']) && isset($_POST['quantity'])) {
        $itemid = $_POST['itemid'];
        $quantity = $_POST['quantity'];

        $productQuery = "SELECT price FROM products WHERE id IN (SELECT itemid FROM cart WHERE userid = $userid AND itemid = $itemid)";
        $productResult = mysqli_query($conn, $productQuery);

        if ($productResult && $product = mysqli_fetch_assoc($productResult)) {
            $price = $product['price'];
            $total = $price * $quantity;

            $updateQuery = "UPDATE cart SET quantity = $quantity WHERE userid = $userid AND itemid = $itemid";
            $updateResult = mysqli_query($conn, $updateQuery);

            if($updateResult) {
                echo json_encode(array('message' => 'Cart updated successfully!', 'total' => $total));

            } else {
                echo json_encode(array('error' => 'Error updating cart: ' . mysqli_error($conn)));
            }
        } else {
            echo json_encode(array('error' => 'Error retrieving product details: ' . mysqli_error($conn)));
        }
    } else {
        echo json_encode(array('error' => 'Invalid parameters!'));
    }
} else {
    echo json_encode(array('error' => 'User not logged in!'));
}
?>