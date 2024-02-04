<?php
@include 'config.php';

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

   
    $checkQuery = "SELECT * FROM wishlist WHERE productid = $productId";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        header("Location: single-product.php?id=" . $productId . "#");


    } else {
        $insertQuery = "INSERT INTO wishlist (productid) VALUES ($productId)";
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            header("Location: single-product.php?id=" . $productId . "#");


        } else {
            echo "Error adding product to wishlist: " . mysqli_error($conn);
        }
    }
} else {
    echo "Invalid product ID.";
}
?>