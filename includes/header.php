<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$current_folder = basename(dirname($_SERVER['PHP_SELF']));
$is_admin = ($current_folder === 'admin');

$base = $is_admin ? '../' : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Website</title>
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">
</head>
<body>

<header>
    <div class="container nav-container">
        <h1 class="logo">
            <a href="<?php echo $base; ?>index.php">ShopEasy</a>
        </h1>

        <nav>
            <ul>
                <li><a href="<?php echo $base; ?>index.php">Home</a></li>
                <li><a href="<?php echo $base; ?>products.php">Products</a></li>
                <li><a href="<?php echo $base; ?>cart.php">Cart</a></li>

                <?php if(isset($_SESSION['user_id'])) { ?>
                    <li><a href="<?php echo $base; ?>checkout.php">Checkout</a></li>
                    <li><a href="<?php echo $base; ?>logout.php">Logout</a></li>
                <?php } else { ?>
                    <li><a href="<?php echo $base; ?>login.php">Login</a></li>
                    <li><a href="<?php echo $base; ?>register.php">Register</a></li>
                <?php } ?>

                <!-- Dashboard visible everywhere -->
                <li><a href="<?php echo $base; ?>admin/dashboard.php">Dashboard</a></li>

                <!-- Admin-only extra links -->
                <?php if ($is_admin) { ?>
                    <li><a href="<?php echo $base; ?>admin/add-product.php">Add Product</a></li>
                    <li><a href="<?php echo $base; ?>admin/orders.php">Orders</a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</header>

<main class="container">