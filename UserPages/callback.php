<?php
session_start();
require '../Includes/db_connection.php';

// Check Google credential token
if (!isset($_POST['credential'])) {
    die("No Google credential received");
}

$id_token = $_POST['credential'];

// Verify token via Google API
$google_api_url = "https://oauth2.googleapis.com/tokeninfo?id_token=" . $id_token;
$response = file_get_contents($google_api_url);
$user_info = json_decode($response, true);

if (isset($user_info['email'])) {
    $email = $user_info['email'];
    $name = $user_info['name'] ?? 'Google User';
    $picture = $user_info['picture'] ?? '';

    // Check if user exists
    $stmt = $mysqli->prepare("SELECT id, full_name FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // Register new Google user
        $stmt = $mysqli->prepare("INSERT INTO users (full_name, email, password_hash) VALUES (?, ?, '')");
        $stmt->bind_param("ss", $name, $email);
        $stmt->execute();
        $user_id = $stmt->insert_id;
    } else {
        $user = $result->fetch_assoc();
        $user_id = $user['id'];
    }

    $_SESSION['User_ID'] = $user_id;
    $_SESSION['User_Name'] = $name;
    $_SESSION['User_Email'] = $email;

    header("Location: home.php");
    exit;
} else {
    echo "Invalid Google Token.";
}

