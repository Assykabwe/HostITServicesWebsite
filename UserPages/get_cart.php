<?php
session_start(); 
include '../Includes/db_connection.php'; 

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) $_SESSION['cart'] = []; 

$user_id = $_SESSION['User_ID'] ?? null; 

// Load from DB if logged in and session cart is empty
if ($user_id && empty($_SESSION['cart'])) {
    $stmt = $mysqli->prepare("SELECT * FROM cart WHERE User_ID = ?");
    $stmt->bind_param("i", $user_id); 
    $stmt->execute(); 
    $res = $stmt->get_result(); 
    $_SESSION['cart'] = [];
    while ($row = $res->fetch_assoc()) {
        $_SESSION['cart'][] = [
            'id' => $row['Service_ID'],
            'service_title' => $row['Service_Title'],
            'category_name' => $row['Category_Name'],
            'domain_name' => $row['Domain_Name'],
            'price' => floatval($row['Price']),
            'quantity' => intval($row['Quantity']),
            'billing_cycle' => $row['Billing_Cycle'] ?? ($row['Domain_Name'] ? 'Annual' : 'Monthly')
        ];
    }
    $stmt->close();
}

$cart_with_details = []; 
$cart_total = 0; 

foreach ($_SESSION['cart'] as $item) {
    $unitPrice = floatval($item['price']);
    $quantity = intval($item['quantity'] ?? 1);
    $lineTotal = $unitPrice * $quantity;

    $cart_with_details[] = [
        'id' => $item['id'],
        'service_title' => $item['service_title'],
        'category_name' => $item['category_name'],
        'price' => $unitPrice,
        'domain_name' => $item['domain_name'] ?? null,
        'quantity' => $quantity,
        'billing_cycle' => $item['billing_cycle'] ?? ($item['domain_name'] ? 'Annual' : 'Monthly'),
        'line_total' => $lineTotal
    ];

    $cart_total += $lineTotal;
}

echo json_encode([
    'status' => 'success',
    'cart' => $cart_with_details,
    'cart_count' => count($cart_with_details),
    'cart_total' => number_format($cart_total, 2)
]);
?>
