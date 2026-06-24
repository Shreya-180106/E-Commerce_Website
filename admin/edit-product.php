<?php
include '../includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: manage-products.php");
    exit;
}

$id = (int) $_GET['id'];
$product_query = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");

if (!$product_query || mysqli_num_rows($product_query) === 0) {
    header("Location: manage-products.php");
    exit;
}

$product = mysqli_fetch_assoc($product_query);
$message = '';

$page_title = "Edit Product | ShopEase Admin";
$page_badge = "Update Product";
$page_heading = "Edit Product";
$page_description = "Modify the product details and save changes to your store catalog.";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
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

        $update_query = "UPDATE products 
                         SET name='$name', price='$price', image='$image', category='$category', description='$description'
                         WHERE id=$id";

        if (mysqli_query($conn, $update_query)) {
            $message = '<div class="admin-alert success">Product updated successfully 🎉</div>';
            $product_query = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
            $product = mysqli_fetch_assoc($product_query);
        } else {
            $message = '<div class="admin-alert error">Error updating product: ' . mysqli_error($conn) . '</div>';
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
                <h2>Edit Product Details</h2>
                <p>Update product name, category, price, image and description.</p>
            </div>
        </div>

        <?php echo $message; ?>

        <form method="POST" class="admin-form">
            <div class="admin-form-grid">
                <div class="form-group">
                    <label>Product Name *</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Product Price *</label>
                    <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Category *</label>
                    <select name="category" required>
                        <?php
                        $categories = ['Clothing', 'Electronics', 'Footwear', 'Beauty', 'Accessories', 'Home Decor'];
                        foreach ($categories as $cat) {
                            $selected = ($product['category'] === $cat) ? 'selected' : '';
                            echo "<option value=\"$cat\" $selected>$cat</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Product Image URL</label>
                    <input type="text" name="image" value="<?php echo htmlspecialchars($product['image']); ?>">
                </div>

                <div class="form-group full-width">
                    <label>Description *</label>
                    <textarea name="description" rows="6" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                </div>
            </div>

            <div class="admin-form-actions">
                <button type="submit" name="update_product" class="btn">Update Product</button>
                <a href="manage-products.php" class="btn-outline">Back to Products</a>
            </div>
        </form>
    </section>

<?php include 'includes/admin-footer.php'; ?>