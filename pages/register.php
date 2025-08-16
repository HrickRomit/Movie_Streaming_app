<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Account</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div class="background"></div>
<div class="login-container">
    <div>
        <h2>Your account</h2>
        <p class="welcome-text"><h3>Welcome to MovieDB!</h3></p>
        <br>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
        <?php endif; ?>

        <form action="../actions/register_action.php" method="POST">
            <div class="input-group">
                <label for="fullname">Full name</label>
                <input type="text" id="fullname" name="username" required placeholder="HrickRomit">
            </div>

            <div class="input-group">
                <label for="email">Work email</label>
                <input type="email" id="email" name="email" required placeholder="hrickromit@gmail.com">
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" required placeholder="••••••••••••" onkeyup="checkPassword()">
                    <i class="fas fa-eye-slash" id="togglePassword"></i>
                </div>
            </div>
            <button type="submit">Register Now</button>
        </form>
        <div style="margin-top:12px;">
            <a href="login.php" style="color:#8a2be2;text-decoration:none;">&larr; Back to Login</a>
        </div>
    </div>
</div>

<script src="../assets/js/registerScript.js"></script>

</body>
</html>
