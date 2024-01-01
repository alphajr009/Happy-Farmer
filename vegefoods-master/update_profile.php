<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_profile'])) {

    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $current_user = $result->fetch_assoc();
    $stmt->close();

    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $postcode = $_POST['postcode'];
    $province = $_POST['province'];

    if ($email !== $current_user['email']) {

        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ? AND user_id <> ?");
        $stmt->bind_param("si", $email, $user_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email already exists";
            $stmt->close();
        }
    }

    if (!isset($error)) {
        $stmt = $conn->prepare("UPDATE users SET name=?, email=?, mobile=?, address=?, postcode=?, province=? WHERE user_id = ?");
        $stmt->bind_param("ssssssi", $name, $email, $mobile, $address, $postcode, $province, $user_id);
        $stmt->execute();
        $stmt->close();

        header("Location: account.php");
        exit();
    }
}


header("Location: account.php");
exit();
?>