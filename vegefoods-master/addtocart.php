<?php
@include 'config.php';

session_start();

if(isset($_SESSION['user_id'])) {
   $userid = $_SESSION['user_id'];

   if(isset($_GET['id']) && isset($_GET['quantity']) && isset($_GET['size'])) {
      $productId = $_GET['id'];
      $quantity = $_GET['quantity'];
      $size = $_GET['size'];

      $insertQuery = "INSERT INTO cart (userid, itemid, quantity, size) VALUES ($userid, $productId, $quantity, '$size')";
      $result = mysqli_query($conn, $insertQuery);

      if($result) {
         header("Location: single-product.php?id=$productId&success=1");
         exit();
      } else {
         echo "Error adding item to cart: " . mysqli_error($conn);
      }
   } else {
      echo "Invalid parameters!";
   }
} else {
   echo "User not logged in!";
}
?>