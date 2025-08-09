<?php
session_start();
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id          = intval($_POST['movie_id']);
    $name        = $_POST['name'];
    $language    = $_POST['language'];
    $genre       = intval($_POST['genre']);
    $year        = intval($_POST['year']);
    $description = $_POST['description'];

    // Prepare variables for optional file updates
    $videoPath   = null;
    $thumbnail   = null;

    // Handle video upload if provided
    if (isset($_FILES['video']) && $_FILES['video']['error'] === UPLOAD_ERR_OK) {
        $videoName = basename($_FILES['video']['name']);
        $videoTmp  = $_FILES['video']['tmp_name'];
        $videoPath = '../uploads/videos/' . $videoName;

        if (!move_uploaded_file($videoTmp, $videoPath)) {
            die("Video upload failed.");
        }
    }

    // Handle thumbnail upload if provided
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $thumbName = basename($_FILES['thumbnail']['name']);
        $thumbTmp  = $_FILES['thumbnail']['tmp_name'];
        $thumbPath = '../uploads/thumbnails/' . $thumbName;

        if (move_uploaded_file($thumbTmp, $thumbPath)) {
            $thumbnail = $thumbName;
        } else {
            die("Thumbnail upload failed.");
        }
    }

    // Build SQL dynamically based on what was updated
    $fields = [
        "MovieName = ?",
        "MovieLanguage = ?",
        "GenreID = ?",
        "ReleaseYear = ?",
        "Description = ?"
    ];
    $params = [$name, $language, $genre, $year, $description];
    $types  = "sssis";

    if ($thumbnail) {
        $fields[] = "Thumbnail = ?";
        $params[] = $thumbnail;
        $types   .= "s";
    }

    if ($videoPath) {
        $fields[] = "MovieVideo = ?";
        $params[] = $videoPath;
        $types   .= "s";
    }

    $params[] = $id;
    $types   .= "i";

    $sql  = "UPDATE movies SET " . implode(", ", $fields) . " WHERE MovieID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        header("Location: ../admin/admin_dashboard.php?updated=1");
        exit();
    } else {
        die("Error updating movie: " . $stmt->error);
    }
}
?>
