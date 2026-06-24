<?php
include 'includes/db.php';
include 'includes/header.php';

/* Fetch featured products */
$featured_products = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC LIMIT 8");
?>

<!-- HERO SECTION -->
<section class="hero-section">
    <div class="container hero-grid">
        <div class="hero-content">
            <span class="badge">Curated Collection</span>
            <h1>Modern shopping with a calm, premium experience</h1>
            <p>
                Discover fashion, electronics, beauty, and lifestyle essentials in one elegant place.
                ShopEase brings together curated products, clean design, and a smooth shopping journey.
            </p>

            <div class="hero-buttons">
                <a href="products.php" class="btn">Shop Now</a>
                <a href="#featured-products" class="btn-outline">Explore Products</a>
            </div>

            <div class="hero-highlights">
                <div class="highlight-pill">
                    <i class="fa-solid fa-truck-fast"></i>
                    <span>Fast Delivery</span>
                </div>
                <div class="highlight-pill">
                    <i class="fa-solid fa-shield-heart"></i>
                    <span>Secure Checkout</span>
                </div>
                <div class="highlight-pill">
                    <i class="fa-solid fa-box-open"></i>
                    <span>Curated Picks</span>
                </div>
            </div>
        </div>

        <div class="hero-visual">
            <div class="hero-main-image">
                <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=1200&q=80" alt="ShopEase collection">
            </div>

            <div class="hero-mini-card hero-mini-card-top">
                <div class="mini-icon">
                    <i class="fa-solid fa-star"></i>
                </div>
                <div>
                    <h4>Trending Picks</h4>
                    <p>Fresh products added weekly</p>
                </div>
            </div>

            <div class="hero-mini-card hero-mini-card-bottom">
                <div class="mini-price-badge">30% OFF</div>
                <div>
                    <h4>Exclusive Offers</h4>
                    <p>Selected products on special deals</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TRUST / FEATURES -->
<section class="features-section">
    <div class="container">
        <div class="feature-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-truck-fast"></i></div>
                <h3>Fast Delivery</h3>
                <p>Quick and reliable delivery with smooth order tracking.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-credit-card"></i></div>
                <h3>Secure Payments</h3>
                <p>Safe checkout experience with trusted payment methods.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-rotate-left"></i></div>
                <h3>Easy Returns</h3>
                <p>Simple return process for a better shopping experience.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-award"></i></div>
                <h3>Quality Products</h3>
                <p>Carefully selected items across every category we offer.</p>
            </div>
        </div>
    </div>
</section>

