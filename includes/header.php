<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current_folder = basename(dirname($_SERVER['PHP_SELF']));
$is_admin = ($current_folder === 'admin');
$base = $is_admin ? '../' : '';
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopEase</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">
</head>
<body>

<header class="site-header">
    <div class="topbar">
        <div class="container topbar-inner">
            <p>Free shipping on orders above ₹999 • Soft pastel collection now live ✨</p>
        </div>
    </div>

    <div class="navbar-wrapper">
        <div class="container navbar">
            <!-- Logo -->
            <a href="<?php echo $base; ?>index.php" class="logo">
                <i class="fa-solid fa-bag-shopping"></i>
                <span>ShopEase</span>
            </a>

            <!-- Navigation -->
            <nav class="nav-menu">
                <a href="<?php echo $base; ?>index.php" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Home</a>
                <a href="<?php echo $base; ?>products.php" class="<?php echo ($current_page == 'products.php') ? 'active' : ''; ?>">Products</a>
                <a href="<?php echo $base; ?>index.php#categories">Categories</a>
                <a href="<?php echo $base; ?>index.php#about">About</a>
                <a href="<?php echo $base; ?>index.php#contact">Contact</a>
            </nav>

            <!-- Search -->
            <div class="nav-search">
                <input type="text" placeholder="Search products...">
                <button type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>

            <!-- Actions -->
            <div class="nav-actions">
                <a href="<?php echo $base; ?>login.php" class="icon-btn" title="Account">
                    <i class="fa-regular fa-user"></i>
                </a>

                <a href="<?php echo $base; ?>cart.php" class="icon-btn" title="Cart">
                    <i class="fa-solid fa-cart-shopping"></i>
                </a>

                <a href="<?php echo $base; ?>admin/dashboard.php" class="dashboard-btn">
                    Admin
                </a>

                <?php if (isset($_SESSION['user_id'])) { ?>
                    <a href="<?php echo $base; ?>logout.php" class="auth-btn">Logout</a>
                <?php } else { ?>
                    <a href="<?php echo $base; ?>register.php" class="auth-btn">Sign Up</a>
                <?php } ?>
            </div>
        </div>
    </div>
</header>

<main>