<?php
include '../includes/db.php';
include '../includes/header.php';

if (!isset($_GET['id'])) {
    echo "<p>Product not found.</p>";
    include '../includes/footer.php';
    exit;
}

$product_id = intval($_GET['id']);
$query = "SELECT * FROM products WHERE id = $product_id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo "<p>Product not found.</p>";
    include '../includes/footer.php';
    exit;
}

$product = mysqli_fetch_assoc($result);
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $description = mysqli_real_escape_string($conn, trim($_POST['description']));
    $price = floatval($_POST['price']);
    $category = mysqli_real_escape_string($conn, trim($_POST['category']));
    $image = mysqli_real_escape_string($conn, trim($_POST['image']));

    $update_query = "UPDATE products 
                     SET name='$name', description='$description', price='$price', category='$category', image='$image'
                     WHERE id=$product_id";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Product updated successfully!'); window.location='dashboard.php';</script>";
        exit;
    } else {
        $message = "Failed to update product.";
    }
}
?>

<div class="form-container">
    <h2>Edit Product</h2>

    <?php if (!empty($message)) { ?>
        <p class="error-message"><?php echo $message; ?></p>
    <?php } ?>

    <form method="POST">
        <input type="text" name="name" value="<?php echo $product['name']; ?>" required>
        <textarea name="description" required><?php echo $product['description']; ?></textarea>
        <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required>
        <input type="text" name="category" value="<?php echo $product['category']; ?>" required>
        <input type="text" name="image" value="<?php echo $product['image']; ?>" required>
        <button type="submit" class="btn">Update Product</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>