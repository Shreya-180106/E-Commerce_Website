<aside class="admin-sidebar">
    <div class="admin-brand">
        <div class="brand-icon"><i class="fa-solid fa-store"></i></div>
        <div>
            <h2>ShopEase</h2>
            <p>Admin Panel</p>
        </div>
    </div>

    <nav class="admin-nav">
        <a href="dashboard.php" class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
            <i class="fa-solid fa-chart-line"></i>
            <span>Dashboard</span>
        </a>

        <a href="add-product.php" class="<?php echo ($current_page == 'add-product.php') ? 'active' : ''; ?>">
            <i class="fa-solid fa-plus"></i>
            <span>Add Product</span>
        </a>

        <a href="manage-products.php" class="<?php echo ($current_page == 'manage-products.php' || $current_page == 'edit-product.php') ? 'active' : ''; ?>">
            <i class="fa-solid fa-box-open"></i>
            <span>Manage Products</span>
        </a>

        <a href="orders.php" class="<?php echo ($current_page == 'orders.php') ? 'active' : ''; ?>">
            <i class="fa-solid fa-bag-shopping"></i>
            <span>Orders</span>
        </a>

        <a href="../index.php">
            <i class="fa-solid fa-house"></i>
            <span>Go to Website</span>
        </a>
    </nav>
</aside>