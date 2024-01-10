<?php
@include 'config.php';

session_start();

if(isset($_SESSION['user_id'])) {
    $userid = $_SESSION['user_id'];

    if(isset($_GET['id']) && isset($_GET['quantity']) && isset($_GET['size'])) {
        $productId = $_GET['id'];
        $quantity = $_GET['quantity'];
        $size = $_GET['size'];

        $multiplierMap = [
            '0.5' => 1,
            '1' => 2,
            '2' => 4,
            '5' => 10,
        ];
        if(isset($multiplierMap[$size])){
            $multiplier = $multiplierMap[$size];

            $originalPriceQuery = "SELECT price FROM products WHERE id = '$productId'";
            $originalPriceResult = mysqli_query($conn, $originalPriceQuery);

            if ($originalPriceResult) {
                $originalPriceData = mysqli_fetch_assoc($originalPriceResult);
                $originalPrice = $originalPriceData['price'];
                $newPrice = $originalPrice * $multiplier;

                $insertQuery = "INSERT INTO cart (userid, itemid, quantity, size, newprice) VALUES ($userid, $productId, $quantity, '$size', $newPrice)";
                $result = mysqli_query($conn, $insertQuery);

                if ($result) {
                    header("Location: single-product.php?id=$productId&success=1");
                    exit();
                } else {
                    echo "Error adding item to cart: " . mysqli_error($conn);
                }
            } else {
                echo "Error fetching original price: " . mysqli_error($conn);
            }
        } else {
            echo "Invalid size!";
        }
    } else {
        echo "Invalid parameters!";
    }
} else {
    echo "User not logged in!";
}
?>