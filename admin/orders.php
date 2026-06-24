<?php
include '../includes/db.php';

$page_title = "Orders | ShopEase Admin";
$page_badge = "Order Management";
$page_heading = "Customer Orders";
$page_description = "Track placed orders, review customer information, and monitor checkout activity from one place.";

$orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC");

$total_orders = 0;
$total_revenue = 0;

$stats_query = mysqli_query($conn, "SELECT COUNT(*) AS total_orders, SUM(total_amount) AS total_revenue FROM orders");
if ($stats_query && mysqli_num_rows($stats_query) > 0) {
    $stats = mysqli_fetch_assoc($stats_query);
    $total_orders = $stats['total_orders'] ?? 0;
    $total_revenue = $stats['total_revenue'] ?? 0;
}

include 'includes/admin-header.php';
include 'includes/admin-sidebar.php';
?>

<main class="admin-main">
    <div class="admin-topbar">
        <div>
            <span class="badge"><?php echo $page_badge; ?></span>
            <h1><?php echo $page_heading; ?></h1>
            <p><?php echo $page_description; ?></p>
        </div>
    </div>

    <section class="admin-stats-grid">
        <div class="admin-stat-card">
            <div class="admin-stat-icon"><i class="fa-solid fa-bag-shopping"></i></div>
            <div>
                <h3>Total Orders</h3>
                <p><?php echo $total_orders; ?> order(s) placed</p>
            </div>
        </div>

        <div class="admin-stat-card">
            <div class="admin-stat-icon"><i class="fa-solid fa-indian-rupee-sign"></i></div>
            <div>
                <h3>Total Revenue</h3>
                <p>₹<?php echo number_format((float)$total_revenue, 2); ?></p>
            </div>
        </div>

        <div class="admin-stat-card">
            <div class="admin-stat-icon"><i class="fa-solid fa-truck-fast"></i></div>
            <div>
                <h3>Fulfillment</h3>
                <p>Track and manage order dispatches smoothly</p>
            </div>
        </div>

        <div class="admin-stat-card">
            <div class="admin-stat-icon"><i class="fa-solid fa-user-group"></i></div>
            <div>
                <h3>Customer Activity</h3>
                <p>Monitor recent buyer activity from checkout</p>
            </div>
        </div>
    </section>

    <section class="admin-panel-card">
        <div class="admin-panel-header">
            <div>
                <h2>All Orders</h2>
                <p>Orders placed from the checkout page are listed below with customer details and totals.</p>
            </div>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Total</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($orders && mysqli_num_rows($orders) > 0) { ?>
                        <?php while ($row = mysqli_fetch_assoc($orders)) { ?>
                            <tr>
                                <td><span class="order-id-badge">#<?php echo $row['id']; ?></span></td>

                                <td>
                                    <div class="order-customer">
                                        <strong><?php echo htmlspecialchars($row['customer_name']); ?></strong>
                                        <span>ShopEase Customer</span>
                                    </div>
                                </td>

                                <td>
                                    <div class="order-contact">
                                        <span><?php echo htmlspecialchars($row['email']); ?></span>
                                        <small><?php echo htmlspecialchars($row['phone']); ?></small>
                                    </div>
                                </td>

                                <td class="order-address-cell">
                                    <?php
                                    echo htmlspecialchars($row['address']) . '<br>';
                                    echo htmlspecialchars($row['city']) . ', ' .
                                         htmlspecialchars($row['state']) . ' - ' .
                                         htmlspecialchars($row['zip']);
                                    ?>
                                </td>

                                <td><strong class="order-total">₹<?php echo number_format($row['total_amount'], 2); ?></strong></td>

                                <td>
                                    <div class="order-date">
                                        <?php echo date("d M Y", strtotime($row['created_at'])); ?>
                                        <small><?php echo date("h:i A", strtotime($row['created_at'])); ?></small>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="6">
                                <div class="admin-empty-state">
                                    <i class="fa-solid fa-box-open"></i>
                                    <h3>No orders found</h3>
                                    <p>Orders placed through checkout will appear here.</p>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>

<?php include 'includes/admin-footer.php'; ?>