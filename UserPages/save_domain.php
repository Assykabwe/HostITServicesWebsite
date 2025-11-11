<?php
include '../Includes/db_connection.php';
session_start();
header('Content-Type: application/json');

$userID = $_SESSION['User_ID'] ?? null;
if (!$userID) {
    echo json_encode(["success" => false, "message" => "You must be logged in to save a domain."]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$domainName = trim($data['domainName'] ?? '');
$price = floatval($data['price'] ?? 0);
$serviceId = 30; // Domain Services ID in your 'services' table

if (!$domainName) {
    echo json_encode(["success" => false, "message" => "Domain name is required."]);
    exit;
}

// Fetch category and title from `services` table
$stmtFetch = $mysqli->prepare("SELECT category_name, service_title FROM services WHERE id = ?");
$stmtFetch->bind_param("i", $serviceId);
$stmtFetch->execute();
$service = $stmtFetch->get_result()->fetch_assoc();
$stmtFetch->close();

$categoryName = $service['category_name'] ?? 'Domain';
$serviceName  = $service['service_title'] ?? 'Domain Registration';
$billingCycle = 'Annual';

$stmt = $mysqli->prepare("INSERT INTO pending_services 
    (User_ID, Category_Name, Service_Name, Domain_Name, Price, Billing_Cycle, Status)
    VALUES (?, ?, ?, ?, ?, ?, 'pending')");
$stmt->bind_param("isssds", $userID, $categoryName, $serviceName, $domainName, $price, $billingCycle);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Domain saved successfully!",
        "service" => [
            "id" => $stmt->insert_id,
            "domain_name" => $domainName,
            "price" => $price,
            "billing_cycle" => $billingCycle
        ]
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to save domain."]);
}

$stmt->close();
$mysqli->close();
?>
