<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Movie Website</title>
  
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-secondary">
  <a class="navbar-brand" href="../pages/index.php">
    <img src="../uploads/logos/main_logo.jpg" alt="MovieDB Logo" height="40">
</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" 
    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">

<!--categories dropdown* -->
<style>
  .dropdown:hover .dropdown-menu {
    display: block;
  }
  .dropdown-menu {
    display: none;
    position: absolute;
    background: white;
    min-width: 150px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    z-index: 100;
  }
  .dropdown-menu a {
    display: block;
    padding: 8px 16px;
    color: #000000ff;
    text-decoration: none;
  }
  .dropdown-menu a:hover {
    background: #646464ff;
  }
</style>

<li class="nav-item dropdown" style="position:relative;">
  <a class="nav-link dropdown-toggle" href="#">Categories</a>
  <div class="dropdown-menu">
    <a class="dropdown-item" href="../pages/index.php">All</a>
    <a class="dropdown-item" href="../pages/index.php?genre=1">Action</a>
    <a class="dropdown-item" href="../pages/index.php?genre=2">Comedy</a>
    <a class="dropdown-item" href="../pages/index.php?genre=3">Drama</a>
    <a class="dropdown-item" href="../pages/index.php?genre=4">Sci-Fi</a>
    <a class="dropdown-item" href="../pages/index.php?genre=5">Horror</a>
    <a class="dropdown-item" href="../pages/index.php?genre=6">Romance</a>
    <a class="dropdown-item" href="../pages/index.php?genre=7">Thriller</a>
    <a class="dropdown-item" href="../pages/index.php?genre=8">Fantasy</a>
    <a class="dropdown-item" href="../pages/index.php?genre=9">Animation</a>
    <a class="dropdown-item" href="../pages/index.php?genre=10">Adventure</a>
  </div>
</li>
      </li>
      <?php if (isset($_SESSION['user_id'])): ?>
        <li class="nav-item">
          <a class="nav-link" href="../actions/logout.php">Logout</a>
        </li>
      <?php else: ?>
        <li class="nav-item">
          <a class="nav-link" href="../pages/login.php">Login</a>
        </li>
      <?php endif; ?>
    </ul>

    <form class="form-inline my-2 my-lg-0" action="#" method="GET">
      <input class="form-control mr-sm-2" type="search" placeholder="Search movies" name="query" />
      <button class="btn btn-outline-success my-2 my-sm-0" 
        type="submit" 
        style="background-color:#2C3E57; color:white; border:none; border-radius:8px;">
        Search
      </button>
    </form>
  </div>
</nav>
