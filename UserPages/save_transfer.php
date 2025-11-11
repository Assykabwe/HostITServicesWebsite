<?php
include '../Includes/db_connection.php';
session_start();
header('Content-Type: application/json');

$userID = $_SESSION['User_ID'] ?? null;
if (!$userID) {
    echo json_encode(["success" => false, "message" => "You must be logged in."]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$domainName = trim($data['domain_name'] ?? '');
$authCode = trim($data['auth_code'] ?? '');
$eppCode = trim($data['epp_code'] ?? '');
$price = 500; // Default transfer price

if (!$domainName || !$authCode || !$eppCode) {
    echo json_encode(["success" => false, "message" => "Please fill in all fields."]);
    exit;
}

// ✅ Fetch from services (to get category_name and service_title for Domain Transfer)
$stmt = $mysqli->prepare("SELECT category_name, service_title FROM services WHERE service_title = 'Domain Transfer' LIMIT 1");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    $categoryName = 'Domain';
    $serviceName = 'Domain Transfer';
} else {
    $dataRow = $result->fetch_assoc();
    $categoryName = $dataRow['category_name'];
    $serviceName = $dataRow['service_title'];
}
$stmt->close();

// ✅ Automatically decide Billing Cycle
$billingCycle = (!empty($domainName)) ? 'Annual' : 'Monthly';

// ✅ Prevent duplicates
$stmt = $mysqli->prepare("SELECT COUNT(*) FROM pending_services WHERE User_ID=? AND Domain_Name=? AND Service_Name=?");
$stmt->bind_param("iss", $userID, $domainName, $serviceName);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

if ($count > 0) {
    echo json_encode(["success" => false, "message" => "This domain transfer is already pending."]);
    exit;
}

// ✅ Insert into pending_services
$stmt = $mysqli->prepare("
    INSERT INTO pending_services (User_ID, Category_Name, Service_Name, Domain_Name, Price, Status, Billing_Cycle)
    VALUES (?, ?, ?, ?, ?, 'pending', ?)
");
$stmt->bind_param("isssds", $userID, $categoryName, $serviceName, $domainName, $price, $billingCycle);

if ($stmt->execute()) {
    $pendingID = $stmt->insert_id;
    echo json_encode([
        "success" => true,
        "message" => "Domain transfer added to pending services.",
        "service" => [
            "id" => $pendingID,
            "service_title" => $serviceName,
            "category_name" => $categoryName,
            "price" => $price,
            "domain_name" => $domainName,
            "billing_cycle" => $billingCycle,
            "quantity" => 1
        ]
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Database error: " . $stmt->error]);
}

$stmt->close();
$mysqli->close();
?>
