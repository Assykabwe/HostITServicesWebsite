<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include '../Includes/db_connection.php';

// Check admin login
if (!isset($_SESSION['Admin_ID'])) {
    header("Location: admin_login.php");
    exit;
}

// Dashboard Metrics
$totalUsers = $mysqli->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$activeOrders = $mysqli->query("SELECT COUNT(*) AS total FROM orders WHERE status='Active'")->fetch_assoc()['total'];
$incomeSummary = $mysqli->query("SELECT SUM(price) AS total_income FROM order_items")->fetch_assoc()['total_income'];

// Support Tickets Stats
$openTickets = $mysqli->query("SELECT COUNT(*) AS total FROM support_tickets WHERE Status='Open'")->fetch_assoc()['total'];
$closedTickets = $mysqli->query("SELECT COUNT(*) AS total FROM support_tickets WHERE Status='Closed'")->fetch_assoc()['total'];

// Orders over last 7 days for chart
$ordersLast7Days = [];
$labels = [];
for($i=6;$i>=0;$i--){
    $date = date("Y-m-d", strtotime("-$i days"));
    $count = $mysqli->query("SELECT COUNT(*) AS total FROM orders WHERE DATE(created_at)='$date'")->fetch_assoc()['total'];
    $ordersLast7Days[] = $count;
    $labels[] = date("M d", strtotime($date));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .dashboard-cards { display:flex; gap:20px; margin-bottom:30px; flex-wrap: wrap; }
        .card { flex:1; padding:20px; border-radius:8px; color:#fff; min-width:180px; text-align:center; }
        .card h3 { margin-bottom:10px; }
        .card p { font-size:2rem; margin:0; }
        .card.users { background:#3b97b0; }
        .card.orders { background:#4caf50; }
        .card.income { background:#ff9800; }
        .card.tickets-open { background:#e91e63; }
        .card.tickets-closed { background:#607d8b; }
        canvas { background:#fff; border-radius:8px; padding:20px; margin-top:20px; }
        .quick-links { margin-top:20px; display:flex; gap:20px; flex-wrap: wrap; }
        .quick-links a { padding:15px 25px; background:#3b97b0; color:#fff; border-radius:5px; text-decoration:none; font-weight:bold; }
        .quick-links a:hover { background:#2e7c96; }
    </style>
</head>
<body>

<?php include 'admin_header.php'; ?>
    <div class="container">
        <h1>Admin Dashboard</h1>

        <!-- Dashboard Cards -->
        <div class="dashboard-cards">
            <div class="card users">
                <h3>Total Users</h3>
                <p><?= $totalUsers ?></p>
            </div>
            <div class="card orders">
                <h3>Active Orders</h3>
                <p><?= $activeOrders ?></p>
            </div>
            <div class="card income">
                <h3>Total Income</h3>
                <p>R<?= number_format($incomeSummary,2) ?></p>
            </div>
            <div class="card tickets-open">
                <h3>Open Tickets</h3>
                <p><?= $openTickets ?></p>
            </div>
            <div class="card tickets-closed">
                <h3>Closed Tickets</h3>
                <p><?= $closedTickets ?></p>
            </div>
        </div>

        <!-- Orders Chart -->
        <h2>Orders Last 7 Days</h2>
        <canvas id="ordersChart" width="400" height="150"></canvas>

        <!-- Quick Links -->
        <div class="quick-links">
            <a href="admin_services.php">Manage Services</a>
            <a href="admin_tickets.php">Manage Support Tickets</a>
            <a href="manage_users.php">Manage Users</a>
            <a href="manage_orders.php">Manage Orders</a>
            <a href="manage_domain.php">Manage Domains</a>
        </div>
    </div>


<script>
const ctx = document.getElementById('ordersChart').getContext('2d');
const ordersChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            label: 'Orders',
            data: <?= json_encode($ordersLast7Days) ?>,
            backgroundColor: '#4caf50'
        }]
    },
    options: {
        responsive:true,
        plugins: {
            legend: { display:false },
            title: { display:true, text:'Orders in the last 7 days' }
        },
        scales: {
            y: { beginAtZero:true }
        }
    }
});
</script>

</body>
</html>



