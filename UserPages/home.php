<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../Includes/db_connection.php';

require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// SMTP configuration for Gmail
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USER', 'hostithostitservices@gmail.com');  // your Gmail address
define('SMTP_PASS', 'vsswtcfgukaztygv');           // your 16-character App Password (no spaces)
define('SMTP_PORT', 587);                          // TLS port
define('MAIL_FROM', 'hostithostitservices@gmail.com');   // same as your Gmail
define('MAIL_FROM_NAME', 'Host IT Services');
$userID = $_SESSION['User_ID'] ?? null;

/* ======================================================
   FUNCTION: Send Activation Email (via SMTP / PHPMailer)
   ====================================================== */
function sendActivationEmail($email, $serviceTitle) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER;
        $mail->Password   = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use 'ssl' if using port 465
        $mail->Port       = SMTP_PORT;

        // Sender and recipient
        $mail->setFrom('no-reply@hostitservices.com', 'Host IT Services');
        $mail->addAddress($email);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "Your Service is Now Active!";
        $mail->Body = "
            <h2>Hi there!</h2>
            <p>Your service <strong>$serviceTitle</strong> is now <b>Active</b> and ready to use.</p>
            <p>Visit your account to manage your services anytime.</p>
            <br>
            <p>Best regards,<br><b>Host IT Services</b></p>
        ";

        $mail->send();
    } catch (Exception $e) {
        error_log("Email failed: {$mail->ErrorInfo}");
    }
}

/* ==============================
   Login Success Popup
============================== */
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
        <title>Host IT Services - Home</title>
        <link rel="stylesheet" href="../CSS/user_style.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <script src="../JavaScript/user_script.js" defer></script>
        <style>
        .countdown-text {
            display: block;
            font-size: 12px;
            color: #777;
        }
        .renew-btn.disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        </style>
    </head>
    <body>

        <?php include '../UserPages/User_Header.php'; ?>

        <section class="container">
            <div class="wrapper">
                <div class="slide">
                    <img src="../Images/HomePage.webp" alt="Banner">
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

        <!-- ==============================
                My Services Section
        =============================== -->
        <section class="services">
            <div class="heading"><h1>My Services</h1></div>
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
                                    oi.id AS item_id,
                                    oi.service_title,
                                    oi.category_name,
                                    oi.domain_name,
                                    o.status,
                                    oi.price,
                                    o.created_at,
                                    o.Billing_Cycle,
                                    u.Email
                                FROM order_items oi
                                INNER JOIN orders o ON oi.order_id = o.id
                                INNER JOIN users u ON o.user_id = u.id
                                WHERE o.user_id = ?
                                ORDER BY o.created_at DESC
                            ";
                            $stmt = $mysqli->prepare($query);
                            $stmt->bind_param("i", $userID);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $status = strtolower($row['status']);
                                    $statusClass = $status === 'expired' ? 'expired' : 'active';
                                    $formattedPrice = "R" . number_format($row['price'], 2);
                                    $formattedDate = date("m/d/Y", strtotime($row['created_at']));
                                    $billingCycle = ucfirst($row['Billing_Cycle']);

                                    // Send Activation Email once
                                    if ($status === 'active') {
                                        $check = $mysqli->prepare("SELECT notified FROM orders WHERE user_id=? AND status='Active' LIMIT 1");
                                        $check->bind_param("i", $userID);
                                        $check->execute();
                                        $checkRes = $check->get_result()->fetch_assoc();
                                        if (empty($checkRes['notified'])) {
                                            sendActivationEmail($row['Email'], $row['service_title']);
                                            $update = $mysqli->prepare("UPDATE orders SET notified=1 WHERE user_id=? AND status='Active'");
                                            $update->bind_param("i", $userID);
                                            $update->execute();
                                        }
                                    }

                                    // Renewal logic
                                    $createdAt = new DateTime($row['created_at']);
                                    $now = new DateTime();
                                    $daysPassed = $createdAt->diff($now)->days;
                                    $enableAfterDays = empty($row['domain_name']) ? 30 : 365;
                                    $remainingDays = $enableAfterDays - $daysPassed;
                                    $isRenewEnabled = ($status === 'active' && $remainingDays <= 0);
                                    

                                    $buttonText = $isRenewEnabled ? "Click to renew your service" 
                                        : "You can renew after {$remainingDays} days";
                                    $disabledAttr = $isRenewEnabled ? '' : 'disabled';
                                    $buttonClass = $isRenewEnabled ? 'renew-btn active' : 'renew-btn disabled';

                                    echo "<tr>
                                        <td>{$row['service_title']}</td>
                                        <td class='{$statusClass}'>{$row['status']}</td>
                                        <td>{$formattedPrice}</td>
                                        <td>{$formattedDate}</td>
                                        <td>{$billingCycle}</td>
                                        <td>
                                            <button class='{$buttonClass}' {$disabledAttr} title='{$buttonText}' 
                                                data-remaining='{$enableAfterDays}' data-created='{$row['created_at']}'>
                                                " . ($isRenewEnabled ? "Renew Now" : "Renew in {$remainingDays} days") . "
                                            </button>
                                        </td>
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

        <!-- ==============================
                Support Tickets
        =============================== -->
        <section class="support">
            <div class="heading"><h1>Support Tickets</h1></div>
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
                        if ($userID) {
                            $query = "SELECT Subject, Category, Priority, Status, Created_At 
                                    FROM support_tickets WHERE User_ID=? ORDER BY Created_At DESC";
                            $stmt = $mysqli->prepare($query);
                            $stmt->bind_param("i", $userID);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $statusClass = strtolower($row['Status']);
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

        <!-- ==============================
                JS: Renewal Redirect
        =============================== -->
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                document.querySelectorAll(".renew-btn.disabled").forEach(btn => {
                    const createdAt = new Date(btn.dataset.created);
                    const daysLimit = parseInt(btn.dataset.remaining);
                    const targetDate = new Date(createdAt);
                    targetDate.setDate(targetDate.getDate() + daysLimit);

                    function updateCountdown() {
                        const now = new Date();
                        const diff = targetDate - now;
                        if (diff <= 0) {
                            btn.disabled = false;
                            btn.classList.remove("disabled");
                            btn.classList.add("active");
                            btn.textContent = "Renew Now";
                            btn.title = "Click to renew your service";
                            return;
                        }
                        const daysLeft = Math.ceil(diff / (1000 * 60 * 60 * 24));
                        btn.textContent = `Renew in ${daysLeft} days`;
                    }

                    updateCountdown();
                    setInterval(updateCountdown, 86400000); // update every 24h
                });

                // Redirect to correct service section on click
                document.querySelectorAll(".renew-btn.active").forEach(btn => {
                    btn.addEventListener("click", () => {
                        const row = btn.closest("tr");
                        const serviceName = row.querySelector("td:first-child").textContent.toLowerCase();

                        let target = "services.php";
                        if (serviceName.includes("domain")) target += "#register_domain";
                        else if (serviceName.includes("web")) target += "#web_hosting";
                        else if (serviceName.includes("e-commerce")) target += "#ecommerce";
                        else if (serviceName.includes("social")) target += "#social_media";
                        else if (serviceName.includes("brand")) target += "#branding";
                        else if (serviceName.includes("graphic")) target += "#graphic";

                        window.location.href = target;
                    });
                });
            });
        </script>

        <?php include '../Components/footer.php'; ?>
    </body>
</html>

