<?php
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo '<div class="container"><div class="empty-state" style="margin-top:40px;">Invalid product ID.</div></div>';
    include 'includes/footer.php';
    exit;
}

$id = (int) $_GET['id'];
$query = "SELECT * FROM products WHERE id = $id LIMIT 1";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo '<div class="container"><div class="empty-state" style="margin-top:40px;">Product not found.</div></div>';
    include 'includes/footer.php';
    exit;
}

$product = mysqli_fetch_assoc($result);
?>

<section class="page-header product-detail-hero">
    <div class="container">
        <span class="badge">Product Details</span>
        <h1 class="page-title"><?php echo htmlspecialchars($product['name']); ?></h1>
        <p class="page-subtitle">
            Explore detailed information, pricing, and purchase options for this product.
        </p>
    </div>
</section>

<section class="product-detail-section">
    <div class="container">
        <div class="product-detail-card">
            <!-- Left: Image -->
            <div class="product-detail-image-wrap">
                <?php if (!empty($product['image'])) { ?>
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-detail-image">
                <?php } else { ?>
                    <img src="https://via.placeholder.com/600x500?text=Product+Image" alt="Product" class="product-detail-image">
                <?php } ?>
            </div>

            <!-- Right: Content -->
            <div class="product-detail-content">
                <span class="detail-tag">Premium Pick</span>
                <h2><?php echo htmlspecialchars($product['name']); ?></h2>

                <div class="detail-rating">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half-stroke"></i>
                    <span>4.8 Rating</span>
                </div>

                <p class="detail-price">₹<?php echo number_format($product['price'], 2); ?></p>

                <p class="detail-description">
                    <?php
                    echo !empty($product['description'])
                        ? nl2br(htmlspecialchars($product['description']))
                        : 'This product is part of our curated collection and designed to deliver both style and functionality.';
                    ?>
                </p>

                <div class="detail-feature-list">
                    <div class="detail-feature">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Carefully curated quality product</span>
                    </div>
                    <div class="detail-feature">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Secure order placement & smooth checkout</span>
                    </div>
                    <div class="detail-feature">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Elegant shopping experience with ShopEase</span>
                    </div>
                </div>

                <div class="detail-action-row">
                    <a href="cart.php?add=<?php echo $product['id']; ?>" class="btn">Add to Cart</a>
                    <a href="products.php" class="btn-outline">Back to Products</a>
                </div>

                <div class="detail-info-grid">
                    <div class="detail-info-card">
                        <i class="fa-solid fa-truck-fast"></i>
                        <div>
                            <h4>Fast Delivery</h4>
                            <p>Quick and reliable shipping on selected orders.</p>
                        </div>
                    </div>

                    <div class="detail-info-card">
                        <i class="fa-solid fa-rotate-left"></i>
                        <div>
                            <h4>Easy Returns</h4>
                            <p>Simple return assistance and customer support.</p>
                        </div>
                    </div>

                    <div class="detail-info-card">
                        <i class="fa-solid fa-shield-heart"></i>
                        <div>
                            <h4>Secure Checkout</h4>
                            <p>Protected purchase flow for a safe experience.</p>
                        </div>
                    </div>

                    <div class="detail-info-card">
                        <i class="fa-solid fa-gift"></i>
                        <div>
                            <h4>Exclusive Offers</h4>
                            <p>Shop more and unlock special discounts.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related CTA -->
        <div class="product-detail-bottom-cta">
            <div>
                <span class="badge">Need More?</span>
                <h3>Explore more products from our collection</h3>
                <p>Browse additional items and discover new favorites for your cart.</p>
            </div>
            <a href="products.php" class="btn">Continue Shopping</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>