<?php
session_start();
include '../Includes/db_connection.php';

// Only allow if admin is logged in
if (!isset($_SESSION['Admin_ID'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

// Correct POST check
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['user_id']);
    $full_name = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';

    $stmt = $mysqli->prepare("UPDATE users SET full_name = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $full_name, $email, $user_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'User updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update user']);
    }
    $stmt->close();
}
?>


