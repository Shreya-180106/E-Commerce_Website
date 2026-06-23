<?php
include '../includes/db.php';

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    mysqli_query($conn, "DELETE FROM products WHERE id = $product_id");
}

header("Location: dashboard.php");
exit;
?>