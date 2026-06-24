<?php
include 'includes/db.php';
include 'includes/header.php';

$search = trim($_GET['search'] ?? '');
$category = trim($_GET['category'] ?? '');

$sql = "SELECT * FROM products WHERE 1";

if ($search !== '') {
    $search_safe = mysqli_real_escape_string($conn, $search);
    $sql .= " AND name LIKE '%$search_safe%'";
}

if ($category !== '' && $category !== 'All') {
    $category_safe = mysqli_real_escape_string($conn, $category);
    $sql .= " AND category = '$category_safe'";
}

$sql .= " ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

$categories = ['Clothing', 'Electronics', 'Footwear', 'Beauty', 'Accessories', 'Home Decor'];
?>

<section class="products-hero">
    <div class="products-hero-overlay"></div>
    <div class="container">
        <div class="products-hero-content">
            <span class="hero-label">SHOP COLLECTION</span>
            <h1>Our Products</h1>
            <p>Explore our wide range of premium products.</p>
        </div>
    </div>
</section>

<section class="products-page-section">
    <div class="container">
        <!-- FILTER BAR -->
        <div class="products-filter-box">
            <form method="GET" class="products-filter-form">
                <div class="filter-input">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input
                        type="text"
                        name="search"
                        placeholder="Search products..."
                        value="<?php echo htmlspecialchars($search); ?>"
                    >
                </div>

                <div class="filter-select">
                    <select name="category">
                        <option value="All">All Categories</option>
                        <?php foreach ($categories as $cat) { ?>
                            <option value="<?php echo $cat; ?>" <?php echo ($category === $cat) ? 'selected' : ''; ?>>
                                <?php echo $cat; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <button type="submit" class="filter-btn">
                    <i class="fa-solid fa-sliders"></i> Apply
                </button>
            </form>
        </div>

        <!-- PRODUCTS GRID -->
        <div class="products-clean-grid">
            <?php if ($result && mysqli_num_rows($result) > 0) { ?>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="clean-product-card">
                        <div class="clean-product-image-box">
                            <?php if (!empty($row['image'])) { ?>
                                <img src="<?php echo $row['image']; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="clean-product-image">
                            <?php } else { ?>
                                <img src="https://via.placeholder.com/500x500?text=Product" alt="Product" class="clean-product-image">
                            <?php } ?>
                        </div>

                        <div class="clean-product-content">
                            <span class="clean-product-category">
                                <?php echo htmlspecialchars($row['category'] ?? 'General'); ?>
                            </span>

                            <h3 class="clean-product-title">
                                <?php echo htmlspecialchars($row['name']); ?>
                            </h3>

                            <p class="clean-product-desc">
                                <?php
                                $desc = $row['description'] ?? '';
                                echo htmlspecialchars(substr($desc, 0, 85));
                                if (strlen($desc) > 85) echo '...';
                                ?>
                            </p>

                            <div class="clean-product-price">
                                ₹<?php echo number_format($row['price'], 2); ?>
                            </div>

                            <div class="clean-product-actions">
                                <a href="product-details.php?id=<?php echo $row['id']; ?>" class="btn-view-clean">
                                    <i class="fa-regular fa-eye"></i> View Details
                                </a>
                                <a href="cart.php?add=<?php echo $row['id']; ?>" class="btn-cart-clean">
                                    <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="no-products-box">
                    <i class="fa-solid fa-box-open"></i>
                    <h2>No Products Found</h2>
                    <p>Try changing the search term or category filter.</p>
                </div>
            <?php } ?>
        </div>

        <!-- STATIC PAGINATION UI -->
        <div class="products-pagination">
            <a href="#"><i class="fa-solid fa-angle-left"></i></a>
            <a href="#" class="active">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <a href="#"><i class="fa-solid fa-angle-right"></i></a>
        </div>
    </div>
</section>

<section class="shop-features-strip">
    <div class="container">
        <div class="shop-features-grid">
            <div class="shop-feature-item">
                <div class="shop-feature-icon"><i class="fa-solid fa-shield-heart"></i></div>
                <div>
                    <h4>Secure Payments</h4>
                    <p>100% secure checkout</p>
                </div>
            </div>

            <div class="shop-feature-item">
                <div class="shop-feature-icon"><i class="fa-solid fa-truck"></i></div>
                <div>
                    <h4>Free Shipping</h4>
                    <p>On all orders above ₹999</p>
                </div>
            </div>

            <div class="shop-feature-item">
                <div class="shop-feature-icon"><i class="fa-solid fa-rotate-left"></i></div>
                <div>
                    <h4>Easy Returns</h4>
                    <p>30-day return policy</p>
                </div>
            </div>

            <div class="shop-feature-item">
                <div class="shop-feature-icon"><i class="fa-solid fa-headset"></i></div>
                <div>
                    <h4>24/7 Support</h4>
                    <p>Always here to help</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>