<?php
include '../includes/db.php';

/* PAGE SETTINGS */
$page_title = "Admin Dashboard | ShopEase";
$page_badge = "Admin Overview";
$page_heading = "Dashboard";
$page_description = "Manage products, monitor store data, and control your ShopEase website from one place.";

/* TOTAL PRODUCTS */
$product_count = 0;
$product_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM products");
if ($product_query && mysqli_num_rows($product_query) > 0) {
    $product_count = mysqli_fetch_assoc($product_query)['total'];
}

/* LATEST PRODUCTS */
$latest_products = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC LIMIT 5");

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

    <section class="admin-stats-grid">
        <div class="admin-stat-card">
            <div class="admin-stat-icon"><i class="fa-solid fa-box"></i></div>
            <div>
                <h3>Total Products</h3>
                <p><?php echo $product_count; ?> product(s) available</p>
            </div>
        </div>

        <div class="admin-stat-card">
            <div class="admin-stat-icon"><i class="fa-solid fa-cart-shopping"></i></div>
            <div>
                <h3>Orders Module</h3>
                <p>Track customer orders and checkout activity</p>
            </div>
        </div>

        <div class="admin-stat-card">
            <div class="admin-stat-icon"><i class="fa-solid fa-users"></i></div>
            <div>
                <h3>Customers</h3>
                <p>User/customer module can be integrated later</p>
            </div>
        </div>

        <div class="admin-stat-card">
            <div class="admin-stat-icon"><i class="fa-solid fa-chart-pie"></i></div>
            <div>
                <h3>Store Growth</h3>
                <p>Track analytics after advanced admin upgrade</p>
            </div>
        </div>
    </section>

    <section class="admin-quick-grid">
        <a href="add-product.php" class="admin-quick-card">
            <div class="quick-icon"><i class="fa-solid fa-plus"></i></div>
            <h3>Add New Product</h3>
            <p>Create a new product listing with image, price, and description.</p>
        </a>

        <a href="manage-products.php" class="admin-quick-card">
            <div class="quick-icon"><i class="fa-solid fa-pen-to-square"></i></div>
            <h3>Manage Products</h3>
            <p>View, edit, and delete existing products from your catalog.</p>
        </a>

        <a href="../products.php" class="admin-quick-card">
            <div class="quick-icon"><i class="fa-solid fa-eye"></i></div>
            <h3>Preview Store</h3>
            <p>Check how products appear on the user-facing website pages.</p>
        </a>
    </section>

    <section class="admin-panel-card">
        <div class="admin-panel-header">
            <div>
                <h2>Recently Added Products</h2>
                <p>Quick preview of the latest products added to your store.</p>
            </div>
            <a href="manage-products.php" class="btn-soft">View All</a>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($latest_products && mysqli_num_rows($latest_products) > 0) { ?>
                        <?php while ($row = mysqli_fetch_assoc($latest_products)) { ?>
                            <tr>
                                <td>#<?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td>₹<?php echo number_format($row['price'], 2); ?></td>
                                <td>
                                    <?php
                                    $desc = $row['description'] ?? '';
                                    echo htmlspecialchars(substr($desc, 0, 70));
                                    if (strlen($desc) > 70) echo '...';
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="4">No products found yet.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>

<?php include 'includes/admin-footer.php'; ?>