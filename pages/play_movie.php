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

<?php include '../includes/header.php'; ?>

<div class="container mt-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent pl-0">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="index.php">Movies</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($movie['MovieName']) ?></li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-12 col-md-11 col-lg-10">
            <h2 class="text-white mb-3"><?= htmlspecialchars($movie['MovieName']) ?></h2>

            <div class="player-wrap mx-auto" style="max-width:1200px;">
                <div class="embed-responsive embed-responsive-16by9" style="background:#000;border-radius:6px;overflow:hidden;">
                    <video class="embed-responsive-item" controls preload="metadata" style="background:#000; width:100%; height:100%;">
                        <source src="<?= htmlspecialchars($movie['MovieVideo']) ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>

                        <div class="mt-3 text-muted">
                                <div><strong>Language:</strong> <?= htmlspecialchars($movie['MovieLanguage']) ?></div>
                                <div><strong>Year:</strong> <?= htmlspecialchars($movie['ReleaseYear']) ?></div>
                                <?php
                                    // Show genre name. If Movie row contains GenreName use it, otherwise resolve GenreID -> GenreName
                                    if (!empty($movie['GenreName'])) {
                                        echo '<div><strong>Genre:</strong> '.htmlspecialchars($movie['GenreName']).'</div>';
                                    } elseif (!empty($movie['GenreID'])) {
                                        $gq = $conn->prepare("SELECT GenreName FROM genre WHERE genreid = ? LIMIT 1");
                                        if ($gq) {
                                            $gq->bind_param("i", $movie['GenreID']);
                                            $gq->execute();
                                            $gres = $gq->get_result();
                                            if ($gres && $gres->num_rows > 0) {
                                                $ginfo = $gres->fetch_assoc();
                                                echo '<div><strong>Genre:</strong> '.htmlspecialchars($ginfo['GenreName']).'</div>';
                                            }
                                            $gq->close();
                                        }
                                    }
                                ?>

                                <?php if (!empty($movie['Description'])): ?>
                                    <div class="mt-2"><strong>Description:</strong></div> 
                                    <div class="text-light small" style="white-space:pre-wrap;"><?= htmlspecialchars($movie['Description']) ?></div>
                                <?php endif; ?>
                        </div>

        </div>
    </div>
</div>
<br>
<br>
<?php include '../includes/footer.php'; ?>

