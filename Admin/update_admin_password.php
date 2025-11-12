<?php
include '../Includes/db_connection.php';

// Admin email and the new password you want to set
$adminEmail = 'admin@hostit.com';
$newPassword = 'admin123';

// Generate a PHP-compatible hash
$hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

// Update the password in the database
$stmt = $mysqli->prepare("UPDATE admins SET Password = ? WHERE Email = ?");
$stmt->bind_param("ss", $hashedPassword, $adminEmail);

if ($stmt->execute()) {
    echo "Admin password updated successfully!";
} else {
    echo "Error updating password: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
?>

