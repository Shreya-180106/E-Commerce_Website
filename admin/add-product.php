<?php
include '../includes/db.php';
include '../includes/header.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $description = mysqli_real_escape_string($conn, trim($_POST['description']));
    $price = floatval($_POST['price']);
    $category = mysqli_real_escape_string($conn, trim($_POST['category']));
    $image = mysqli_real_escape_string($conn, trim($_POST['image']));

    if (empty($name) || empty($description) || empty($price) || empty($category) || empty($image)) {
        $message = "All fields are required.";
    } else {
        $query = "INSERT INTO products (name, description, price, image, category)
                  VALUES ('$name', '$description', '$price', '$image', '$category')";

        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Product added successfully!'); window.location='dashboard.php';</script>";
            exit;
        } else {
            $message = "Failed to add product.";
        }
    }
}
?>

<div class="form-container">
    <h2>Add Product</h2>

    <?php if (!empty($message)) { ?>
        <p class="error-message"><?php echo $message; ?></p>
    <?php } ?>

    <form method="POST">
        <input type="text" name="name" placeholder="Product Name" required>
        <textarea name="description" placeholder="Product Description" required></textarea>
        <input type="number" step="0.01" name="price" placeholder="Price" required>
        <input type="text" name="category" placeholder="Category" required>
        <input type="text" name="image" placeholder="Image Path (e.g. assets/images/products/item.jpg)" required>
        <button type="submit" class="btn">Add Product</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>