<?php
include '../Includes/db_connection.php';
session_start();

header('Content-Type: application/json');

$userID = $_SESSION['User_ID'] ?? null;
if (!$userID) {
    echo json_encode(['success' => false, 'message' => 'You must be logged in']);
    exit;
}

$subject = trim($_POST['subject'] ?? '');
$category = trim($_POST['category'] ?? '');
$priority = trim($_POST['priority'] ?? '');
$message = trim($_POST['message'] ?? '');

if (!$subject || !$category || !$priority || !$message) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

$filePath = null;
if (!empty($_FILES['file']['name'])) {
    $uploadDir = '../Uploads/Tickets/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
    $fileName = time() . '_' . basename($_FILES['file']['name']);
    $targetPath = $uploadDir . $fileName;
    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
        $filePath = $fileName;
    }
}

$stmt = $mysqli->prepare("INSERT INTO support_tickets (User_ID, Subject, Category, Priority, Message, File_Path) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssss", $userID, $subject, $category, $priority, $message, $filePath);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
}
$stmt->close();
?>
