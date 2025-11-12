<?php
session_start();
include '../Includes/db_connection.php';
header('Content-Type: application/json');

$user_id = $_SESSION['User_ID'] ?? null;

// Initialize session cart
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Get POST data safely
$service_id = isset($_POST['service_id']) ? intval($_POST['service_id']) : 0;
$domain_name = isset($_POST['domain_name']) ? trim($_POST['domain_name']) : '';
$domain_price = isset($_POST['domain_price']) ? floatval($_POST['domain_price']) : 0;

// If neither service nor domain is provided, return error
if (empty($service_id) && empty($domain_name)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'No service or domain provided'
    ]);
    exit;
}

// Variable to track newly added service
$added_service = null;

// ----------------------
// 1️⃣ Add domain only (if provided)
// ----------------------
if (!empty($domain_name) && $user_id) {
    $stmt = $mysqli->prepare("
        SELECT ID, Category_Name, Service_Name, Price, Domain_Name, Billing_Cycle 
        FROM pending_services 
        WHERE User_ID = ? AND Domain_Name = ?
        LIMIT 1
    ");
    $stmt->bind_param("is", $user_id, $domain_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $added_service = [
            'id' => $row['ID'],
            'service_title' => $row['Service_Name'],
            'category_name' => $row['Category_Name'],
            'price' => floatval($row['Price']),
            'domain_name' => $row['Domain_Name'],
            'quantity' => 1,
            'billing_cycle' => $row['Billing_Cycle'] ?? 'Annual'
        ];
    }
    $stmt->close();

    // Add to session cart if not already there
    if ($added_service) {
        $exists = false;
        foreach ($_SESSION['cart'] as &$item) {
            if (($item['domain_name'] ?? '') === $added_service['domain_name']) {
                $item['quantity'] += 1;
                $exists = true;
                $added_service = $item;
                break;
            }
        }
        unset($item);
        if (!$exists) {
            $_SESSION['cart'][] = $added_service;
        }
    }
}

// ----------------------
// 2️⃣ Add main service only (if provided)
// ----------------------
if (!empty($service_id)) {
    $stmt = $mysqli->prepare("SELECT id, category_name, service_title, price FROM services WHERE id = ?");
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $service_item = [
            'id' => $row['id'],
            'service_title' => $row['service_title'],
            'category_name' => $row['category_name'],
            'price' => floatval($row['price']),
            'domain_name' => null,
            'quantity' => 1,
            'billing_cycle' => 'Monthly'
        ];

        // Merge into cart if same service without domain exists
        $exists = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $service_item['id'] && ($item['domain_name'] ?? null) === null) {
                $item['quantity'] += 1;
                $exists = true;
                $service_item = $item;
                break;
            }
        }
        unset($item);

        if (!$exists) {
            $_SESSION['cart'][] = $service_item;
        }
    }
    $stmt->close();
}

// ----------------------
// Calculate cart totals
// ----------------------
$cart_total = 0;
$cart_count = 0;
foreach ($_SESSION['cart'] as $item) {
    $cart_total += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
    $cart_count += $item['quantity'] ?? 1;
}

// ----------------------
// Return cart and optionally service info
// ----------------------
$response = [
    'status' => 'success',
    'cart' => $_SESSION['cart'],
    'cart_count' => $cart_count,
    'cart_total' => number_format($cart_total, 2)
];

// Include the fetched service for info (only if service_id was provided)
if (!empty($service_id) && isset($service_item)) {
    $response['service'] = $service_item; // For main service
} elseif (!empty($service_id) && isset($added_service)) {
    $response['service'] = $added_service; // For domain-added service
}

echo json_encode($response);
