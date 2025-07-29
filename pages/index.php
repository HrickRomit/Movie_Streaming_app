<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Now include the header (navbar is inside it)
include '../includes/header.php';
?>

<!-- Page content -->
<div class="container mt-5">
    <h1>Welcome to MovieDB!</h1>
    <p>You are logged in successfully.</p>
</div>


