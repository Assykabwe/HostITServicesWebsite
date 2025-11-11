<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
include '../Includes/db_connection.php';
header('Content-Type: application/json');

$user_id = $_SESSION['User_ID'] ?? null;

// --- Fetch cart only ---
if (isset($_POST['fetch_cart']) && $_POST['fetch_cart'] === 'true') {
    $cart = $_SESSION['cart'] ?? [];
    $cart_total = 0;
    foreach ($cart as $item) {
        $cart_total += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
    }
    echo json_encode(['status' => 'success', 'cart' => $cart, 'cart_total' => number_format($cart_total, 2)]);
    exit;
}

// --- Get POST data ---
$service_id = intval($_POST['service_id'] ?? 0);
$domain_name = trim($_POST['domain_name'] ?? '');
$domain_price = floatval($_POST['domain_price'] ?? 0);

if (!$service_id) {
    echo json_encode(['status' => 'error', 'message' => 'No service ID provided']);
    exit;
}

// --- Initialize session cart ---
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) $_SESSION['cart'] = [];

// --- Fetch service info ---
$added_service = null;

// 1️⃣ Check pending_services if domain is provided
if ($domain_name && $user_id) {
    $stmt = $mysqli->prepare("
        SELECT ID, Category_Name, Service_Name, Price, Domain_Name 
        FROM pending_services 
        WHERE User_ID = ? 
          AND (Domain_Name = ? OR Service_Name = (SELECT service_title FROM services WHERE ID = ?))
        LIMIT 1
    ");
    $stmt->bind_param("isi", $user_id, $domain_name, $service_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        // Inside $added_service creation (pending_services block)
        $added_service = [
            'id' => $row['ID'],
            'service_title' => $row['Service_Name'],
            'category_name' => $row['Category_Name'],
            'price' => floatval($row['Price']) + $domain_price,
            'domain_name' => $row['Domain_Name'] ?? $domain_name,
            'quantity' => 1,
            'billing_cycle' => $row['Billing_Cycle'] ?? 'Annual'
        ];
    }
    $stmt->close();
}

// 2️⃣ If not found, fetch from services table
if (!$added_service) {
    $stmt = $mysqli->prepare("SELECT id, category_name, service_title, price FROM services WHERE id = ?");
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        // Inside services fallback block
        $added_service = [
            'id' => $row['id'],
            'service_title' => $row['service_title'],
            'category_name' => $row['category_name'],
            'price' => floatval($row['price']) + $domain_price,
            'domain_name' => $domain_name ?: null,
            'quantity' => 1,
            'billing_cycle' => $domain_name ? 'Annual' : 'Monthly'
        ];
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Service not found', 'cart' => $_SESSION['cart']]);
        exit;
    }
    $stmt->close();
}

// --- Merge into session cart ---
$exists = false;
foreach ($_SESSION['cart'] as &$item) {
    $itemDomain = $item['domain_name'] ?? '';
    if ($item['id'] == $added_service['id'] && $itemDomain === ($added_service['domain_name'] ?? '')) {
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

// --- Sync with DB for logged-in users ---
if ($user_id) {
    $stmtCheck = $mysqli->prepare("
        SELECT ID, Quantity 
        FROM cart 
        WHERE User_ID = ? 
          AND Service_ID = ? 
          AND (Domain_Name = ? OR Domain_Name IS NULL)
    ");
    $stmtCheck->bind_param("iis", $user_id, $added_service['id'], $added_service['domain_name']);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();
    if ($existing = $resultCheck->fetch_assoc()) {
        $newQty = $existing['Quantity'] + 1;
        $stmtUpdate = $mysqli->prepare("UPDATE cart SET Quantity = ? WHERE ID = ?");
        $stmtUpdate->bind_param("ii", $newQty, $existing['ID']);
        $stmtUpdate->execute();
        $stmtUpdate->close();
    } else {
        $stmtInsert = $mysqli->prepare("
            INSERT INTO cart (User_ID, Service_ID, Category_Name, Service_Title, Domain_Name, Price, Quantity, Billing_Cycle)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $quantity = 1;
        $stmtInsert->bind_param(
            "iisssdis",
            $user_id,
            $added_service['id'],
            $added_service['category_name'],
            $added_service['service_title'],
            $added_service['domain_name'],
            $added_service['price'],
            $quantity,
            $added_service['billing_cycle']
        );
        $stmtInsert->execute();
        $stmtInsert->close();
    }
    $stmtCheck->close();
}

// --- Calculate totals ---
$cart_total = 0;
$cart_count = 0;
foreach ($_SESSION['cart'] as $item) {
    $cart_total += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
    $cart_count += $item['quantity'] ?? 1;
}

// --- Return JSON ---
echo json_encode([
    'status' => 'success',
    'message' => $exists ? 'Quantity updated in cart' : 'Service added to cart',
    'cart' => $_SESSION['cart'],
    'cart_count' => $cart_count,
    'cart_total' => number_format($cart_total, 2),
    'service' => $added_service
]);
?>

