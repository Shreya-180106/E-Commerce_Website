<?php
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_GET['id'])) {
    echo "<p>Product not found.</p>";
    include 'includes/footer.php';
    exit;
}

$product_id = intval($_GET['id']);

$query = "SELECT * FROM products WHERE id = $product_id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo "<p>Product not found.</p>";
    include 'includes/footer.php';
    exit;
}

$product = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('Please login first to add product to cart.'); window.location='login.php';</script>";
        exit;
    }

    $user_id = $_SESSION['user_id'];

    // Check if product already in cart
    $check_query = "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $update_query = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = $user_id AND product_id = $product_id";
        mysqli_query($conn, $update_query);
    } else {
        $insert_query = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, 1)";
        mysqli_query($conn, $insert_query);
    }

    echo "<script>alert('Product added to cart successfully!'); window.location='cart.php';</script>";
    exit;
}
?>

<div class="product-details">
    <div class="product-image">
        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
    </div>

    <div class="product-info">
        <h2><?php echo $product['name']; ?></h2>
        <p class="price">₹<?php echo $product['price']; ?></p>
        <p><?php echo $product['description']; ?></p>
        <p><strong>Category:</strong> <?php echo $product['category']; ?></p>

        <form method="POST">
            <button type="submit" class="btn">Add to Cart</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>