<!-- FEATURED PRODUCTS -->
<section class="featured-products-section" id="featured-products">
    <div class="container">
        <div class="section-heading">
            <div>
                <span class="badge">Featured Products</span>
                <h2 class="section-title">Trending right now</h2>
                <p class="section-subtitle">
                    Discover some of our latest and most popular products across multiple categories.
                </p>
            </div>
            <a href="products.php" class="btn-soft">View All</a>
        </div>

        <div class="product-grid">
            <?php if ($featured_products && mysqli_num_rows($featured_products) > 0) { ?>
                <?php while ($product = mysqli_fetch_assoc($featured_products)) { ?>
                    <div class="product-card">
                        <div class="product-thumb">
                            <?php if (!empty($product['image'])) { ?>
                                <img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <?php } else { ?>
                                <img src="https://via.placeholder.com/600x600?text=Product" alt="Product">
                            <?php } ?>

                            <span class="product-badge">Featured</span>
                        </div>

                        <div class="product-body">
                            <p class="product-category">
                                <?php echo !empty($product['category']) ? htmlspecialchars($product['category']) : 'General'; ?>
                            </p>

                            <h3 class="product-title">
                                <?php echo htmlspecialchars($product['name']); ?>
                            </h3>

                            <p class="product-price">₹<?php echo number_format($product['price'], 2); ?></p>

                            <p class="product-desc">
                                <?php
                                $desc = isset($product['description']) ? trim($product['description']) : '';
                                echo htmlspecialchars(substr($desc, 0, 90));
                                if (strlen($desc) > 90) echo '...';
                                ?>
                            </p>

                            <div class="product-actions">
                                <a href="product-details.php?id=<?php echo $product['id']; ?>" class="btn-outline small-btn">View</a>
                                <a href="cart.php?add=<?php echo $product['id']; ?>" class="btn small-btn">Add to Cart</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="empty-state" style="grid-column: 1 / -1;">
                    No products available yet. Add products from the admin panel to show them here.
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<!-- CATEGORIES -->
<section class="categories-section" id="categories">
    <div class="container">
        <div class="section-heading center-heading">
            <div>
                <span class="badge">Shop by Category</span>
                <h2 class="section-title">Explore popular categories</h2>
                <p class="section-subtitle">
                    Browse stylish and useful collections curated for everyday shopping.
                </p>
            </div>
        </div>

        <div class="category-grid">
            <div class="category-card category-large">
                <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&w=1200&q=80" alt="Fashion">
                <div class="category-overlay">
                    <span>Fashion</span>
                    <h3>Elegant everyday style</h3>
                    <a href="products.php" class="btn-soft">Shop Now</a>
                </div>
            </div>

            <div class="category-card">
                <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=1200&q=80" alt="Electronics">
                <div class="category-overlay">
                    <span>Electronics</span>
                    <h3>Smart gadgets</h3>
                    <a href="products.php" class="btn-soft">Explore</a>
                </div>
            </div>

            <div class="category-card">
                <img src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=1200&q=80" alt="Beauty">
                <div class="category-overlay">
                    <span>Beauty</span>
                    <h3>Glow & care essentials</h3>
                    <a href="products.php" class="btn-soft">Explore</a>
                </div>
            </div>

            <div class="category-card">
                <img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1200&q=80" alt="Home & Living">
                <div class="category-overlay">
                    <span>Home & Living</span>
                    <h3>Comfort for your space</h3>
                    <a href="products.php" class="btn-soft">Explore</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PROMO STRIP -->
<section class="promo-section">
    <div class="container promo-grid">
        <div class="promo-card promo-light">
            <span class="badge">New Arrivals</span>
            <h2>Fresh additions for your collection</h2>
            <p>Explore recently added products designed for style, comfort, and convenience.</p>
            <a href="products.php" class="btn">Browse Now</a>
        </div>

        <div class="promo-card promo-dark">
            <span class="badge badge-dark">Best Sellers</span>
            <h2>Customer favourites, all in one place</h2>
            <p>Discover top-loved products that shoppers keep coming back for.</p>
            <a href="products.php" class="btn-outline light-outline">Shop Best Sellers</a>
        </div>
    </div>
</section>

<!-- ABOUT -->
<section class="about-section" id="about">
    <div class="container about-grid">
        <div class="about-image-wrap">
            <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=1200&q=80" alt="About ShopEase">
        </div>

        <div class="about-content">
            <span class="badge">About ShopEase</span>
            <h2 class="section-title">A calm, modern shopping experience for everyday essentials</h2>
            <p>
                ShopEase is an e-commerce platform designed to make shopping simple, elegant, and enjoyable.
                From fashion and beauty to electronics and home products, everything is organised into a clean,
                easy-to-browse experience.
            </p>

            <div class="about-points">
                <div class="about-point">
                    <i class="fa-solid fa-check"></i>
                    <span>Curated products across multiple categories</span>
                </div>
                <div class="about-point">
                    <i class="fa-solid fa-check"></i>
                    <span>Clean UI with a premium shopping feel</span>
                </div>
                <div class="about-point">
                    <i class="fa-solid fa-check"></i>
                    <span>Simple browsing, cart, and order flow</span>
                </div>
            </div>

            <a href="products.php" class="btn">Start Shopping</a>
        </div>
    </div>
</section>

<!-- NEWSLETTER -->
<section class="newsletter-section" id="contact">
    <div class="container">
        <div class="newsletter-box">
            <div class="newsletter-text">
                <span class="badge">Stay Updated</span>
                <h2>Get offers, launches, and shopping updates</h2>
                <p>Join the ShopEase newsletter to stay updated with new arrivals and special deals.</p>
            </div>

            <form class="newsletter-form">
                <input type="email" placeholder="Enter your email address">
                <button type="button" class="btn">Subscribe</button>
            </form>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>