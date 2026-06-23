<?php
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first.'); window.location='login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];

// Remove item from cart
if (isset($_GET['remove'])) {
    $cart_id = intval($_GET['remove']);
    $delete_query = "DELETE FROM cart WHERE id = $cart_id AND user_id = $user_id";
    mysqli_query($conn, $delete_query);
    echo "<script>alert('Item removed from cart.'); window.location='cart.php';</script>";
    exit;
}

// Fetch cart items
$query = "
    SELECT cart.id AS cart_id, cart.quantity, products.id AS product_id, products.name, products.price, products.image
    FROM cart
    INNER JOIN products ON cart.product_id = products.id
    WHERE cart.user_id = $user_id
";
$result = mysqli_query($conn, $query);

$total = 0;
?>

<h2 class="page-title">Your Cart</h2>

<?php if (mysqli_num_rows($result) > 0) { ?>
    <table class="cart-table">
        <tr>
            <th>Product</th>
            <th>Image</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
            <th>Action</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { 
            $subtotal = $row['price'] * $row['quantity'];
            $total += $subtotal;
        ?>
        <tr>
            <td><?php echo $row['name']; ?></td>
            <td><img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" class="cart-img"></td>
            <td>₹<?php echo $row['price']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td>₹<?php echo $subtotal; ?></td>
            <td>
                <a href="cart.php?remove=<?php echo $row['cart_id']; ?>" class="btn danger-btn">Remove</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <div class="cart-summary">
        <h3>Total: ₹<?php echo $total; ?></h3>
        <a href="checkout.php" class="btn">Proceed to Checkout</a>
    </div>

<?php } else { ?>
    <p>Your cart is empty.</p>
<?php } ?>

<?php include 'includes/footer.php'; ?>