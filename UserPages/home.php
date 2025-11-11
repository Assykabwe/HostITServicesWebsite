<?php
if (session_status() === PHP_SESSION_NONE) session_start();
// Include database connection
include '../Includes/db_connection.php';
// Get logged-in user ID
$userID = $_SESSION['User_ID'] ?? null;

if (!empty($_SESSION['login_success'])) {
    $msg = $_SESSION['login_success'];
    unset($_SESSION['login_success']);
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            swal('Login Successful', '$msg', 'success');
        });
    </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../CSS/user_style.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <script src="../JavaScript/user_script.js" defer></script>
        <title>Host IT Services - Home page</title>
    </head>
    <body>
        <?php include '../UserPages/User_Header.php';?>
        <!---- slider 1 section start ---->
        <section class="container">
            <div class="wrapper">
                <div class="slide">
                    <img src="../Images/HomePage.webp">
                    <div class="slide-text">
                        <h1>Host IT Services</h1>
                        <h2>Bringing you a variety of tech services</h2>
                        <div class="btn-container">
                            <a href="services.php" class="btn">New Domain</a>
                            <a href="support_ticket.php" class="btn">Create Ticket</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="services">
            <div class="heading">
                <h1>My Services</h1>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Status</th>
                            <th>Billing</th>
                            <th>Date</th>
                            <th>Billing Cycle</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($userID) {
                            $query = "
                                SELECT 
                                    oi.service_title,
                                    o.status,
                                    oi.price,
                                    o.created_at,
                                    o.Billing_Cycle
                                FROM order_items oi
                                INNER JOIN orders o ON oi.order_id = o.id
                                WHERE o.user_id = ?
                                ORDER BY o.created_at DESC
                            ";

                            $stmt = $mysqli->prepare($query);
                            $stmt->bind_param("i", $userID);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $statusClass = strtolower($row['status']) === 'expired' ? 'expired' : 'active';
                                    $formattedPrice = "R" . number_format($row['price'], 2);
                                    $formattedDate = date("m/d/Y", strtotime($row['created_at']));
                                    $billingCycle = ucfirst($row['Billing_Cycle']);

                                    echo "<tr>
                                            <td>{$row['service_title']}</td>
                                            <td class='{$statusClass}'>{$row['status']}</td>
                                            <td>{$formattedPrice}</td>
                                            <td>{$formattedDate}</td>
                                            <td>{$billingCycle}</td>
                                            <td><button class='renew-btn'>Renew</button></td>
                                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' style='text-align:center;'>No active services found.</td></tr>";
                            }

                            $stmt->close();
                        } else {
                            echo "<tr><td colspan='6' style='text-align:center;'>Please log in to view your services.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>


        <section class="support">
            <div class="heading">
                <h1>Support Tickets</h1>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Category</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include '../Includes/db_connection.php';
                            $userID = $_SESSION['User_ID'] ?? null;

                            if ($userID) {
                                $query = "SELECT Subject, Category, Priority, Status, Created_At 
                                        FROM support_tickets 
                                        WHERE User_ID = ? 
                                        ORDER BY Created_At DESC";
                                $stmt = $mysqli->prepare($query);
                                $stmt->bind_param("i", $userID);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $statusClass = strtolower($row['Status']); // 'open' or 'closed'
                                        echo "<tr>
                                            <td>{$row['Subject']}</td>
                                            <td>{$row['Category']}</td>
                                            <td>{$row['Priority']}</td>
                                            <td class='{$statusClass}'>{$row['Status']}</td>
                                            <td>{$row['Created_At']}</td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5' style='text-align:center;'>No tickets found.</td></tr>";
                                }

                                $stmt->close();
                            } else {
                                echo "<tr><td colspan='5' style='text-align:center;'>Please log in to view your support tickets.</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="new-ticket">
                <a href="support_ticket.php" class="btn">Create New Ticket</a>
            </div>
        </section>

        <?php include '../Components/footer.php';?>
    </body>
</html>