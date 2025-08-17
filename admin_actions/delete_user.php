<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
	header('Location: ../includes/admin_auth.php');
	exit();
}

require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	header('Location: ../admin/manage_users.php');
	exit();
}

// CSRF check
if (empty($_POST['csrf']) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf'])) {
	header('Location: ../admin/manage_users.php?error=csrf');
	exit();
}

$userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
if ($userId <= 0) {
	header('Location: ../admin/manage_users.php?error=invalid');
	exit();
}

// Best-effort deletes; ignore errors if tables don’t exist
@$conn->query('DELETE FROM favourites WHERE user_id = ' . $userId);
@$conn->query('DELETE FROM watch_history WHERE UserID = ' . $userId);

$stmt = $conn->prepare('DELETE FROM User WHERE UserID = ?');
if ($stmt) {
	$stmt->bind_param('i', $userId);
	$stmt->execute();
	$stmt->close();
}

header('Location: ../admin/manage_users.php?deleted=1');
exit();
?>
