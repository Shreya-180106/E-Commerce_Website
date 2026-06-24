<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cart_items = [];
$grand_total = 0;
$order_success = false;
$error_message = '';

/* FETCH CART ITEMS */
if (!empty($_SESSION['cart'])) {
    $ids = array_keys($_SESSION['cart']);
    $ids = array_map('intval', $ids);

    if (!empty($ids)) {
        $id_list = implode(',', $ids);
        $query = "SELECT * FROM products WHERE id IN ($id_list)";
        $result = mysqli_query($conn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $product_id = $row['id'];
                $qty = $_SESSION['cart'][$product_id];
                $subtotal = $row['price'] * $qty;
                $grand_total += $subtotal;

                $cart_items[] = [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'price' => $row['price'],
                    'qty' => $qty,
                    'subtotal' => $subtotal
                ];
            }
        }
    }
}

/* HANDLE ORDER SUBMISSION */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $zip = trim($_POST['zip'] ?? '');

    if (empty($_SESSION['cart'])) {
        $error_message = "Your cart is empty.";
    } elseif (
        $full_name === '' || $email === '' || $phone === '' ||
        $address === '' || $city === '' || $state === '' || $zip === ''
    ) {
        $error_message = "Please fill in all checkout details.";
    } else {
        $full_name = mysqli_real_escape_string($conn, $full_name);
        $email = mysqli_real_escape_string($conn, $email);
        $phone = mysqli_real_escape_string($conn, $phone);
        $address = mysqli_real_escape_string($conn, $address);
        $city = mysqli_real_escape_string($conn, $city);
        $state = mysqli_real_escape_string($conn, $state);
        $zip = mysqli_real_escape_string($conn, $zip);

        $order_query = "INSERT INTO orders (customer_name, email, phone, address, city, state, zip, total_amount)
                        VALUES ('$full_name', '$email', '$phone', '$address', '$city', '$state', '$zip', '$grand_total')";

        if (mysqli_query($conn, $order_query)) {
            $order_id = mysqli_insert_id($conn);

            foreach ($cart_items as $item) {
                $product_id = (int) $item['id'];
                $product_name = mysqli_real_escape_string($conn, $item['name']);
                $price = $item['price'];
                $qty = $item['qty'];
                $subtotal = $item['subtotal'];

                mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, product_name, price, quantity, subtotal)
                                     VALUES ($order_id, $product_id, '$product_name', '$price', '$qty', '$subtotal')");
            }

            $_SESSION['cart'] = [];
            $cart_items = [];
            $grand_total = 0;
            $order_success = true;
        } else {
            $error_message = "Error placing order: " . mysqli_error($conn);
        }
    }
}
?>

<section class="page-header checkout-hero">
    <div class="container">
        <span class="badge">Secure Checkout</span>
        <h1 class="page-title">Complete Your Order</h1>
        <p class="page-subtitle">
            Fill in your billing details and review your order summary before placing your order.
        </p>
    </div>
</section>

<section class="checkout-section">
    <div class="container">

        <?php if ($order_success): ?>

            <div class="checkout-success-box">
                <div class="success-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <h2>Order Placed Successfully 🎉</h2>
                <p>
                    Thank you for shopping with ShopEase. Your order has been placed and stored in the admin orders panel.
                </p>
                <div class="success-actions">
                    <a href="products.php" class="btn">Continue Shopping</a>
                    <a href="index.php" class="btn-outline">Back to Home</a>
                </div>
            </div>

        <?php elseif (empty($cart_items)): ?>

            <div class="empty-cart-box">
                <div class="empty-cart-icon">
                    <i class="fa-solid fa-bag-shopping"></i>
                </div>
                <h2>Your cart is empty</h2>
                <p>Add some products to your cart before proceeding to checkout.</p>
                <a href="products.php" class="btn">Browse Products</a>
            </div>

        <?php else: ?>

            <div class="checkout-layout">
                <div class="checkout-main">
                    <div class="checkout-form-card">
                        <div class="checkout-card-header">
                            <h2>Billing Details</h2>
                            <p>Enter your delivery and contact details to place the order.</p>
                        </div>

                        <?php if (!empty($error_message)): ?>
                            <div class="checkout-alert"><?php echo htmlspecialchars($error_message); ?></div>
                        <?php endif; ?>

                        <form method="POST" class="checkout-form">
                            <div class="checkout-grid">
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" name="full_name" required>
                                </div>

                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input type="email" name="email" required>
                                </div>

                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" name="phone" required>
                                </div>

                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" name="city" required>
                                </div>

                                <div class="form-group full-width">
                                    <label>Address</label>
                                    <textarea name="address" rows="4" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label>State</label>
                                    <input type="text" name="state" required>
                                </div>

                                <div class="form-group">
                                    <label>ZIP / Postal Code</label>
                                    <input type="text" name="zip" required>
                                </div>
                            </div>

                            <button type="submit" name="place_order" class="btn checkout-submit-btn">
                                Place Order
                            </button>
                        </form>
                    </div>
                </div>

                <aside class="checkout-summary-wrap">
                    <div class="checkout-summary-card">
                        <h3>Order Summary</h3>

                        <div class="checkout-summary-products">
                            <?php foreach ($cart_items as $item): ?>
                                <div class="checkout-summary-item">
                                    <div>
                                        <h4><?php echo htmlspecialchars($item['name']); ?></h4>
                                        <p>Qty: <?php echo $item['qty']; ?> × ₹<?php echo number_format($item['price'], 2); ?></p>
                                    </div>
                                    <strong>₹<?php echo number_format($item['subtotal'], 2); ?></strong>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="summary-divider"></div>

                        <div class="summary-row">
                            <span>Items Total</span>
                            <strong>₹<?php echo number_format($grand_total, 2); ?></strong>
                        </div>

                        <div class="summary-row">
                            <span>Shipping</span>
                            <strong>Free</strong>
                        </div>

                        <div class="summary-row total-row">
                            <span>Total Payable</span>
                            <strong>₹<?php echo number_format($grand_total, 2); ?></strong>
                        </div>
                    </div>
                </aside>
            </div>

        <?php endif; ?>

    </div>
</section>

<?php include 'includes/footer.php'; ?>