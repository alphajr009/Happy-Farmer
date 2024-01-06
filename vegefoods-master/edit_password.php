<?php
session_start();
require_once 'config.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmNewPassword = $_POST['confirm_new_password'];

        $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        // Debugging statements
        echo "Current Password (entered): $currentPassword<br>";
        echo "Password (from database): " . $user['password'] . "<br>";

        if (!$user) {
            $_SESSION['error'] = "User not found.";
        } elseif ($currentPassword != $user['password']) {
            $_SESSION['error'] = "Current password is incorrect.";
        } elseif ($newPassword != $confirmNewPassword) {
            $_SESSION['error'] = "New password and confirm new password do not match.";
        } else {
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
            $stmt->bind_param("si", $newPassword, $user_id);
            $stmt->execute();
            $stmt->close();

            // Set success message
            $_SESSION['success'] = "Password updated successfully!";
        }
    }
} else {
    $_SESSION['error'] = "User not authenticated.";
}

header("Location: account.php");
exit();
?>