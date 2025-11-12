<?php
session_start();
require_once __DIR__ . '/../includes/db_connection.php'; // Adjust path if needed

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

// Get form data
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

$errors = [];

// Basic validation
if (empty($email)) {
    $errors['email'] = 'Email is required.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Please enter a valid email.';
}

if (empty($password)) {
    $errors['password'] = 'Password is required.';
}

// If there are validation errors
if (!empty($errors)) {
    $_SESSION['login_errors'] = $errors;
    $_SESSION['old_login'] = ['email' => $email];
    header('Location: ../UserPages/login.php');
    exit;
}

// Check if user exists
$sql = "SELECT id, full_name, password_hash FROM users WHERE email = ? LIMIT 1";
if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        // Email not found
        $_SESSION['login_errors'] = ['email' => 'No account found with this email.'];
        $_SESSION['old_login'] = ['email' => $email];
        $stmt->close();
        header('Location: ../UserPages/login.php');
        exit;
    }

    $stmt->bind_result($user_id, $full_name, $password_hash);
    $stmt->fetch();

    // Verify password
    if (!password_verify($password, $password_hash)) {
        $_SESSION['login_errors'] = ['password' => 'Incorrect password.'];
        $_SESSION['old_login'] = ['email' => $email];
        $stmt->close();
        header('Location: ../UserPages/login.php');
        exit;
    }

    // Successful login
    $_SESSION['User_ID'] = $user_id;
    $_SESSION['User_Name'] = $full_name;

    // ✅ Set login success message for SweetAlert
    $_SESSION['login_success'] = "Welcome back, " . htmlspecialchars($user['fullname']) . "!";
    header("Location: home.php");
    exit;
    } else {
        $_SESSION['login_error'] = "Invalid email or password.";
        header("Location: login.php");
        exit;
    }
?>

