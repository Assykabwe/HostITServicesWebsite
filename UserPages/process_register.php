<?php
session_start();
require_once __DIR__ . '/../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

// Collect inputs
$full_name = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirmpassword'] ?? '';

$errors = [];
$oldData = [
    'full_name' => $full_name,
    'email' => $email
];

// Server-side validation
if (empty($full_name) || mb_strlen($full_name) < 3) {
    $errors['full_name'] = 'Full name must be at least 3 characters.';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Please enter a valid email address.';
}

if (empty($password) || strlen($password) < 6) {
    $errors['password'] = 'Password must be at least 6 characters.';
}

if ($password !== $confirm_password) {
    $errors['confirm'] = 'Passwords do not match.';
}

// If validation fails
if (!empty($errors)) {
    $_SESSION['register_errors'] = $errors;
    $_SESSION['old_data'] = $oldData;
    header('Location: ../UserPages/register.php');
    exit;
}

// Check if email already exists
$sql = "SELECT id FROM users WHERE email = ? LIMIT 1";
if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->close();
        $_SESSION['register_errors'] = ['email' => 'Email already registered. Try logging in.'];
        $_SESSION['old_data'] = $oldData;
        header('Location: ../UserPages/register.php');
        exit;
    }
    $stmt->close();
}

// Hash password and insert new user
$password_hash = password_hash($password, PASSWORD_DEFAULT);
$insert_sql = "INSERT INTO users (full_name, email, password_hash) VALUES (?, ?, ?)";
if ($stmt = $mysqli->prepare($insert_sql)) {
    $stmt->bind_param('sss', $full_name, $email, $password_hash);
    if ($stmt->execute()) {
        $_SESSION['User_ID'] = $stmt->insert_id;
        $_SESSION['User_Name'] = $full_name;
        $_SESSION['registered_success'] = true; // Success flag
        $stmt->close();
        header('Location: ../UserPages/register.php'); // Redirect back to show popup
        exit;
    } else {
        error_log("Execute failed: " . $stmt->error);
        $_SESSION['register_errors'] = ['general' => 'Registration failed, please try again later.'];
        $_SESSION['old_data'] = $oldData;
        header('Location: ../UserPages/register.php');
        exit;
    }
} else {
    error_log("Prepare failed: " . $mysqli->error);
    http_response_code(500);
    exit('Server error');
}
?>
