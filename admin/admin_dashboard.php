<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: ../includes/admin_auth.php");
    exit();
    
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4 text-center">Welcome, Admin!</h2>
    
    <div class="d-flex flex-column align-items-center">
        <a href="../admin/add_movie.php" class="btn btn-success btn-lg mb-3" style="width: 50%;">Add Movie</a>
        <a href="edit_movie_action.php" class="btn btn-primary btn-lg mb-3" style="width: 50%;">Edit Movie</a>
        <a href="delete_movie.php" class="btn btn-danger btn-lg mb-3" style="width: 50%;">Delete Movie</a>
        <a href="delete_user.php" class="btn btn-warning btn-lg mb-3" style="width: 50%;">Delete User</a>
    </div>
</div>
</body>
</html>
