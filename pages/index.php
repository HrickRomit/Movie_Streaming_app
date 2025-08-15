<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include header and DB
include '../includes/header.php';
include '../config/db.php';

?>
<div class="container mt-5">
    <h1>Welcome to MovieDB!</h1>
    <p>Discover your next favorite movie.</p>
</div>

<?php
$genreId = isset($_GET['genre']) ? (int)$_GET['genre'] : 0;
// Resolve category name when set, for breadcrumb
$genreName = '';
if ($genreId > 0) {
    $gstmt = $conn->prepare("SELECT GenreName FROM genre WHERE genreid = ? LIMIT 1");
    if ($gstmt) {
        $gstmt->bind_param("i", $genreId);
        $gstmt->execute();
        $gres = $gstmt->get_result();
        if ($gres && $gres->num_rows > 0) {
            $grow = $gres->fetch_assoc();
            $genreName = $grow['GenreName'];
        }
        $gstmt->close();
    }
}

// Breadcrumb: always show Home / Movies; add category if selected
echo '<div class="container mt-2">';
echo '  <nav aria-label="breadcrumb">';
echo '    <ol class="breadcrumb bg-transparent pl-0">';
echo '      <li class="breadcrumb-item"><a href="index.php">Home</a></li>';
echo '      <li class="breadcrumb-item"><a href="index.php">Movies</a></li>';
if ($genreName !== '') {
    echo '      <li class="breadcrumb-item active" aria-current="page">' . htmlspecialchars($genreName) . '</li>';
}
echo '    </ol>';
echo '  </nav>';
echo '</div>';
$searchQuery = isset($_GET['query']) ? trim($_GET['query']) : '';

// Pagination setup
$limit = 20; // movies per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) { $page = 1; }
$offset = ($page - 1) * $limit;

// Get total count (respecting genre filter and optional search)
if ($genreId > 0 && $searchQuery !== '') {
    $countStmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM movies WHERE genreid = ? AND MovieName LIKE ?");
    $like = "%" . $searchQuery . "%";
    $countStmt->bind_param("is", $genreId, $like);
    $countStmt->execute();
    $countRes = $countStmt->get_result()->fetch_assoc();
    $total = (int)$countRes['cnt'];
    $countStmt->close();
} elseif ($genreId > 0) {
    $countStmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM movies WHERE genreid = ?");
    $countStmt->bind_param("i", $genreId);
    $countStmt->execute();
    $countRes = $countStmt->get_result()->fetch_assoc();
    $total = (int)$countRes['cnt'];
    $countStmt->close();
} elseif ($searchQuery !== '') {
    $countStmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM movies WHERE MovieName LIKE ?");
    $like = "%" . $searchQuery . "%";
    $countStmt->bind_param("s", $like);
    $countStmt->execute();
    $countRes = $countStmt->get_result()->fetch_assoc();
    $total = (int)$countRes['cnt'];
    $countStmt->close();
} else {
    $countRes = $conn->query("SELECT COUNT(*) AS cnt FROM movies")->fetch_assoc();
    $total = (int)$countRes['cnt'];
}

$total_pages = $total > 0 ? (int)ceil($total / $limit) : 1;
if ($page > $total_pages) { $page = $total_pages; $offset = ($page - 1) * $limit; }

