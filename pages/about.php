<?php
session_start();

// Optional: allow viewing About page without login; if you prefer login-only, uncomment below
// if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }

include '../includes/header.php';
?>

<div class="container mt-5">
  <h2 class="mb-4">About Us</h2>
  <p>Meet the extraordinary team behind this project.</p>

  <div class="row mt-4">
    <div class="col-12 col-md-4 text-center mb-4">
      <img src="../uploads/thumbnails/Hrick.jpg" alt="Member 1" class="rounded" style="width:200px;height:200px;object-fit:cover;">
      <h5 class="mt-3">Hrick Romit Barai</h5>
      <div class="text-muted">ID: 2322136642 | Department: ECE</div>
    </div>

    <div class="col-12 col-md-4 text-center mb-4">
      <img src="../uploads/thumbnails/Yoshiki.jpg" alt="Member 2" class="rounded" style="width:200px;height:200px;object-fit:cover;">
      <h5 class="mt-3">Yoshiki Zaman</h5>
      <div class="text-muted">ID: 2311806042 | Department: ECE</div>
    </div>

    <div class="col-12 col-md-4 text-center mb-4">
      <img src="../uploads/thumbnails/Sabab.jpg" alt="Member 3" class="rounded" style="width:200px;height:200px;object-fit:cover;">
      <h5 class="mt-3">Adib Araf Sabab</h5>
      <div class="text-muted">ID: 2322163042 | Department: ECE</div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
