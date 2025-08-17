<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: ../includes/admin_auth.php");
    exit();
}

include '../config/db.php'; // ✅ Add this line to connect to DB
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4 text-center">Welcome, Admin!</h2>
    
    <div class="d-flex flex-column align-items-center">
        <a href="../admin/add_movie.php" class="btn btn-success btn-lg mb-3" style="width: 50%;">Add Movie</a>
        <a href="../admin/manage_users.php" class="btn btn-warning btn-lg mb-3" style="width: 50%;">Manage Users</a>
    </div>

    <h4 class="mt-5 mb-3">Movies:</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Movie Name</th>
                <th>Genre</th>
                <th>Release Year</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
           $query = "
            SELECT movies.MovieID, movies.MovieName, genre.GenreName, movies.ReleaseYear
            FROM movies
            JOIN genre ON movies.GenreID = genre.GenreID
            ";

            $result = mysqli_query($conn, $query);
            while ($movie = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$movie['MovieName']}</td>
                        <td>{$movie['GenreName']}</td>
                        <td>{$movie['ReleaseYear']}</td>
                        <td><a href='edit_movie.php?id={$movie['MovieID']}' class='btn btn-primary'>Edit</a></td>
                        <td><a href='../admin/delete_confirmation.php?id={$movie['MovieID']}' class='btn btn-danger'
                        onclick=\"return confirm('Are you sure you want to delete this movie?');\">
                        Delete
                        </a>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
