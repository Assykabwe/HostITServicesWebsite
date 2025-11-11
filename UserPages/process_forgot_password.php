<?php
session_start();
require_once __DIR__ . '/../includes/db_connection.php'; // provides $mysqli

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

$email = trim($_POST['email'] ?? '');
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['reset_error'] = "Please enter a valid email address.";
    header("Location: forgot_password.php");
    exit;
}

// Check if user exists
$stmt = $mysqli->prepare("SELECT email, full_name FROM users WHERE email = ? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    // Show generic notice for security
    $_SESSION['reset_notice'] = "If an account with that email exists, a reset link has been sent.";
    header("Location: forgot_password.php");
    exit;
}

$user = $res->fetch_assoc();
$full_name = $user['full_name'] ?? '';

// Generate token and expiry
$token = bin2hex(random_bytes(32));
$expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

// Remove any previous tokens for this email
$clean = $mysqli->prepare("DELETE FROM password_resets WHERE email = ?");
$clean->bind_param("s", $email);
$clean->execute();
$clean->close();

// Insert new token
$insert = $mysqli->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
$insert->bind_param("sss", $email, $token, $expires_at);
$insert->execute();
$insert->close();

// Build reset link
$reset_link = "http://localhost/HostITServicesPrototype/UserPages/reset_password.php?token=" . urlencode($token);

/* ---------- Send email with PHPMailer via Composer ---------- */
require __DIR__ . '/../vendor/autoload.php';  // Composer autoload

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// SMTP configuration for Gmail
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USER', 'hostithostitservices@gmail.com');  // your Gmail address
define('SMTP_PASS', 'vsswtcfgukaztygv');           // your 16-character App Password (no spaces)
define('SMTP_PORT', 587);                          // TLS port
define('MAIL_FROM', 'hostithostitservices@gmail.com');   // same as your Gmail
define('MAIL_FROM_NAME', 'Host IT Services');

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

    // Recipients
    $mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);
    $mail->addAddress($email, $full_name);

    // Email content
    $mail->isHTML(true);
    $mail->Subject = 'Host IT Services — Password Reset';
    $mail->Body = "
        <p>Hi " . htmlspecialchars($full_name ?: 'there') . ",</p>
        <p>We received a request to reset your password. Click the button below to set a new password. This link is valid for 1 hour.</p>
        <p style='text-align:center'>
            <a href='" . $reset_link . "' style='display:inline-block;padding:10px 20px;background:#4CAF50;color:#fff;border-radius:4px;text-decoration:none;'>Reset Password</a>
        </p>
        <p>If you didn't request this, you can safely ignore this email.</p>
        <p>— Host IT Services</p>
    ";
    $mail->AltBody = "Reset your password: $reset_link";

    $mail->send();
    $_SESSION['reset_notice'] = "If an account with that email exists, a reset link has been sent.";
} catch (Exception $e) {
    error_log("Reset email failed: " . $mail->ErrorInfo);
    $_SESSION['reset_error'] = "Failed to send reset email. Please try again later.";
}

header("Location: forgot_password.php");
exit;
?>