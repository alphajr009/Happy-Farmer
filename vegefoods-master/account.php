<?php
session_start();
require_once 'config.php';

$accountLink = '';
$loginRegisterLinks = '';

$userId = $_SESSION['user_id'];


$query = "SELECT * FROM users WHERE user_id = '$userId'";
$result = mysqli_query($conn, $query);

if ($result) {
    $userDetails = mysqli_fetch_assoc($result);
}

$cartQuery = "SELECT SUM(quantity) AS totalQuantity FROM cart WHERE userid = '$userId'";
$cartResult = mysqli_query($conn, $cartQuery);

if ($cartResult) {
    $cartItemCount = (int) mysqli_fetch_assoc($cartResult)['totalQuantity'];
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user) {
        header("Location: error.php");
        exit();
    }

    $accountLink = '<li class="nav-item"><a href="account.php" class="nav-link">Account</a></li>';
    $loginRegisterLinks = '<li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>';
} else {
    $loginRegisterLinks = '
        <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
        <li class="nav-item"><a href="registration.php" class="nav-link">Register</a></li>
    ';
    header("Location: login.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Happy farmer Web application</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/customalpha.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">


    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
    .btn-disabled-hover:hover {
        background-color: #3498db !important;
        border-color: #3498db !important;
        color: #fff !important;
        background: #82ae52 !important;
        cursor: not-allowed;



    }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var nameInput = document.getElementById("nameInput");
        var emailInput = document.getElementById("emailInput");
        var mobileInput = document.getElementById("mobileInput");
        var addressInput = document.getElementById("addressInput");
        var postcodeInput = document.getElementById("postcodeInput");
        var provinceInput = document.getElementById("provinceInput");
        var editProfileBtn = document.getElementById("editProfileBtn");
        var saveProfileBtn = document.getElementById("saveProfileBtn");

        saveProfileBtn.disabled = true;


        nameInput.disabled = true;
        emailInput.disabled = true;
        mobileInput.disabled = true;
        addressInput.disabled = true;
        postcodeInput.disabled = true;
        provinceInput.disabled = true;

        editProfileBtn.addEventListener("click", function() {
            nameInput.disabled = !nameInput.disabled;
            emailInput.disabled = !emailInput.disabled;
            mobileInput.disabled = !mobileInput.disabled;
            addressInput.disabled = !addressInput.disabled;
            postcodeInput.disabled = !postcodeInput.disabled;
            provinceInput.disabled = !provinceInput.disabled;

            saveProfileBtn.disabled = false;

            saveProfileBtn.classList.add("btn-disabled-hover");




        });
    });
    </script>
</head>

