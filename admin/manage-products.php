<?php
include '../includes/db.php';

$page_title = "Manage Products | ShopEase Admin";
$page_badge = "Catalog Control";
$page_heading = "Manage Products";
$page_description = "View, edit and delete your store products.";

/* DELETE PRODUCT */
if (isset($_GET['delete'])) {
    $delete_id = (int) $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE id = $delete_id");
    header("Location: manage-products.php");
    exit;
}

$products = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");

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

    <section class="admin-panel-card">
        <div class="admin-panel-header">
            <div>
                <h2>All Products</h2>
                <p>Complete product list with categories and actions.</p>
            </div>
            <a href="add-product.php" class="btn">+ Add Product</a>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th style="width: 220px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($products && mysqli_num_rows($products) > 0) { ?>
                        <?php while ($row = mysqli_fetch_assoc($products)) { ?>
                            <tr>
                                <td>#<?php echo $row['id']; ?></td>
                                <td>
                                    <?php if (!empty($row['image'])) { ?>
                                        <img src="<?php echo $row['image']; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="admin-product-thumb">
                                    <?php } else { ?>
                                        <div class="admin-thumb-placeholder">No Image</div>
                                    <?php } ?>
                                </td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['category'] ?? 'General'); ?></td>
                                <td>₹<?php echo number_format($row['price'], 2); ?></td>
                                <td>
                                    <?php
                                    $desc = $row['description'] ?? '';
                                    echo htmlspecialchars(substr($desc, 0, 80));
                                    if (strlen($desc) > 80) echo '...';
                                    ?>
                                </td>
                                <td>
                                    <div class="admin-action-group">
                                        <a href="edit-product.php?id=<?php echo $row['id']; ?>" class="action-btn edit-btn">Edit</a>
                                        <a href="../product-details.php?id=<?php echo $row['id']; ?>" class="action-btn view-btn">View</a>
                                        <a href="manage-products.php?delete=<?php echo $row['id']; ?>"
                                           class="action-btn delete-btn"
                                           onclick="return confirm('Are you sure you want to delete this product?');">
                                           Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="7">No products available.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>

<?php include 'includes/admin-footer.php'; ?>