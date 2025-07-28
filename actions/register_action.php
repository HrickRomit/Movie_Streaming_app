<?php
require '../config/db.php'; // Make sure this connects to your MySQL

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];

// 1. Basic validation
if (empty($username) || empty($email) || empty($password)) {
    header("Location: ../pages/register.php?error=Please+fill+all+fields");
    exit();
}

// 2. Check if user already exists
$check_query = "SELECT * FROM User WHERE Username = '$username' OR Email = '$email'";
$check_result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($check_result) > 0) {
    header("Location: ../pages/register.php?error=Username+or+email+already+exists");
    exit();
}

// 3. Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// 4. Insert into database
$insert_query = "INSERT INTO User (Username, Email, Password) VALUES ('$username', '$email', '$hashedPassword')";

if (mysqli_query($conn, $insert_query)) {
    header("Location: ../pages/login.php?success=registered");
    exit();
} else {
    header("Location: ../pages/register.php?error=Registration+failed");
    exit();
}
