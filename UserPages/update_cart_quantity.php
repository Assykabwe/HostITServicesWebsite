<?php
session_start();
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) $_SESSION['cart'] = [];

if (isset($_POST['index'], $_POST['action'])) {
    $index = intval($_POST['index']);
    $action = $_POST['action'];

    if (isset($_SESSION['cart'][$index])) {
        if ($action === 'increase') {
            $_SESSION['cart'][$index]['quantity']++;
        } elseif ($action === 'decrease') {
            if ($_SESSION['cart'][$index]['quantity'] > 1) {
                $_SESSION['cart'][$index]['quantity']--;
            } else {
                array_splice($_SESSION['cart'], $index, 1);
            }
        }
    }

    $cart_total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $cart_total += $item['price'] * $item['quantity'];
    }

    echo json_encode([
        'status' => 'success',
        'cart' => $_SESSION['cart'],
        'cart_count' => count($_SESSION['cart']),
        'cart_total' => number_format($cart_total, 2)
    ]);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
?>

