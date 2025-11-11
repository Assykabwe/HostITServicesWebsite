<?php
session_start();
include '../Includes/db_connection.php';

$user_id = $_SESSION['User_ID'] ?? null;

// Ensure cart exists
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['index'])) {
    $index = intval($_POST['index']);

    if (isset($_SESSION['cart'][$index])) {
        $item = $_SESSION['cart'][$index];

        // Decrease quantity or remove completely
        if (isset($item['quantity']) && $item['quantity'] > 1) {
            $_SESSION['cart'][$index]['quantity']--;
        } else {
            array_splice($_SESSION['cart'], $index, 1);
        }

        // Sync with DB if user is logged in
        if ($user_id) {
            $serviceId = $item['id'];
            $domainName = $item['domain_name'] ?? null;

            if (isset($item['quantity']) && $item['quantity'] > 1) {
                // Update DB quantity
                $newQty = $item['quantity'];
                $unitPrice = $item['price'];
                $newPrice = $unitPrice * $newQty;

                $stmt = $mysqli->prepare("UPDATE cart SET Quantity = ?, Price = ? WHERE User_ID = ? AND Service_ID = ? AND (Domain_Name = ? OR Domain_Name IS NULL)");
                $stmt->bind_param("idiis", $newQty, $newPrice, $user_id, $serviceId, $domainName);
                $stmt->execute();
                $stmt->close();
            } else {
                // Remove from DB
                $stmt = $mysqli->prepare("DELETE FROM cart WHERE User_ID = ? AND Service_ID = ? AND (Domain_Name = ? OR Domain_Name IS NULL)");
                $stmt->bind_param("iis", $user_id, $serviceId, $domainName);
                $stmt->execute();
                $stmt->close();
            }
        }

        // Recalculate totals
        $cart_count = 0;
        $cart_total = 0;
        foreach ($_SESSION['cart'] as $c) {
            $qty = $c['quantity'] ?? 1;
            $unit = $c['price'];
            $cart_count += $qty;
            $cart_total += $unit * $qty;
        }

        echo json_encode([
            'status' => 'success',
            'cart' => $_SESSION['cart'],
            'cart_count' => $cart_count,
            'cart_total' => number_format($cart_total, 2)
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Item not found',
            'cart' => $_SESSION['cart'],
            'cart_count' => count($_SESSION['cart']),
            'cart_total' => '0.00'
        ]);
    }
    exit;
}

echo json_encode([
    'status' => 'error',
    'message' => 'No index provided',
    'cart' => $_SESSION['cart'],
    'cart_count' => count($_SESSION['cart']),
    'cart_total' => '0.00'
]);
?>
