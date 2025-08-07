<?php
session_start();
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['movie_id'];
    $name = $_POST['name'];
    $genre = $_POST['genre'];
    $year = $_POST['year'];
    $description = $_POST['description'];

    // Handle thumbnail upload (optional)
    $thumbnail = null;
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        $filename = basename($_FILES['thumbnail']['name']);
        $targetPath = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $targetPath)) {
            $thumbnail = $filename;
        }
    }

    // SQL update logic
    if ($thumbnail) {
        $sql = "UPDATE movies SET MovieName=?, GenreID=?, ReleaseYear=?, Description=?, Thumbnail=? WHERE MovieID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssissi", $name, $genre, $year, $description, $thumbnail, $id);
    } else {
        $sql = "UPDATE movies SET MovieName=?, GenreID=?, ReleaseYear=?, Description=? WHERE MovieID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisi", $name, $genre, $year, $description, $id);
    }

    if ($stmt->execute()) {
        header("Location: ../admin/admin_dashboard.php?updated=true");
    } else {
        echo "Error updating movie: " . $stmt->error;
    }
}
?>
