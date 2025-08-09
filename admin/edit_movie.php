<?php
session_start();
include '../includes/header.php';
include '../config/db.php';

if (!isset($_GET['id'])) {
    echo "Movie ID not specified.";
    exit();
}

$movie_id = $_GET['id'];

// Fetch the movie
$sql = "SELECT * FROM movies WHERE MovieID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$result = $stmt->get_result();
$movie = $result->fetch_assoc();

if (!$movie) {
    echo "Movie not found.";
    exit();
}
?>

<div class="container mt-5">
    <h2>Edit Movie</h2>
    <form action="../admin_actions/edit_movie_action.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="movie_id" value="<?= $movie['MovieID'] ?>">

        <div class="mb-3">
            <label>Movie Name:</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($movie['MovieName']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Genre:</label>
            <input type="text" name="genre" class="form-control" value="<?= htmlspecialchars($movie['GenreID']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Release Year:</label>
            <input type="number" name="year" class="form-control" value="<?= htmlspecialchars($movie['ReleaseYear']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Description:</label>
            <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($movie['Description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label>Current Thumbnail:</label><br>
            <?php if (!empty($movie['Thumbnail'])): ?>
                <img src="../uploads/<?= htmlspecialchars($movie['Thumbnail']) ?>" style="width:150px;"><br>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label>Change Thumbnail (optional):</label>
            <input type="file" name="thumbnail" class="form-control">
        </div>
        <input type="file" name="video" accept="video/mp4,video/webm,video/ogg" required>
        <button type="submit">Add Movie</button>

        <button type="submit" class="btn btn-primary">Update Movie</button>
    </form>
</div>
