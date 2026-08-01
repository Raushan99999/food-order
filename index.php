<?php
require_once 'config/db.php';

// Fetch all active categories
$categoryStmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
$categories = $categoryStmt->fetchAll();

// Fetch all available menu items with their category names
$query = "
    SELECT menu_items.*, categories.name AS category_name 
    FROM menu_items 
    JOIN categories ON menu_items.category_id = categories.id 
    WHERE menu_items.is_available = 1 
    ORDER BY menu_items.id DESC
";
$menuStmt = $pdo->query($query);
$menuItems = $menuStmt->fetchAll();

include 'header.php';
?>

<!-- Link Custom Stylesheet -->
<link rel="stylesheet" href="assets/css/style.css">

<!-- Hero Banner Section -->
<div class="hero-banner text-center my-4">
    <h1 class="display-3 fw-bold mb-3">Delicious Food, Delivered Fast</h1>
    <p class="lead mb-4">Explore a world of flavors made with fresh ingredients and delivered right to your doorstep.</p>
    <a href="#menu-section" class="btn btn-warning btn-lg fw-bold px-4 rounded-pill shadow-sm">
        <i class="bi bi-cart-check me-2"></i>Order Now
    </a>
</div>

<!-- Search & Filter Bar Section -->
<div class="container py-4" id="menu-section">
    <div class="row g-3 align-items-center justify-content-between mb-4">
        <!-- Live Search Bar -->
        <div class="col-md-6 col-lg-5">
            <div class="input-group shadow-sm rounded">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" id="menu-search" class="form-control border-start-0 ps-0" placeholder="Search dishes, pizza, burgers...">
            </div>
        </div>

        <!-- Category Filter Buttons -->
        <div class="col-md-6 col-lg-7 text-md-end">
            <div class="btn-group flex-wrap" role="group" id="category-filters">
                <button type="button" class="btn btn-outline-dark active filter-btn" data-category="all">All Items</button>
                <?php foreach ($categories as $cat): ?>
                    <button type="button" class="btn btn-outline-dark filter-btn" data-category="<?= htmlspecialchars(strtolower($cat['name'])) ?>">
                        <?= htmlspecialchars($cat['name']) ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Menu Items Grid -->
    <div class="row g-4" id="menu-grid">
        <?php if (empty($menuItems)): ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-emoji-frown display-1 text-muted"></i>
                <h3 class="mt-3 text-muted">No items available right now.</h3>
            </div>
        <?php else: ?>
            <?php foreach ($menuItems as $item): ?>
                <div class="col-sm-6 col-md-4 col-lg-3 food-card-wrapper" data-category="<?= htmlspecialchars(strtolower($item['category_name'])) ?>">
                    <div class="card h-100 food-card shadow-sm">
                        <div class="position-relative">
                            <img src="<?= htmlspecialchars($item['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($item['name']) ?>">
                            <span class="badge bg-dark position-absolute top-0 end-0 m-2 px-2 py-1 opacity-75">
                                <?= htmlspecialchars($item['category_name']) ?>
                            </span>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold mb-2"><?= htmlspecialchars($item['name']) ?></h5>
                            <p class="card-text text-muted small flex-grow-1">
                                <?= htmlspecialchars($item['description']) ?>
                            </p>
                            <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                                <span class="h5 mb-0 fw-bold text-success">$<?= number_format($item['price'], 2) ?></span>
                                <button class="btn btn-primary add-to-cart-btn px-3" data-id="<?= $item['id'] ?>">
                                    <i class="bi bi-bag-plus me-1"></i> Add
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Inline JS for Category Filtering -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const foodCards = document.querySelectorAll('.food-card-wrapper');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            const selectedCategory = this.dataset.category;

            foodCards.forEach(card => {
                const cardCategory = card.dataset.category;
                if (selectedCategory === 'all' || cardCategory === selectedCategory) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});
</script>

<?php include 'footer.php'; ?>
