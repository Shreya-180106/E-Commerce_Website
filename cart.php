<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/* -----------------------------
   ADD PRODUCT TO CART
------------------------------ */
if (isset($_GET['add'])) {
    $product_id = (int) $_GET['add'];

    if ($product_id > 0) {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += 1;
        } else {
            $_SESSION['cart'][$product_id] = 1;
        }
    }

    header("Location: cart.php");
    exit;
}

/* -----------------------------
   REMOVE PRODUCT FROM CART
------------------------------ */
if (isset($_GET['remove'])) {
    $remove_id = (int) $_GET['remove'];

    if (isset($_SESSION['cart'][$remove_id])) {
        unset($_SESSION['cart'][$remove_id]);
    }

    header("Location: cart.php");
    exit;
}

/* -----------------------------
   UPDATE QUANTITIES
------------------------------ */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    if (isset($_POST['qty']) && is_array($_POST['qty'])) {
        foreach ($_POST['qty'] as $product_id => $qty) {
            $product_id = (int) $product_id;
            $qty = (int) $qty;

            if ($qty <= 0) {
                unset($_SESSION['cart'][$product_id]);
            } else {
                $_SESSION['cart'][$product_id] = $qty;
            }
        }
    }

    header("Location: cart.php");
    exit;
}

/* -----------------------------
   FETCH CART PRODUCTS
------------------------------ */
$cart_items = [];
$grand_total = 0;

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
                    'image' => $row['image'] ?? '',
                    'description' => $row['description'] ?? '',
                    'qty' => $qty,
                    'subtotal' => $subtotal
                ];
            }
        }
    }
}
?>

<section class="page-header cart-hero">
    <div class="container">
        <span class="badge">Your Shopping Bag</span>
        <h1 class="page-title">Cart Overview</h1>
        <p class="page-subtitle">
            Review your selected items, update quantities, and proceed to checkout when you're ready.
        </p>
    </div>
</section>

<section class="cart-section">
    <div class="container">
        <?php if (!empty($cart_items)) { ?>
            <div class="cart-layout">
                <!-- LEFT: CART ITEMS -->
                <div class="cart-main">
                    <form method="POST">
                        <div class="cart-card">
                            <div class="cart-card-header">
                                <div>
                                    <h2>Your Cart Items</h2>
                                    <p><?php echo count($cart_items); ?> product(s) in your cart</p>
                                </div>
                                <a href="products.php" class="btn-soft">Continue Shopping</a>
                            </div>

                            <div class="cart-items-list">
                                <?php foreach ($cart_items as $item) { ?>
                                    <div class="cart-item">
                                        <div class="cart-item-image">
                                            <?php if (!empty($item['image'])) { ?>
                                                <img src="<?php echo $item['image']; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                            <?php } else { ?>
                                                <img src="https://via.placeholder.com/180x140?text=Product" alt="Product">
                                            <?php } ?>
                                        </div>

                                        <div class="cart-item-content">
                                            <div class="cart-item-top">
                                                <div>
                                                    <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                                                    <p class="cart-item-desc">
                                                        <?php
                                                        $desc = $item['description'] ?? '';
                                                        echo htmlspecialchars(substr($desc, 0, 100));
                                                        if (strlen($desc) > 100) echo '...';
                                                        ?>
                                                    </p>
                                                </div>

                                                <a href="cart.php?remove=<?php echo $item['id']; ?>" class="remove-link">
                                                    <i class="fa-solid fa-trash"></i> Remove
                                                </a>
                                            </div>

                                            <div class="cart-item-bottom">
                                                <div class="cart-price-block">
                                                    <span class="cart-label">Price</span>
                                                    <strong>₹<?php echo number_format($item['price'], 2); ?></strong>
                                                </div>

                                                <div class="cart-qty-block">
                                                    <span class="cart-label">Quantity</span>
                                                    <input
                                                        type="number"
                                                        name="qty[<?php echo $item['id']; ?>]"
                                                        value="<?php echo $item['qty']; ?>"
                                                        min="1"
                                                        class="qty-input"
                                                    >
                                                </div>

                                                <div class="cart-price-block">
                                                    <span class="cart-label">Subtotal</span>
                                                    <strong class="subtotal-text">₹<?php echo number_format($item['subtotal'], 2); ?></strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="cart-actions-row">
                                <button type="submit" name="update_cart" class="btn">Update Cart</button>
                                <a href="products.php" class="btn-outline">Add More Products</a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- RIGHT: SUMMARY -->
                <aside class="cart-summary-wrap">
                    <div class="cart-summary-card">
                        <h3>Order Summary</h3>

                        <div class="summary-row">
                            <span>Items Total</span>
                            <strong>₹<?php echo number_format($grand_total, 2); ?></strong>
                        </div>

                        <div class="summary-row">
                            <span>Shipping</span>
                            <strong>Free</strong>
                        </div>

                        <div class="summary-row">
                            <span>Discount</span>
                            <strong>₹0.00</strong>
                        </div>

                        <div class="summary-divider"></div>

                        <div class="summary-row total-row">
                            <span>Grand Total</span>
                            <strong>₹<?php echo number_format($grand_total, 2); ?></strong>
                        </div>

                        <a href="checkout.php" class="btn checkout-btn">Proceed to Checkout</a>

                        <div class="summary-note">
                            <div class="summary-note-item">
                                <i class="fa-solid fa-shield-heart"></i>
                                <span>Secure checkout experience</span>
                            </div>
                            <div class="summary-note-item">
                                <i class="fa-solid fa-truck-fast"></i>
                                <span>Fast delivery on selected orders</span>
                            </div>
                            <div class="summary-note-item">
                                <i class="fa-solid fa-rotate-left"></i>
                                <span>Easy support & return assistance</span>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        <?php } else { ?>
            <div class="empty-cart-box">
                <div class="empty-cart-icon">
                    <i class="fa-solid fa-bag-shopping"></i>
                </div>
                <h2>Your cart is empty</h2>
                <p>
                    Looks like you haven’t added any products yet. Explore our collection and add your favorite items to the cart.
                </p>
                <a href="products.php" class="btn">Start Shopping</a>
            </div>
        <?php } ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>