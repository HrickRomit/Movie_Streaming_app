<?php
session_start();
// include '../includes/header.php';
require '../config/db.php';
?>

<link rel="stylesheet" href="../assets/css/styles.css"> <!-- Link to your CSS file -->
<div class="background"></div>

<div class="login-container">
  <?php if (!isset($_GET['otp'])): ?>
    <h2>Sign In</h2>

    <?php if (isset($_GET['error'])): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <form action="../actions/login_action.php" method="POST">
      <!-- Current local time display -->
      <div class="current-time" style="color:#fff;margin-bottom:10px;font-size:0.95rem;">
        <strong>Current Local Time:</strong>
        <span id="localTime">--:--:--</span>
      </div>
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

  <?php else: ?>
    <h2>Enter OTP</h2>
    <p>We have sent a 6-digit OTP to your email. Please enter it below.</p>

    <?php if (isset($_GET['error'])): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <form action="../actions/verify_otp_action.php" method="POST">
      <input type="hidden" name="email" value="<?= htmlspecialchars($_GET['email']) ?>" />
      <input type="text" name="otp" placeholder="Enter OTP" required maxlength="6" />
      <button type="submit">Verify OTP</button>
    </form>
  <?php endif; ?>
</div>
<script>
  (function() {
    function pad(n) { return n < 10 ? '0' + n : n; }
    function updateClock() {
      var d = new Date();
      var hh = pad(d.getHours());
      var mm = pad(d.getMinutes());
      var ss = pad(d.getSeconds());
      var el = document.getElementById('localTime');
      if (el) el.textContent = hh + ':' + mm + ':' + ss;
    }
    updateClock();
    setInterval(updateClock, 1000);
  })();
</script>

