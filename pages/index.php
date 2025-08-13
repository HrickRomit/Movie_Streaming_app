<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Now include the header (navbar is inside it)
include '../includes/header.php';
?>

<!-- Page content -->
<div class="container mt-5">
    <h1>Welcome to MovieDB!</h1>
    <p>You are logged in successfully.</p>
</div>

<?php
include '../config/db.php'; // Adjust path as needed

$genreId = isset($_GET['genre']) ? (int)$_GET['genre'] : 0;

if ($genreId > 0) {
    $stmt = $conn->prepare("
        SELECT m.MovieID, m.MovieName, m.MovieLanguage, g.GenreName, m.ReleaseYear
        FROM movies m
        JOIN genre g ON m.genreid = g.genreid
        WHERE m.genreid = ?
        ORDER BY m.MovieName
    ");
    $stmt->bind_param("i", $genreId);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("
        SELECT m.MovieID, m.MovieName, m.MovieLanguage, g.GenreName, m.ReleaseYear
        FROM movies m
        JOIN genre g ON m.genreid = g.genreid
        ORDER BY m.MovieName
    ");
}

if ($result->num_rows > 0) {
    // Start Bootstrap-styled table, with padding/margin for spacing
    
    echo '<div class="container mt-4">';
echo '  <div class="row">';

while ($row = $result->fetch_assoc()) {
    $movieID = $row['MovieID'];
    $img = "../uploads/thumbnails/{$movieID}.jpg";           // e.g., uploads/images/1.jpg
    $placeholder = "../uploads/images/placeholder.jpg";  // add this file
    if (!file_exists($img)) { $img = $placeholder; }

    echo '    <div class="col-6 col-md-4 col-lg-3 mb-4">';
    echo '    <a href="play_movie.php?id='. $movieID .'" style="text-decoration:none;color:inherit;">';
    echo '      <div class="card bg-dark text-white h-100" style="border:none;">';
    echo '        <img src="'. $img .'" alt="'. htmlspecialchars($row['MovieName']) .'" class="card-img-top" style="height:350px;object-fit:cover;">';
    echo '        <div class="card-body text-center p-2">';
    echo '          <h6 class="card-title mb-1" style="display:block;width:100%;max-width:100%;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"title="'. htmlspecialchars($row['MovieName']) .'">'. htmlspecialchars($row['MovieName']) .'</h6>';
    echo '          <div class="small text-muted">'. htmlspecialchars($row['MovieLanguage']) .' • '. htmlspecialchars($row['ReleaseYear']).' • '. htmlspecialchars($row['GenreName']) .'</div>';
    echo '        </div>';
    echo '      </div>';
    echo '    </div>';
}

echo '  </div>';
echo '</div>';
} else {
    echo "<p style='text-align:center;'>No movies found.</p>";  
}

?>