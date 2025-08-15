<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user_id'])) {
	header('Location: ../pages/login.php');
	exit;
}

$userId = (int)$_SESSION['user_id'];
$movieId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$pos = isset($_GET['pos']) ? (int)$_GET['pos'] : 0; // optional playback position (seconds)

if ($movieId <= 0) {
	header('Location: ../pages/index.php');
	exit;
}

// Ensure movie exists
$stmt = $conn->prepare('SELECT MovieID FROM movies WHERE MovieID = ?');
$stmt->bind_param('i', $movieId);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
	header('Location: ../pages/index.php');
	exit;
}

// Upsert watch history: increment times_watched and update last_position_seconds
$sql = "INSERT INTO watch_history (UserID, MovieID, watched_at, times_watched, last_position_seconds)
		VALUES (?, ?, NOW(), 1, ?)
		ON DUPLICATE KEY UPDATE
		  times_watched = times_watched + 1,
		  watched_at = NOW(),
		  last_position_seconds = VALUES(last_position_seconds)";

$ins = $conn->prepare($sql);
$ins->bind_param('iii', $userId, $movieId, $pos);
$ins->execute();

// Redirect to player
header('Location: ../pages/play_movie.php?id=' . $movieId);
exit;
?>
