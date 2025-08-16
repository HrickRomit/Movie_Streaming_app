<?php
session_start();
if (!isset($_SESSION['user_id'])) {
	header('Location: ../pages/login.php');
	exit();
}

include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['movie_id'])) {
	$userId = $_SESSION['user_id'];
	$movieId = (int)$_POST['movie_id'];
	$stmt = $conn->prepare('DELETE FROM favourites WHERE user_id = ? AND movie_id = ?');
	if ($stmt) {
		$stmt->bind_param('ii', $userId, $movieId);
		$stmt->execute();
		$stmt->close();
	}
}

header('Location: ../pages/favourite.php');
exit();

