<?php
include '../config/db.php';

if (!isset($_GET['id'])) {
    echo "No movie ID provided.";
    exit;
}

$movie_id = intval($_GET['id']);
$query = "SELECT * FROM movies WHERE MovieID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $movie = $result->fetch_assoc();
} else {
    echo "Movie not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($movie['MovieName']) ?> - Watch</title>
</head>
<body>
    <h2><?= htmlspecialchars($movie['MovieName']) ?></h2>
    <p><strong>Language:</strong> <?= htmlspecialchars($movie['MovieLanguage']) ?></p>
    <p><strong>Release Year:</strong> <?= htmlspecialchars($movie['ReleaseYear']) ?></p>

    <video width="720" height="400" controls>
        <source src="<?= htmlspecialchars($movie['MovieVideo']) ?>" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <br><br>
    <a href="../pages/index.php">← Back to Home</a>
</body>
</html>
