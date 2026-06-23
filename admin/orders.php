<?php
include '../includes/db.php';
include '../includes/header.php';

$query = "
    SELECT orders.id, users.name AS user_name, orders.total_price, orders.order_date
    FROM orders
    INNER JOIN users ON orders.user_id = users.id
    ORDER BY orders.order_date DESC
";
$result = mysqli_query($conn, $query);
?>

<h2 class="page-title">All Orders</h2>

<?php if (mysqli_num_rows($result) > 0) { ?>
    <table class="cart-table">
        <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Total Price</th>
            <th>Order Date</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td>#<?php echo $row['id']; ?></td>
            <td><?php echo $row['user_name']; ?></td>
            <td>₹<?php echo $row['total_price']; ?></td>
            <td><?php echo $row['order_date']; ?></td>
        </tr>
        <?php } ?>
    </table>
<?php } else { ?>
    <p>No orders found.</p>
<?php } ?>

<?php include '../includes/footer.php'; ?>