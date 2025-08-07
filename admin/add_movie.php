<?php
include '../config/db.php';

// Fetch genres
$genres = [];
$genre_query = "SELECT GenreID, GenreName FROM genre";
$result = $conn->query($genre_query);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $genres[] = $row;
    }
}

$success = isset($_GET['success']) && $_GET['success'] == 1;
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Movie</title>
    <style>
          body {
            font-family: 'Segoe UI', sans-serif;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background: white;
            padding: 2rem 2.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        .form-container h2 {
            color: #1a73e8;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
        }

        input,
        select {
            width: 100%;
            padding: 0.6rem;
            border-radius: 6px;
            border: 1px solid #ccc;
            transition: 0.2s;
        }

        input:focus,
        select:focus {
            border-color: #1a73e8;
            outline: none;
        }

        button {
            width: 100%;
            padding: 0.7rem;
            background-color: #1a73e8;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            background-color: #125ab3;
        }

        .message {
            margin-top: 1rem;
            font-weight: bold;
            text-align: center;
            color: green;
        }

        .message.error {
            color: red;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Add Movie</h2>

    <form method="POST" action="../admin_actions/add_movie_action.php" enctype="multipart/form-data">
        <div class="form-group">
            <label>Movie Name</label>
            <input name="name" required>
        </div>

        <div class="form-group">
            <label>Language</label>
            <input name="language" required>
        </div>

        <div class="form-group">
            <label>Release Year</label>
            <input name="year" type="number" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <input name="description" required>
        </div>

        <div class="form-group">
            <label>Thumbnail URL</label>
            <input name="thumbnail">
        </div>

        <div class="form-group">
            <label>Genre</label>
            <select name="genre" required>
                <option value="">-- Select Genre --</option>
                <?php foreach ($genres as $g): ?>
                    <option value="<?= $g['GenreID'] ?>">
                        <?= htmlspecialchars($g['GenreID']) ?> - <?= htmlspecialchars($g['GenreName']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <input type="file" name="video" accept="video/mp4,video/webm,video/ogg" required>
        <button type="submit">Add Movie</button>
    </form>

    <?php if ($success): ?>
        <div class="message">✅ Movie added successfully!</div>
        <script>document.querySelector("form").reset();</script>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="message error">❌ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <div class="back-link">
            <a href="../admin/admin_dashboard.php">← Back to Admin Dashboard</a>
        </div>
</div>

</body>
</html>