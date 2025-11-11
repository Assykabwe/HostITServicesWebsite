<?php
session_start();
require_once __DIR__.'/../includes/db_connection.php';
$data = json_decode(file_get_contents('php://input'), true);

$email = $data['email'] ?? '';
$name = $data['name'] ?? '';

if (!$email) {
    echo json_encode(['success' => false, 'message' => 'Email not provided']);
    exit;
}

// Check if user exists
$stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    $user = $res->fetch_assoc();
    $_SESSION['User_ID'] = $user['id'];
} else {
    // Register new user
    $stmt = $mysqli->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
    $dummyPassword = password_hash(bin2hex(random_bytes(8)), PASSWORD_DEFAULT); // random password
    $stmt->bind_param("sss", $name, $email, $dummyPassword);
    $stmt->execute();
    $_SESSION['User_ID'] = $stmt->insert_id;
}

echo json_encode(['success' => true]);
?>

