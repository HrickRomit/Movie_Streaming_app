<?php
session_start();
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

// Fetch genres for dropdown (like add_movie.php)
$genres = [];
$gq = $conn->query("SELECT GenreID, GenreName FROM genre ORDER BY GenreName");
if ($gq && $gq->num_rows > 0) {
    while ($row = $gq->fetch_assoc()) { $genres[] = $row; }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Movie</title>
    <!-- Keep existing site styles without pulling the header/nav -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>

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
            <select name="genre" class="form-control" required>
                <option value="">-- Select Genre --</option>
                <?php foreach ($genres as $g): $gid=(int)$g['GenreID']; ?>
                    <option value="<?= $gid ?>" <?= ($gid == (int)$movie['GenreID']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($g['GenreID']) ?> - <?= htmlspecialchars($g['GenreName']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
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
            <?php
                $mid = (int)$movie['MovieID'];
                $idThumbDisk = __DIR__ . '/../uploads/thumbnails/' . $mid . '.jpg';
                $idThumbWeb  = '../uploads/thumbnails/' . $mid . '.jpg';
                $thumbWeb = null;
                if (file_exists($idThumbDisk)) {
                    $thumbWeb = $idThumbWeb;
                } elseif (!empty($movie['Thumbnail'])) {
                    $dbThumb = $movie['Thumbnail'];
                    // If it's just a filename, assume it's in uploads/thumbnails
                    if (strpos($dbThumb, '/') === false && strpos($dbThumb, '\\') === false) {
                        $thumbWeb = '../uploads/thumbnails/' . $dbThumb;
                    } else {
                        $thumbWeb = $dbThumb; // already a path/url
                    }
                }
            ?>
            <?php if (!empty($thumbWeb)): ?>
                <img src="<?= htmlspecialchars($thumbWeb) ?>" style="width:150px;" alt="Current thumbnail"><br>
            <?php else: ?>
                <small class="text-muted">No thumbnail found for this movie.</small>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label>Change Thumbnail (optional):</label>
            <input type="file" name="thumbnail" class="form-control">
        </div>
        <div class="mb-3">
            <label>Change Video (optional):</label>
            <input type="file" name="video" class="form-control" accept="video/mp4,video/webm,video/ogg">
        </div>

        <button type="submit" class="btn btn-primary">Update Movie</button>
    </form>
</div>

</body>
</html>
