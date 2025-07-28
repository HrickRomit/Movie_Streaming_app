<?php
session_start();
include '../includes/header.php';
?>

<link rel="stylesheet" href="../assets/css/styles.css"> <!-- Link to your CSS file -->

<div class="background"></div>

<div class="login-container">
  <h2>Sign In</h2>

  <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
  <?php endif; ?>

  <form action="../actions/login_action.php" method="POST">
    <input type="text" name="email" placeholder="Email or mobile number" required />
    <input type="password" name="password" placeholder="Password" required />
    <button type="submit">Sign In</button>
    

    <div class="signup-link">
      New here? <a href="register.php">Sign up now.</a>
    </div>
    
    <div class="adminSignup-link">
      Are you an admin? <a href="../includes/admin_auth.php">Admin Login</a>
    </div>
   
  </form>
  <p>hrick is a negga</p>
  <p>imtiaz is a nigga</p>
  <p>shiki is a chigga</p>
</div>

<?php include '../includes/footer.php'; ?>
