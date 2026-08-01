<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$cart_count = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrajnaVerse Food Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .food-card img { height: 200px; object-fit: cover; }
        .hero-banner { background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1200&q=80'); background-size: cover; background-position: center; color: white; padding: 80px 0; }
    </style>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-egg-fried text-warning me-2"></i>PrajnaVerse Food</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Menu</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li class="nav-item"><a class="nav-link" href="orders.php">My Orders</a></li>
            <?php if ($_SESSION['user_role'] === 'admin'): ?>
                <li class="nav-item"><a class="nav-link text-warning" href="admin-dashboard.php">Admin Panel</a></li>
            <?php endif; ?>
        <?php endif; ?>
      </ul>
      <div class="d-flex align-items-center">
        <a href="cart.php" class="btn btn-outline-warning me-3">
            <i class="bi bi-cart-fill me-1"></i> Cart 
            <span class="badge bg-danger rounded-pill" id="cart-badge"><?= $cart_count ?></span>
        </a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <span class="text-white me-3">Hi, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
            <a href="logout.php" class="btn btn-sm btn-outline-light">Logout</a>
        <?php else: ?>
            <a href="login.php" class="btn btn-sm btn-light me-2">Login</a>
            <a href="register.php" class="btn btn-sm btn-warning">Register</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
<div class="container my-4">
