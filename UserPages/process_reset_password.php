<?php
session_start();
require_once __DIR__ . '/../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

$token = trim($_POST['token'] ?? '');
$new_password = $_POST['new_password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

if (empty($token)) {
    $_SESSION['reset_error'] = 'Invalid reset token.';
    header('Location: reset_password.php?token=' . urlencode($token));
    exit;
}

if (empty($new_password) || empty($confirm_password)) {
    $_SESSION['reset_error'] = 'Please fill in both password fields.';
    header('Location: reset_password.php?token=' . urlencode($token));
    exit;
}

if ($new_password !== $confirm_password) {
    $_SESSION['reset_error'] = 'Passwords do not match.';
    header('Location: reset_password.php?token=' . urlencode($token));
    exit;
}

// Password strength check
if (strlen($new_password) < 9 || 
    !preg_match('/[A-Z]/', $new_password) ||
    !preg_match('/[0-9]/', $new_password) ||
    !preg_match('/[!@#$%^&*]/', $new_password)) {
    $_SESSION['reset_error'] = 'Password must be at least 9 characters, include uppercase, number, and special char.';
    header('Location: reset_password.php?token=' . urlencode($token));
    exit;
}

// Verify token
$stmt = $mysqli->prepare("SELECT email FROM password_resets WHERE token = ? AND expires_at > NOW() LIMIT 1");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['reset_error'] = 'Invalid or expired token.';
    header('Location: reset_password.php');
    exit;
}

$row = $result->fetch_assoc();
$email = $row['email'];
$stmt->close();

// Update password
$new_hash = password_hash($new_password, PASSWORD_DEFAULT);
$update = $mysqli->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
$update->bind_param("ss", $new_hash, $email);
$update->execute();

// Delete token after reset
$del = $mysqli->prepare("DELETE FROM password_resets WHERE token = ?");
$del->bind_param("s", $token);
$del->execute();

// Set success message
$_SESSION['reset_success'] = 'Your password has been reset successfully. Please log in.';
header('Location: login.php');
exit;
?>
