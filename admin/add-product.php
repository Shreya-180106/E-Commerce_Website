<?php
include '../includes/db.php';

$page_title = "Add Product | ShopEase Admin";
$page_badge = "Create Product";
$page_heading = "Add New Product";
$page_description = "Add a product with category, price, image and description.";

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $image = trim($_POST['image'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($name === '' || $price === '' || $description === '' || $category === '') {
        $message = '<div class="admin-alert error">Please fill all required fields.</div>';
    } else {
        $name = mysqli_real_escape_string($conn, $name);
        $price = mysqli_real_escape_string($conn, $price);
        $image = mysqli_real_escape_string($conn, $image);
        $category = mysqli_real_escape_string($conn, $category);
        $description = mysqli_real_escape_string($conn, $description);

        $query = "INSERT INTO products (name, price, image, category, description)
                  VALUES ('$name', '$price', '$image', '$category', '$description')";

        if (mysqli_query($conn, $query)) {
            $message = '<div class="admin-alert success">Product added successfully 🎉</div>';
        } else {
            $message = '<div class="admin-alert error">Error adding product: ' . mysqli_error($conn) . '</div>';
        }
    }
}

include 'includes/admin-header.php';
include 'includes/admin-sidebar.php';
?>

<main class="admin-main">
    <div class="admin-topbar">
        <div>
            <span class="badge"><?php echo $page_badge; ?></span>
            <h1><?php echo $page_heading; ?></h1>
            <p><?php echo $page_description; ?></p>
        </div>
    </div>

    <section class="admin-form-card">
        <div class="admin-panel-header">
            <div>
                <h2>Product Details</h2>
                <p>Fill all required information to add a new product.</p>
            </div>
        </div>

        <?php echo $message; ?>

        <form method="POST" class="admin-form">
            <div class="admin-form-grid">
                <div class="form-group">
                    <label>Product Name *</label>
                    <input type="text" name="name" placeholder="Enter product name" required>
                </div>

                <div class="form-group">
                    <label>Product Price *</label>
                    <input type="number" step="0.01" name="price" placeholder="Enter product price" required>
                </div>

                <div class="form-group">
                    <label>Category *</label>
                    <select name="category" required>
                        <option value="">Select category</option>
                        <option value="Clothing">Clothing</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Footwear">Footwear</option>
                        <option value="Beauty">Beauty</option>
                        <option value="Accessories">Accessories</option>
                        <option value="Home Decor">Home Decor</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Product Image URL</label>
                    <input type="text" name="image" placeholder="Paste image URL">
                </div>

                <div class="form-group full-width">
                    <label>Description *</label>
                    <textarea name="description" rows="6" placeholder="Write product description..." required></textarea>
                </div>
            </div>

            <div class="admin-form-actions">
                <button type="submit" name="add_product" class="btn">Add Product</button>
                <a href="manage-products.php" class="btn-outline">Manage Products</a>
            </div>
        </form>
    </section>

<?php include 'includes/admin-footer.php'; ?>