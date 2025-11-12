<?php
session_start();
include '../Includes/db_connection.php';

// Restrict access to admins only
if (!isset($_SESSION['Admin_ID'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle order status update
if (isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $status = $_POST['status'];
    $stmt = $mysqli->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $order_id);
    if ($stmt->execute()) {
        $msg = "Order status updated successfully.";
    } else {
        $error = "Failed to update order status.";
    }
    $stmt->close();
}

// Handle delete
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $stmt = $mysqli->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        $msg = "Order deleted successfully.";
    } else {
        $error = "Failed to delete order.";
    }
    $stmt->close();
}

// Fetch all orders with aggregated items
$query = "
    SELECT 
        o.id AS order_id,
        u.full_name AS user_name,
        u.email AS user_email,
        o.status,
        o.created_at,
        o.Billing_Cycle,
        GROUP_CONCAT(oi.service_title SEPARATOR ', ') AS service_titles,
        GROUP_CONCAT(oi.domain_name SEPARATOR ', ') AS domain_names,
        SUM(oi.price) AS total_price
    FROM orders o
    INNER JOIN users u ON o.user_id = u.id
    LEFT JOIN order_items oi ON o.id = oi.order_id
    GROUP BY o.id
    ORDER BY o.created_at DESC
";
$result = $mysqli->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Orders | Admin Panel</title>
    <link rel="stylesheet" href="admin_style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
</head>
<body>
<?php include 'admin_header.php'; ?>
<div class="admin-container">
    <?php include 'admin_sidebar.php'; ?>

    <main class="admin-main">
        <h1>📦 Manage Orders</h1>

        <?php if (!empty($msg)): ?>
            <script>swal("Success", "<?php echo $msg; ?>", "success");</script>
        <?php elseif (!empty($error)): ?>
            <script>swal("Error", "<?php echo $error; ?>", "error");</script>
        <?php endif; ?>

        <div class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User</th>
                        <th>Service Titles</th>
                        <th>Domain Names</th>
                        <th>Billing Cycle</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td>#<?php echo $row['order_id']; ?></td>
                                <td>
                                    <?php echo htmlspecialchars($row['user_name']); ?><br>
                                    <small><?php echo htmlspecialchars($row['user_email']); ?></small>
                                </td>
                                <td><?php echo htmlspecialchars($row['service_titles']); ?></td>
                                <td><?php echo htmlspecialchars($row['domain_names'] ?: '-'); ?></td>
                                <td><?php echo ucfirst($row['Billing_Cycle']); ?></td>
                                <td>R<?php echo number_format($row['total_price'], 2); ?></td>
                                <td>
                                    <form method="POST" style="display:flex; align-items:center; gap:5px;">
                                        <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                                        <select name="status">
                                            <option value="Pending" <?php if($row['status']=="Pending") echo "selected"; ?>>Pending</option>
                                            <option value="Active" <?php if($row['status']=="Active") echo "selected"; ?>>Active</option>
                                            <option value="Completed" <?php if($row['status']=="Completed") echo "selected"; ?>>Completed</option>
                                            <option value="Expired" <?php if($row['status']=="Expired") echo "selected"; ?>>Expired</option>
                                        </select>
                                        <button type="submit" name="update_status" class="update-btn">Update</button>
                                    </form>
                                </td>
                                <td><?php echo date("Y-m-d", strtotime($row['created_at'])); ?></td>
                                <td>
                                    <a href="?delete=<?php echo $row['order_id']; ?>" 
                                       onclick="return confirm('Are you sure you want to delete this order?');"
                                       class="delete-btn">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="9" style="text-align:center;">No orders found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>
