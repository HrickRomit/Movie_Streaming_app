<?php
session_start();
include '../config/db.php'; // Update path to your DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_username = $_POST['admin_username'];
    $admin_password = $_POST['admin_password'];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_username = ? AND admin_password = ?");
    $stmt->bind_param("ss", $admin_username, $admin_password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $_SESSION['admin_username'] = $admin_username;
        header("Location: ../admin/admin_dashboard.php"); 
        exit();
    } else {
        $error = "Invalid admin credentials!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="../assets/css/styles.css"> 
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="admin_username" placeholder="Admin Username" required />
            <input type="password" name="admin_password" placeholder="Password" required />
            <button type="submit">Login</button>
        </form>

        <div class="back-link">
            <a href="../pages/login.php">← Back to User Login</a>
        </div>
    </div>
</body>
</html>
