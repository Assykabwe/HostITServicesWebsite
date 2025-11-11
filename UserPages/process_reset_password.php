<?php
session_start();
require_once __DIR__ . '/../includes/db_connection.php'; // $mysqli

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

$token = trim($_POST['token'] ?? '');
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';

// Basic checks
if ($password === '' || $confirm === '') {
    $_SESSION['reset_error'] = "Please fill all fields.";
    header("Location: reset_password.php?token=" . urlencode($token));
    exit;
}

if ($password !== $confirm) {
    $_SESSION['reset_error'] = "Passwords do not match.";
    header("Location: reset_password.php?token=" . urlencode($token));
    exit;
}

if (strlen($password) < 6) {
    $_SESSION['reset_error'] = "Password must be at least 6 characters.";
    header("Location: reset_password.php?token=" . urlencode($token));
    exit;
}

// Verify token and get email
$stmt = $mysqli->prepare("SELECT email, expires_at FROM password_resets WHERE token = ? LIMIT 1");
$stmt->bind_param("s", $token);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    exit('Invalid or expired token.');
}

$row = $res->fetch_assoc();
if (strtotime($row['expires_at']) < time()) {
    // expired
    $del = $mysqli->prepare("DELETE FROM password_resets WHERE token = ?");
    $del->bind_param("s", $token);
    $del->execute();
    exit('This reset link has expired.');
}

$email = $row['email'];

// All good — update password
$hash = password_hash($password, PASSWORD_DEFAULT);
$update = $mysqli->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
$update->bind_param("ss", $hash, $email);
$update->execute();

// Delete token record
$del = $mysqli->prepare("DELETE FROM password_resets WHERE token = ?");
$del->bind_param("s", $token);
$del->execute();

$_SESSION['reset_success'] = "Your password has been reset. You may now log in.";
header("Location: login.php");
exit;
?>