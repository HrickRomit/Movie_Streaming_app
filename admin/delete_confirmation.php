<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: ../includes/admin_auth.php");
    exit();
}

include '../config/db.php';

if (!isset($_GET['id'])) {
    echo "Movie ID not provided.";
    exit();
}

$movieID = $_GET['id'];

$query = "DELETE FROM movies WHERE MovieID = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $movieID);

if (mysqli_stmt_execute($stmt)) {
    header("Location: admin_dashboard.php?message=deleted");
    exit();
} else {
    echo "Error deleting movie: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
?>
