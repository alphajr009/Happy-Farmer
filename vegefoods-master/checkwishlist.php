<?php
@include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['id'];

    $checkQuery = "SELECT * FROM wishlist WHERE productid = $productId";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo '1';
    } else {
        echo '0'; 
    }
} else {
    echo 'Invalid request';
}
?>