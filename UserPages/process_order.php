<?php
// ==============================
// process_order.php
// ==============================

// Show all errors for development (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// JSON response header
header('Content-Type: application/json');

// Start session
session_start();

// Include database connection
include '../Includes/db_connection.php';

// Safe JSON response function
function jsonResponse($success, $message, $extra = []) {
    echo json_encode(array_merge([
        'success' => $success,
        'message' => $message
    ], $extra));
    exit;
}

// Ensure user is logged in
if (!isset($_SESSION['User_ID'])) {
    jsonResponse(false, "Please login before completing the order.");
}

$user_id = $_SESSION['User_ID'];

// Retrieve form data
$payment_method = $_POST['payment_method'] ?? '';
$order_notes = $_POST['notes'] ?? '';

// Validate payment method
if (!$payment_method) {
    jsonResponse(false, "Payment method is required.");
}

// Ensure cart is not empty
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
    jsonResponse(false, "Your cart is empty.");
}

// Calculate total amount
$total_amount = 0;
foreach ($_SESSION['cart'] as $item) {
    $price = floatval($item['price'] ?? 0);
    $quantity = intval($item['quantity'] ?? 1);
    $total_amount += $price * $quantity;
}

// ==============================
// Save the order
// ==============================
$stmt = $mysqli->prepare("
    INSERT INTO orders (user_id, payment_method, notes, total_amount, created_at)
    VALUES (?, ?, ?, ?, NOW())
");
if (!$stmt) {
    jsonResponse(false, "Database error: " . $mysqli->error);
}

$stmt->bind_param("issd", $user_id, $payment_method, $order_notes, $total_amount);

if (!$stmt->execute()) {
    jsonResponse(false, "Failed to save order: " . $stmt->error);
}

$order_id = $stmt->insert_id;
$stmt->close();

// ==============================
// Save order items
// ==============================
$orderItemStmt = $mysqli->prepare("
    INSERT INTO order_items 
    (order_id, service_id, category_name, service_title, domain_name, quantity, price)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");

if (!$orderItemStmt) {
    jsonResponse(false, "Database error (order_items): " . $mysqli->error);
}

foreach ($_SESSION['cart'] as $item) {
    $service_id = intval($item['id'] ?? 0);
    if ($service_id <= 0) continue;

    // Check service exists
    $checkStmt = $mysqli->prepare("SELECT id FROM services WHERE id = ?");
    $checkStmt->bind_param("i", $service_id);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    if ($result->num_rows === 0) {
        // Skip invalid service
        $checkStmt->close();
        continue;
    }
    $checkStmt->close();

    $category_name = $item['category_name'] ?? '';
    $service_title = $item['service_title'] ?? '';
    $domain_name = $item['domain_name'] ?? '';
    $quantity = intval($item['quantity'] ?? 1);
    $price = floatval($item['price'] ?? 0);

    $orderItemStmt->bind_param(
        "iisssid",
        $order_id,
        $service_id,
        $category_name,
        $service_title,
        $domain_name,
        $quantity,
        $price
    );

    if (!$orderItemStmt->execute()) {
        jsonResponse(false, "Failed to save order items: " . $orderItemStmt->error);
    }
}

$orderItemStmt->close();

// Clear the cart
unset($_SESSION['cart']);

// Return JSON
jsonResponse(true, "Order successfully placed.", [
    "order_id" => $order_id,
    "total_amount" => number_format($total_amount, 2)
]);

$mysqli->close();
?>
