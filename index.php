<?php
include 'includes/db.php';
include 'includes/header.php';

$query = "SELECT * FROM products ORDER BY id DESC LIMIT 4";
$result = mysqli_query($conn, $query);
?>

<section class="hero">
    <div class="hero-content">
        <h2>Welcome to ShopEasy</h2>
        <p>Discover the best products at the best prices.</p>
        <a href="products.php" class="btn">Shop Now</a>
    </div>
</section>

<section class="featured-products">
    <h2>Featured Products</h2>
    <div class="product-grid">
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <div class="product-card">
                <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                <h3><?php echo $row['name']; ?></h3>
                <p>₹<?php echo $row['price']; ?></p>
                <a href="product-details.php?id=<?php echo $row['id']; ?>" class="btn">View Details</a>
            </div>
        <?php } ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>