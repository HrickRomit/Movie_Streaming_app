<?php
session_start();
require '../config/db.php'; // Database connection

$email = trim($_POST['email']);
$otp   = trim($_POST['otp']);

if (empty($email) || empty($otp)) {
    header("Location: ../pages/login.php?otp=1&email=" . urlencode($email) . "&error=Please+enter+the+OTP");
    exit();
}

// Fetch user with given email and OTP
$query = "SELECT * FROM User WHERE Email = ? AND otp_code = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ss", $email, $otp);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);

    // Check if OTP expired
    if (strtotime($user['otp_expires_at']) > time()) {
        // OTP is valid → log the user in
        $_SESSION['user_id'] = $user['UserID'];
        $_SESSION['username'] = $user['Username'];
        $_SESSION['role'] = $user['Role'];

    // Record last login date and time using Bangladesh Standard Time (UTC+6)
    date_default_timezone_set('Asia/Dhaka');

        // Try to add columns if they don't exist (MySQL 8+ supports IF NOT EXISTS)
        @mysqli_query($conn, "ALTER TABLE User ADD COLUMN IF NOT EXISTS last_login_date DATE");
        @mysqli_query($conn, "ALTER TABLE User ADD COLUMN IF NOT EXISTS last_login_time TIME");

    $last_date = date('Y-m-d');
    $last_time = date('H:i:s');
        $loginUpdate = "UPDATE User SET last_login_date = ?, last_login_time = ? WHERE UserID = ?";
        $loginStmt = mysqli_prepare($conn, $loginUpdate);
        if ($loginStmt) {
            mysqli_stmt_bind_param($loginStmt, "ssi", $last_date, $last_time, $user['UserID']);
            mysqli_stmt_execute($loginStmt);
        }

        // Clear OTP from DB so it can't be reused
        $clear = "UPDATE User SET otp_code = NULL, otp_expires_at = NULL WHERE UserID = ?";
        $clearStmt = mysqli_prepare($conn, $clear);
        mysqli_stmt_bind_param($clearStmt, "i", $user['UserID']);
        mysqli_stmt_execute($clearStmt);

        header("Location: ../pages/index.php");
        exit();
    } else {
        header("Location: ../pages/login.php?otp=1&email=" . urlencode($email) . "&error=OTP+has+expired");
        exit();
    }
} else {
    header("Location: ../pages/login.php?otp=1&email=" . urlencode($email) . "&error=Invalid+OTP");
    exit();
}
