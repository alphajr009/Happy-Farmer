<?php
@include 'config.php';

// Deleting a user
if(isset($_GET['delete'])){
   $uid = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM users WHERE user_id = $uid AND isAdmin = 0");
   header('location:user_mange.php');
}

?>