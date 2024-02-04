<?php
@include 'config.php';

$response = array('success' => false, 'message' => 'Unable to remove item from wishlist');

if (isset($_GET['productId'])) {
    $productId = $_GET['productId'];
    
    $deleteQuery = "DELETE FROM wishlist WHERE productid = $productId";
    
    if (mysqli_query($conn, $deleteQuery)) {
        $response['success'] = true;
        $response['message'] = 'Item removed successfully';
    } else {
        $response['message'] = 'Error removing item from wishlist: ' . mysqli_error($conn);
    }
    
    mysqli_close($conn);
}

header('Content-Type: application/json');
echo json_encode($response);
?>