// Fetch paginated rows (with genre join for display) and optional search
if ($genreId > 0 && $searchQuery !== '') {
    $stmt = $conn->prepare("SELECT m.MovieID, m.MovieName, m.MovieLanguage, g.GenreName, m.ReleaseYear
        FROM movies m
        JOIN genre g ON m.genreid = g.genreid
        WHERE m.genreid = ? AND m.MovieName LIKE ?
        ORDER BY m.MovieID
        LIMIT ? OFFSET ?");
    $like = "%" . $searchQuery . "%";
    $stmt->bind_param("isii", $genreId, $like, $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
} elseif ($genreId > 0) {
    $stmt = $conn->prepare("SELECT m.MovieID, m.MovieName, m.MovieLanguage, g.GenreName, m.ReleaseYear
        FROM movies m
        JOIN genre g ON m.genreid = g.genreid
        WHERE m.genreid = ?
        ORDER BY m.MovieID
        LIMIT ? OFFSET ?");
    $stmt->bind_param("iii", $genreId, $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
} elseif ($searchQuery !== '') {
    $stmt = $conn->prepare("SELECT m.MovieID, m.MovieName, m.MovieLanguage, g.GenreName, m.ReleaseYear
        FROM movies m
        JOIN genre g ON m.genreid = g.genreid
        WHERE m.MovieName LIKE ?
        ORDER BY m.MovieID
        LIMIT ? OFFSET ?");
    $like = "%" . $searchQuery . "%";
    $stmt->bind_param("sii", $like, $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $stmt = $conn->prepare("SELECT m.MovieID, m.MovieName, m.MovieLanguage, g.GenreName, m.ReleaseYear
        FROM movies m
        JOIN genre g ON m.genreid = g.genreid
        ORDER BY m.MovieID
        LIMIT ? OFFSET ?");
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
}

if ($result && $result->num_rows > 0) {
    echo '<div class="container mt-4">';
    echo '  <div class="row">';

    while ($row = $result->fetch_assoc()) {
        $movieID = $row['MovieID'];
        $img = "../uploads/thumbnails/{$movieID}.jpg"; // thumbnail path
        $placeholder = "../uploads/images/placeholder.jpg"; // placeholder path (ensure file exists)
        if (!file_exists($img)) { $img = $placeholder; }

        echo '    <div class="col-6 col-md-4 col-lg-3 mb-4">';
        echo '      <a href="play_movie.php?id='. $movieID .'" style="text-decoration:none;color:inherit;">';
        echo '        <div class="card bg-dark text-white h-100 movie-card">';
        echo '          <div class="poster-wrap">';
        echo '            <img src="'. htmlspecialchars($img) .'" alt="'. htmlspecialchars($row['MovieName']) .'" class="card-img-top" style="height:350px;object-fit:cover;">';
        echo '            <div class="play-overlay" aria-hidden="true">';
        echo '              <div class="play-btn" aria-label="Play">';
        echo '                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 5v14l11-7z"></path></svg>';
        echo '              </div>';
        echo '            </div>';
        echo '          </div>';
        echo '          <div class="card-body text-center p-2">';
        echo '            <h6 class="card-title mb-1" style="display:block;width:100%;max-width:100%;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="'. htmlspecialchars($row['MovieName']) .'">'. htmlspecialchars($row['MovieName']) .'</h6>';
        echo '            <div class="small text-muted">'. htmlspecialchars($row['MovieLanguage']) .' • '. htmlspecialchars($row['ReleaseYear']) .' • '. htmlspecialchars($row['GenreName']) .'</div>';
        echo '          </div>';
        echo '        </div>';
        echo '      </a>';
        echo '    </div>';
    }

    echo '  </div>';
    echo '</div>';
} else {
    echo "<p style='text-align:center;'>No movies found.</p>";
}

// Render pagination controls if multiple pages
if (isset($total_pages) && $total_pages > 1) {
    echo '<nav aria-label="Page navigation example">';
    echo '<ul class="pagination justify-content-center mt-4">';

    // Previous link
    $prev = $page - 1;
    $prev_disabled = $prev < 1 ? ' disabled' : '';
    $prev_query = '?page=' . max(1, $prev);
    if ($genreId > 0) { $prev_query .= '&genre=' . $genreId; }
    if ($searchQuery !== '') { $prev_query .= '&query=' . urlencode($searchQuery); }
    echo '<li class="page-item'. $prev_disabled .'"><a class="page-link" href="index.php'. $prev_query .'">Previous</a></li>';

    // Show a range of pages (simple logic)
    $start = max(1, $page - 2);
    $end = min($total_pages, $page + 2);
    if ($start > 1) {
    $q = '?page=1' . ($genreId>0 ? '&genre='.$genreId : '');
    if ($searchQuery !== '') { $q .= '&query=' . urlencode($searchQuery); }
        echo '<li class="page-item"><a class="page-link" href="index.php'. $q .'">1</a></li>';
        if ($start > 2) { echo '<li class="page-item disabled"><span class="page-link">...</span></li>'; }
    }

    for ($p = $start; $p <= $end; $p++) {
        $active = $p === $page ? ' active' : '';
    $q = '?page='.$p . ($genreId>0 ? '&genre='.$genreId : '');
    if ($searchQuery !== '') { $q .= '&query=' . urlencode($searchQuery); }
        echo '<li class="page-item'. $active .'"><a class="page-link" href="index.php'. $q .'">'. $p .'</a></li>';
    }

    if ($end < $total_pages) {
        if ($end < $total_pages - 1) { echo '<li class="page-item disabled"><span class="page-link">...</span></li>'; }
    $q = '?page='.$total_pages . ($genreId>0 ? '&genre='.$genreId : '');
    if ($searchQuery !== '') { $q .= '&query=' . urlencode($searchQuery); }
        echo '<li class="page-item"><a class="page-link" href="index.php'. $q .'">'. $total_pages .'</a></li>';
    }

    // Next link
    $next = $page + 1;
    $next_disabled = $next > $total_pages ? ' disabled' : '';
    $next_query = '?page=' . min($total_pages, $next);
    if ($genreId > 0) { $next_query .= '&genre=' . $genreId; }
    if ($searchQuery !== '') { $next_query .= '&query=' . urlencode($searchQuery); }
    echo '<li class="page-item'. $next_disabled .'"><a class="page-link" href="index.php'. $next_query .'">Next</a></li>';

    echo '</ul>';
    echo '</nav>';
}

include '../includes/footer.php';

?>