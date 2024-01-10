<?php
@include 'config.php';

session_start();

if (isset($_SESSION['user_id']) && isset($_POST['cart_id'])) {
    $userid = $_SESSION['user_id'];
    $cart_id = $_POST['cart_id'];

    $deleteQuery = "DELETE FROM cart WHERE userid = $userid AND cart_id = $cart_id";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        $response = array('success' => true, 'message' => 'Item removed from cart successfully');
        echo json_encode($response);
    } else {
        $response = array('success' => false, 'message' => 'Error removing item from cart: ' . mysqli_error($conn));
        echo json_encode($response);
    }
} else {
    $response = array('success' => false, 'message' => 'Invalid parameters');
    echo json_encode($response);
}
?>