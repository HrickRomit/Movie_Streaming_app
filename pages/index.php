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

$sql = "SELECT MovieName, MovieLanguage, ReleaseYear FROM movies";
$result = $conn->query($sql);



if ($result->num_rows > 0) {
    // Start Bootstrap-styled table, with padding/margin for spacing
    
    echo '<div class="container" style="margin-top:40px;">';
    echo '<table class="table table-bordered table-striped bg-white text-dark" style="margin:auto; width:80%;">';
    echo '<thead class="thead-dark"><tr>
            <th style="text-align:center;">Movie Name</th>
            <th style="text-align:center;">Language</th>
            <th style="text-align:center;">Release Year</th>
          </tr></thead>';
    echo '<tbody>';
    while($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td style="text-align:center;">' . htmlspecialchars($row['MovieName']) . '</td>';
        echo '<td style="text-align:center;">' . htmlspecialchars($row['MovieLanguage']) . '</td>';
        echo '<td style="text-align:center;">' . htmlspecialchars($row['ReleaseYear']) . '</td>';
        echo '</tr>';
    }
    echo '</tbody></table></div>';
} else {
    echo "<p style='text-align:center;'>No movies found.</p>";
}
?>

