<?php
include 'includes/db.php';
include 'includes/header.php';

$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);
?>

<h2 class="page-title">All Products</h2>

<div class="product-grid">
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <div class="product-card">
            <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
            <h3><?php echo $row['name']; ?></h3>
            <p><?php echo substr($row['description'], 0, 60); ?>...</p>
            <p><strong>₹<?php echo $row['price']; ?></strong></p>
            <a href="product-details.php?id=<?php echo $row['id']; ?>" class="btn">View Details</a>
        </div>
    <?php } ?>
</div>

<?php include 'includes/footer.php'; ?>