<?php
session_start();
// include '../includes/header.php'; // Assuming this contains <head> and opening <body> tags
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Account</title>
    <link rel="stylesheet" href="../assets/css/registerStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div class="register-container">
    <div class="register-box">
        <h2>Your account</h2>
        <p class="welcome-text">Welcome to Notify!</p>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
        <?php endif; ?>

        <form action="../actions/register_action.php" method="POST">
            <div class="input-group">
                <label for="fullname">Full name</label>
                <input type="text" id="fullname" name="username" required placeholder="NUNU">
            </div>

            <div class="input-group">
                <label for="email">Work email</label>
                <input type="email" id="email" name="email" required placeholder="Robert.Johnson@gmail.com">
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" required placeholder="••••••••••••" onkeyup="checkPassword()">
                    <i class="fas fa-eye-slash" id="togglePassword"></i>
                </div>
            </div>
            
            <div id="password-requirements">
                <p>Must contain at least:</p>
                <ul>
                    <li id="length" class="invalid">12 characters</li>
                    <li id="lowercase" class="invalid">1 lower case character</li>
                    <li id="uppercase" class="invalid">1 upper case character</li>
                    <li id="number" class="invalid">1 number</li>
                    <li id="special" class="invalid">1 special character</li>
                </ul>
            </div>

            <button type="submit" class="btn-register">Register Now</button>

            <div class="divider">OR</div>

            <div class="social-login">
                <a href="#" class="social-btn twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-btn facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-btn google"><i class="fab fa-google"></i></a>
            </div>
        </form>
    </div>
</div>

<!-- <script src="../assets/js/registerScript.js"></script> -->
<?php // include '../includes/footer.php'; ?>

</body>
</html>
