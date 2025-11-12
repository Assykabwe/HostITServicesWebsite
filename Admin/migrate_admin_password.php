<?php
include '../Includes/db_connection.php';

// Example: plain text passwords for admins
// Key = admin email, Value = plain password
$adminPasswords = [
    'admin@hostit.com' => 'admin123',
    // Add more admins here if needed:
    // 'otheradmin@example.com' => 'theirpassword'
];

foreach ($adminPasswords as $email => $plainPassword) {
    // Fetch admin by email
    $stmt = $mysqli->prepare("SELECT Admin_ID FROM admins WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if (!$admin) {
        echo "Admin with email $email not found.<br>";
        continue;
    }

    // Hash the plain password
    $newHash = password_hash($plainPassword, PASSWORD_DEFAULT);

    // Update the password in the database
    $updateStmt = $mysqli->prepare("UPDATE admins SET Password = ? WHERE Admin_ID = ?");
    $updateStmt->bind_param("si", $newHash, $admin['Admin_ID']);
    if ($updateStmt->execute()) {
        echo "Password migrated successfully for $email.<br>";
    } else {
        echo "Error updating password for $email: " . $mysqli->error . "<br>";
    }

    $updateStmt->close();
    $stmt->close();
}

$mysqli->close();

echo "<br>All specified admins have been migrated. Please delete this script for security.";

