<?php
session_start();
include __DIR__ . '/../config/db.php';

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	header('Location: ../pages/index.php');
	exit;
}

if (!isset($_SESSION['user_id'])) {
	// Not logged in -> redirect to login, preserve intended movie via referrer or POST
	header('Location: ../pages/login.php');
	exit;
}

$userId = (int)$_SESSION['user_id'];
$movieId = isset($_POST['movie_id']) ? (int)$_POST['movie_id'] : 0;

if ($movieId <= 0) {
	header('Location: ../pages/index.php');
	exit;
}

// Ensure favourites table exists
$conn->query("CREATE TABLE IF NOT EXISTS favourites (
	id INT AUTO_INCREMENT PRIMARY KEY,
	user_id INT NOT NULL,
	movie_id INT NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	UNIQUE KEY ux_user_movie (user_id,movie_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$stmt = $conn->prepare("INSERT IGNORE INTO favourites (user_id, movie_id) VALUES (?, ?)");
if ($stmt) {
	$stmt->bind_param('ii', $userId, $movieId);
	$stmt->execute();
	$stmt->close();
}

// Redirect back to the movie page if possible
if (!empty($_SERVER['HTTP_REFERER'])) {
	// Sanitize referrer to avoid open redirect; only allow internal redirects
	$ref = $_SERVER['HTTP_REFERER'];
	$siteRoot = preg_replace('#https?://[^/]+#', '', (isset($_SERVER['HTTP_HOST']) ? (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] : ''));
	// If referrer points to our site (contains '/pages/' or '/play_movie.php'), go back
	if (strpos($ref, $_SERVER['HTTP_HOST']) !== false || strpos($ref, '/pages/') !== false || strpos($ref, 'play_movie.php') !== false) {
		header('Location: ' . $ref);
		exit;
	}
}

// Fallback: go to favourites list
header('Location: ../pages/favourite.php');
exit;

