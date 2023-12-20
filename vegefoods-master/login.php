<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, ($_POST['password']));

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){

      $row = mysqli_fetch_assoc($select_users);

      if($row['isAdmin'] == 0){

         $_SESSION['user_id'] = $row['user_id'];
         header('location:index.php');

      }elseif($row['isAdmin'] == 1){

         $_SESSION['user_id'] = $row['user_id'];
         header('Location: ../admin_panal/dashboard.php');
exit();


      }
      
   }else{
      $message[] = 'incorrect email or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background: #fff;
    overflow: hidden;
}

::selection {
    background: #fff;
}

.container {
    max-width: 440px;
    padding: 0 20px;
    margin: 100px auto;
}

.wrapper {
    width: 100%;
    background: #fff;
    border-radius: 5px;
    box-shadow: 0px 4px 10px 1px rgba(0, 0, 0, 0.1);

}

.wrapper .title {
    height: 90px;
    background: #87c83d;
    border-radius: 5px 5px 0 0;
    color: #fff;
    font-size: 30px;
    font-weight: 400;
    display: flex;
    align-items: center;
    justify-content: center;
}

.wrapper form {
    padding: 30px 25px 25px 25px;
}

.wrapper form .row {
    height: 45px;
    margin-bottom: 15px;
    position: relative;
}

.wrapper form .row input {
    height: 100%;
    width: 100%;
    outline: none;
    padding-left: 60px;
    border-radius: 5px;
    border: 1px solid lightgrey;
    font-size: 16px;
    transition: all 0.3s ease;
}

form .row input:focus {
    border-color: #16a085;
    box-shadow: inset 0px 0px 2px 2px rgba(26, 188, 156, 0.25);
}

form .row input::placeholder {
    color: #999;
}

.wrapper form .row i {
    position: absolute;
    width: 47px;
    height: 100%;
    color: black;
    font-size: 18px;
    background: #fff;
    border: 1px solid #16a085;
    border-radius: 5px 0 0 5px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.wrapper form .pass {
    margin: -8px 0 20px 0;
}

.wrapper form .pass a {
    color: #16a085;
    font-size: 17px;
    text-decoration: none;
}

.wrapper form .pass a:hover {
    text-decoration: underline;
}

.wrapper form .button input {
    color: #fff;
    font-size: 20px;
    font-weight: 500;
    padding-left: 0px;
    background: #9fac90;
    border: 1px solid #16a085;
    cursor: pointer;
}

form .button input:hover {
    background: #2e6da4;
}

.wrapper form .signup-link {
    text-align: center;
    margin-top: 20px;
    font-size: 17px;
}

.wrapper form .signup-link a {
    color: #16a085;
    text-decoration: none;
}

form .signup-link a:hover {
    text-decoration: underline;
}

.wrapper form .box {
    color: black;
    width: 350px;
    font-size: 18px;
    background: #fff;
    border: 1px solid #16a085;
    border-radius: 5px 5px 5px 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px;
}

.wrapper form .home-link a {
    color: black;
    text-decoration: none;
}

form .home-link a:hover {
    text-decoration: none;
    color: #c12e2a;
}
</style>

<body>

    <?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

    <div class="form-container">
        <div class="container">
            <div class="wrapper">
                <div class="title"><span>Log in</span></div>

                <form action="" method="post">
                    <div class="row">
                        <i class="fa-solid fa-envelope"></i>

                        <input type="email" name="email" placeholder="Your email is here" required class="box">
                    </div>

                    <div class="row">
                        <i class="fas fa-lock"></i>

                        <input type="password" name="password" placeholder="Your password is here" required class="box">

                    </div>

                    <div class="row button">
                        <input type="submit" name="submit" value="login now" class="btn">
                    </div>

                    <div class="signup-link">
                        <p>don't have an account? <a href="registration.php">register now</a></p>
                    </div>
                    <div class="home-link"><a href="index.php">Back</a></div>
                </form>

            </div>

</body>

</html>