<body class="goto-here">
    <div class="py-1 bg-primary">
        <div class="container">
            <div class="row no-gutters d-flex align-items-start align-items-center px-md-0">
                <div class="col-lg-12 d-block">
                    <div class="row d-flex">
                        <div class="col-md pr-4 d-flex topper align-items-center">
                            <div class="icon mr-2 d-flex justify-content-center align-items-center"><span
                                    class="icon-phone2"></span></div>
                            <span class="text">0523536868</span>
                        </div>
                        <div class="col-md pr-4 d-flex topper align-items-center">
                            <div class="icon mr-2 d-flex justify-content-center Right-items-center"><span
                                    class="icon-paper-plane"></span></div>
                            <span class="text"></span>
                        </div>
                        <div class="col-md-5 pr-4 d-flex topper align-items-center text-lg-right">
                            <span class="text">happyfarmer@gmail.com</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php">HAPPY FARMER</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active"><a href="index.php" class="nav-link">Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">Shop</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown04">
                            <a class="dropdown-item" href="Vegetables.php">Shop</a>
                            <a class="dropdown-item" href="wishlist.php">Wishlist</a>
                            <a class="dropdown-item" href="cart.php">Cart</a>
                        </div>
                    </li>
                    <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
                    <li class="nav-item"><a href="blog.php" class="nav-link">News</a></li>
                    <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
                    <?php echo $accountLink; ?>
                    <?php echo $loginRegisterLinks; ?>
                    <li class="nav-item cta cta-colored"><a href="cart.php" class="nav-link"><span
                                class="icon-shopping_cart"></span>[<?php echo $cartItemCount; ?>]</a></li>


                </ul>
            </div>
        </div>
    </nav>

    <div class="profile-info">
        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img
                            class="rounded-circle mt-5" width="150px"
                            src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span
                            class="font-weight-bold"><?= $user['name'] ?? '' ?></span><span
                            class="text-black-50"><?= $user['email'] ?? '' ?></span><span> </span></div>
                </div>
                <div class="col-md-5 border-right">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Profile Settings</h4>
                        </div>

                        <div class="row mt-3">
                            <form method="post" action="update_profile.php">
                                <div class="col-md-12">
                                    <label class="labels">Name</label>
                                    <input id="nameInput" name="name" type="text" class="form-control"
                                        placeholder="name" value="<?= $user['name'] ?? '' ?>">
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">Email ID</label>
                                    <input id="emailInput" name="email" type="text" class="form-control"
                                        placeholder="enter email id" value="<?= $user['email'] ?? '' ?>">
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">Mobile Number</label>
                                    <input id="mobileInput" name="mobile" type="text" class="form-control"
                                        placeholder="enter phone number" value="<?= $user['mobile'] ?? '' ?>">
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">Address Line</label>
                                    <input id="addressInput" name="address" type="text" class="form-control"
                                        placeholder="enter address line " value="<?= $user['address'] ?? '' ?>">
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">Postcode</label>
                                    <input id="postcodeInput" name="postcode" type="text" class="form-control"
                                        placeholder="enter postcode" value="<?= $user['postcode'] ?? '' ?>">
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">Province</label>
                                    <input id="provinceInput" name="province" type="text" class="form-control"
                                        placeholder="enter province" value="<?= $user['province'] ?? '' ?>">
                                </div>
                        </div>

                        <div class="mt-5 text-center">
                            <button id="editProfileBtn" class="btn btn-primary profile-button" type="button">Edit
                                Profile</button>

                            <button id="saveProfileBtn" name="save_profile"
                                class="btn btn-primary profile-button btn-disabled-hover" type="submit">Save
                                Profile</button>

                        </div>

                        </form>


                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 py-5">
                        <form method="post" action="edit_password.php">
                            <div class="d-flex justify-content-between align-items-center experience"><span>Edit
                                    Password</span></div><br>
                            <div class="col-md-12"><label class="labels">Current Password</label><input type="password"
                                    class="form-control" placeholder="enter current password" value=""
                                    name="current_password" required></div> <br>
                            <div class="col-md-12"><label class="labels">New Password</label><input type="password"
                                    class="form-control" placeholder="enter new password" value="" name="new_password"
                                    required></div><br>
                            <div class="col-md-12"><label class="labels">Confirm New Password</label><input
                                    type="password" class="form-control" placeholder="confirm new password" value=""
                                    name="confirm_new_password" required></div>

                            <br>
                            <?php if (isset($_SESSION['success'])): ?>
                            <div class="mt-3 text-center">
                                <div style="color: green;"><?php echo $_SESSION['success']; ?></div>
                            </div>
                            <?php unset($_SESSION['success']); ?>
                            <?php endif; ?>

                            <?php if (isset($_SESSION['error'])): ?>
                            <div class="mt-3 text-center">
                                <div style="color: red;"><?php echo $_SESSION['error']; ?></div>
                            </div>
                            <?php unset($_SESSION['error']); ?>
                            <?php endif; ?>

                            <div class="mt-5 text-center"><button class="btn btn-primary profile-button"
                                    type="submit">Change
                                    Password</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    </div>



</body>

</html>