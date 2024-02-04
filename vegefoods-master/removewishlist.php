<?php
@include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['id'];

    $removeQuery = "DELETE FROM wishlist WHERE productid = $productId";
    $removeResult = mysqli_query($conn, $removeQuery);

    if ($removeResult) {
        header("Location: single-product.php?id=" . $productId . "#");
    } else {
        header("Location: single-product.php?id=" . $productId . "#");
    }
} else {
    header("Location: single-product.php#");
}
?>