<?php
session_start(); // Start session to access login data
include '../config/db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $language = $_POST['language'];
    $year = $_POST['year'];
    $description = $_POST['description'];
    $thumbnail = $_POST['thumbnail'];
    $genre = $_POST['genre'];

    // Check if the movie already exists (by name and year)
    $check_query = "SELECT * FROM movies WHERE MovieName = ? AND ReleaseYear = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("si", $name, $year);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Redirect back with error message
        header("Location: ../admin/add_movie.php?error=" . urlencode("Movie already exists."));
        exit();
    }

    // Proceed to insert the new movie
    $insert_sql = "INSERT INTO movies (MovieName, MovieLanguage, ReleaseYear, Description, Thumbnail, GenreID)
                   VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);

    if (!$stmt) {
        header("Location: ../admin/add_movie.php?error=" . urlencode("SQL preparation failed: " . $conn->error));
        exit();
    }

    $stmt->bind_param("ssissi", $name, $language, $year, $description, $thumbnail, $genre);

    if ($stmt->execute()) {
        header("Location: ../admin/add_movie.php?success=1");
        exit();
    } else {
        header("Location: ../admin/add_movie.php?error=" . urlencode("Insert failed: " . $stmt->error));
        exit();
    }
}

// Fallback
header("Location: add_movie.php");
exit();