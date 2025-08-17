<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
		header('Location: ../includes/admin_auth.php');
		exit();
}

include '../config/db.php';

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
		$_SESSION['csrf_token'] = bin2hex(random_bytes(16));
}
$csrf = $_SESSION['csrf_token'];

// Fetch users with favourite counts
$users = $conn->query("SELECT u.UserID, u.Username, u.Email, COALESCE(COUNT(f.id),0) AS fav_count
											 FROM User u
											 LEFT JOIN favourites f ON f.user_id = u.UserID
											 GROUP BY u.UserID, u.Username, u.Email
											 ORDER BY u.UserID DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Manage Users</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
	<h2 class="mb-4 text-center">Manage Users</h2>

	<table class="table table-dark table-striped">
		<thead>
			<tr>
				<th>ID</th>
				<th>Username</th>
				<th>Email</th>
				<th>Favourites</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php if ($users): while ($u = $users->fetch_assoc()): ?>
				<tr>
					<td><?= (int)$u['UserID'] ?></td>
					<td><?= htmlspecialchars($u['Username'] ?? '') ?></td>
					<td><?= htmlspecialchars($u['Email'] ?? '') ?></td>
					<td>
						<?= (int)$u['fav_count'] ?>
						<?php if ((int)$u['fav_count'] > 0): ?>
							<button class="btn btn-sm btn-outline-info ml-2" type="button" data-toggle="collapse" data-target="#fav-<?= (int)$u['UserID'] ?>">View</button>
						<?php endif; ?>
					</td>
					<td>
						<form action="../admin_actions/delete_user.php" method="POST" onsubmit="return confirm('Delete this user and all related data?');" class="d-inline">
							<input type="hidden" name="csrf" value="<?= $csrf ?>">
							<input type="hidden" name="user_id" value="<?= (int)$u['UserID'] ?>">
							<button type="submit" class="btn btn-sm btn-danger">Delete</button>
						</form>
					</td>
				</tr>
				<?php if ((int)$u['fav_count'] > 0): ?>
					<tr class="collapse" id="fav-<?= (int)$u['UserID'] ?>">
						<td colspan="5">
							<?php
								$uid = (int)$u['UserID'];
								$favStmt = $conn->prepare("SELECT m.MovieID, m.MovieName, m.ReleaseYear FROM favourites f JOIN movies m ON m.MovieID = f.movie_id WHERE f.user_id = ? ORDER BY f.created_at DESC");
								if ($favStmt) { $favStmt->bind_param('i', $uid); $favStmt->execute(); $favRes = $favStmt->get_result(); }
							?>
							<?php if (!empty($favRes) && $favRes->num_rows > 0): ?>
								<ul class="mb-0">
									<?php while ($fm = $favRes->fetch_assoc()): ?>
										<li>
											<a href="../pages/play_movie.php?id=<?= (int)$fm['MovieID'] ?>" target="_blank">
												<?= htmlspecialchars($fm['MovieName']) ?> (<?= htmlspecialchars($fm['ReleaseYear']) ?>)
											</a>
										</li>
									<?php endwhile; ?>
								</ul>
							<?php else: ?>
								<em>No favourites found.</em>
							<?php endif; if (!empty($favStmt)) { $favStmt->close(); } ?>
						</td>
					</tr>
				<?php endif; ?>
			<?php endwhile; endif; ?>
		</tbody>
	</table>

	<a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
