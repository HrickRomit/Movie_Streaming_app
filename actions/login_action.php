<?php
session_start();
require '../config/db.php'; // Database connection

$emailOrMobile = trim($_POST['email']); // Can be email or mobile number
$password = $_POST['password'];

// Basic validation
if (empty($emailOrMobile) || empty($password)) {
    header("Location: ../pages/login.php?error=Please+fill+in+all+fields");
    exit();
}

// Check if user exists by email or mobile number
$query = "SELECT * FROM User WHERE Email = '$emailOrMobile'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);

    if ($user['Password'] === $password) {  // No hashing used, as you requested
        // Set session variables
        $_SESSION['user_id'] = $user['UserID'];
        $_SESSION['username'] = $user['Username'];
        $_SESSION['role'] = $user['Role']; // Optional: Useful if admin/user differentiation is needed

        header("Location: ../pages/index.php");
        exit();
    } else {
        header("Location: ../pages/login.php?error=Incorrect+password");
        exit();
    }
} else {
    header("Location: ../pages/login.php?error=User+not+found");
    exit();
}
