<?php
include '../includes/db.php';
include '../includes/header.php';

$product_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM products"))['total'];
$user_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users"))['total'];
$order_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders"))['total'];
?>

<h2 class="page-title">Admin Dashboard</h2>

<div class="dashboard-cards">
    <div class="dashboard-card">
        <h3>Total Products</h3>
        <p><?php echo $product_count; ?></p>
    </div>

    <div class="dashboard-card">
        <h3>Total Users</h3>
        <p><?php echo $user_count; ?></p>
    </div>

    <div class="dashboard-card">
        <h3>Total Orders</h3>
        <p><?php echo $order_count; ?></p>
    </div>
</div>

<div class="admin-links">
    <a href="add-product.php" class="btn">Add Product</a>
    <a href="orders.php" class="btn">View Orders</a>
</div>

<?php include '../includes/footer.php'; ?>