<?php
require_once 'config/db.php';
include 'header.php';

$stmt = $pdo->query("SELECT * FROM menu_items WHERE is_available = 1");
$menuItems = $stmt->fetchAll();
?>

<div class="hero-banner text-center rounded mb-4">
    <h1 class="display-4 fw-bold">Delicious Food Delivered To Your Door</h1>
    <p class="lead">Freshly prepared, fast delivery, infinite flavor.</p>
</div>

<h2 class="mb-4">Explore Our Menu</h2>

<div class="row g-4">
    <?php foreach ($menuItems as $item): ?>
        <div class="col-md-4 col-lg-3">
            <div class="card h-100 shadow-sm food-card">
                <img src="<?= htmlspecialchars($item['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($item['name']) ?>">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= htmlspecialchars($item['name']) ?></h5>
                    <p class="card-text text-muted flex-grow-1"><?= htmlspecialchars($item['description']) ?></p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="h5 mb-0 text-success">$<?= number_format($item['price'], 2) ?></span>
                        <button class="btn btn-primary add-to-cart-btn" data-id="<?= $item['id'] ?>">
                            <i class="bi bi-cart-plus"></i> Add
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include 'footer.php'; ?>
