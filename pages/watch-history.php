<?php
session_start();
if (!isset($_SESSION['user_id'])) {
		header('Location: login.php');
		exit;
}

include '../includes/header.php';
include '../config/db.php';

$userId = (int)$_SESSION['user_id'];

$sql = "SELECT m.MovieID, m.MovieName, m.MovieLanguage, m.ReleaseYear, g.GenreName, wh.watched_at, wh.times_watched
				FROM watch_history wh
				JOIN movies m ON m.MovieID = wh.MovieID
				LEFT JOIN genre g ON g.GenreID = m.GenreID
				WHERE wh.UserID = ?
				ORDER BY wh.watched_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mt-5">
	<h2 class="mb-3">Your Watch History</h2>
	<?php if ($result && $result->num_rows > 0): ?>
		<div class="row">
			<?php while ($row = $result->fetch_assoc()):
						$movieID = (int)$row['MovieID'];
						$img = "../uploads/thumbnails/{$movieID}.jpg";
						if (!file_exists($img)) { $img = "../uploads/thumbnails/{$movieID}.jpg"; }
			?>
				<div class="col-6 col-md-4 col-lg-3 mb-4">
					<a href="play_movie.php?id=<?= $movieID ?>" style="text-decoration:none;color:inherit;">
						<div class="card bg-dark text-white h-100 movie-card" style="border:none;">
							<div class="poster-wrap">
								<img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($row['MovieName']) ?>" class="card-img-top" style="height:350px;object-fit:cover;">
								<div class="play-overlay" aria-hidden="true">
									<div class="play-btn" aria-label="Play">
										<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 5v14l11-7z"></path></svg>
									</div>
								</div>
							</div>
							<div class="card-body text-center p-2">
								<h6 class="card-title mb-1" style="display:block;width:100%;max-width:100%;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="<?= htmlspecialchars($row['MovieName']) ?>"><?= htmlspecialchars($row['MovieName']) ?></h6>
								<div class="small text-muted">
									<?= htmlspecialchars($row['MovieLanguage']) ?> • <?= htmlspecialchars($row['ReleaseYear']) ?><?php if (!empty($row['GenreName'])): ?> • <?= htmlspecialchars($row['GenreName']) ?><?php endif; ?>
								</div>
								<div class="small text-muted">Last watched: <?= htmlspecialchars($row['watched_at']) ?><?php if ((int)$row['times_watched'] > 1): ?> • <?= (int)$row['times_watched'] ?> times<?php endif; ?></div>
							</div>
						</div>
					</a>
				</div>
			<?php endwhile; ?>
		</div>
	<?php else: ?>
		<p>You haven’t watched any movies yet.</p>
	<?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
