<?php
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first.'); window.location='login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch cart items
$query = "
    SELECT cart.product_id, cart.quantity, products.name, products.price
    FROM cart
    INNER JOIN products ON cart.product_id = products.id
    WHERE cart.user_id = $user_id
";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo "<script>alert('Your cart is empty.'); window.location='products.php';</script>";
    exit;
}

$cart_items = [];
$total = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $cart_items[] = $row;
    $total += $row['price'] * $row['quantity'];
}

// Place order
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Insert into orders table
    $order_query = "INSERT INTO orders (user_id, total_price) VALUES ($user_id, $total)";
    mysqli_query($conn, $order_query);

    $order_id = mysqli_insert_id($conn);

    // Insert into order_items
    foreach ($cart_items as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $price = $item['price'];

        $item_query = "INSERT INTO order_items (order_id, product_id, quantity, price)
                       VALUES ($order_id, $product_id, $quantity, $price)";
        mysqli_query($conn, $item_query);
    }

    // Clear cart
    $clear_query = "DELETE FROM cart WHERE user_id = $user_id";
    mysqli_query($conn, $clear_query);

    echo "<script>alert('Order placed successfully!'); window.location='index.php';</script>";
    exit;
}
?>

<h2 class="page-title">Checkout</h2>

<div class="checkout-container">
    <h3>Order Summary</h3>

    <table class="cart-table">
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>

        <?php foreach ($cart_items as $item) { 
            $subtotal = $item['price'] * $item['quantity'];
        ?>
        <tr>
            <td><?php echo $item['name']; ?></td>
            <td>₹<?php echo $item['price']; ?></td>
            <td><?php echo $item['quantity']; ?></td>
            <td>₹<?php echo $subtotal; ?></td>
        </tr>
        <?php } ?>
    </table>

    <h3>Total Amount: ₹<?php echo $total; ?></h3>

    <form method="POST">
        <button type="submit" class="btn">Place Order</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>