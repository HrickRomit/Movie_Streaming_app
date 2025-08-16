<?php
session_start();
if (!isset($_SESSION['user_id'])) {
		header('Location: login.php');
		exit();
}

include '../includes/header.php';
include '../config/db.php';

$userId = $_SESSION['user_id'];

// If a movie_id is provided via GET (from play_movie 'Add Favourites' link), insert it
if (isset($_GET['movie_id'])) {
		$movie_id = (int)$_GET['movie_id'];
		// Create favourites table if not exists
		$conn->query("CREATE TABLE IF NOT EXISTS favourites (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, movie_id INT NOT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, UNIQUE KEY ux_user_movie (user_id,movie_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
		$stmt = $conn->prepare("INSERT IGNORE INTO favourites (user_id, movie_id) VALUES (?, ?)");
		if ($stmt) {
				$stmt->bind_param('ii', $userId, $movie_id);
				$stmt->execute();
				$stmt->close();
		}
		// Redirect to avoid resubmission and show favourites
		header('Location: favourite.php');
		exit();
}

// Fetch user's favourites
$stmt = $conn->prepare("SELECT f.movie_id, m.MovieName, m.MovieLanguage, m.ReleaseYear, m.Description, m.Thumbnail FROM favourites f JOIN movies m ON f.movie_id = m.MovieID WHERE f.user_id = ? ORDER BY f.created_at DESC");
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();

?>
<div class="container mt-4">
	<h2 class="mb-3">Your Favourites</h2>

	<?php if ($result && $result->num_rows > 0): ?>
		<div class="row">
			<?php while ($row = $result->fetch_assoc()): ?>
				<div class="col-12 col-md-6 col-lg-4 mb-3">
					<div class="card bg-dark text-white h-100">
						<?php if (!empty($row['Thumbnail']) && file_exists(__DIR__ . '/../' . ltrim($row['Thumbnail'], '/'))): ?>
							<img src="<?= htmlspecialchars($row['Thumbnail']) ?>" class="card-img-top" style="height:200px;object-fit:cover;">
						<?php else: ?>
							<img src="../uploads/thumbnails/<?= urlencode($row['movie_id']) ?>.jpg" class="card-img-top" style="height:200px;object-fit:cover;" onerror="this.src='../uploads/thumbnails/placeholder.jpg'">
						<?php endif; ?>
						<div class="card-body">
							<h5 class="card-title"><?= htmlspecialchars($row['MovieName']) ?></h5>
							<p class="small text-muted mb-2"><?= htmlspecialchars($row['MovieLanguage']) ?> • <?= htmlspecialchars($row['ReleaseYear']) ?></p>
							<p class="small text-light" style="white-space:pre-wrap; max-height:4.5rem; overflow:hidden;"><?= htmlspecialchars($row['Description']) ?></p>
							<div class="d-flex justify-content-between mt-2">
								<a href="play_movie.php?id=<?= (int)$row['movie_id'] ?>" class="btn btn-sm btn-outline-light">Play</a>
								<form action="../actions/remove_favourite.php" method="POST" style="display:inline;">
									<input type="hidden" name="movie_id" value="<?= (int)$row['movie_id'] ?>">
									<button type="submit" class="btn btn-sm btn-danger">Remove</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
	<?php else: ?>
		<p>You have no favourites yet. Add some from a movie page.</p>
	<?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>

