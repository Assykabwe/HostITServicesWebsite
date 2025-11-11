<?php
session_start();

// Unset all session variables
$_SESSION = array();

// If there's an admin cookie, delete it
if (isset($_COOKIE['id'])) {
    setcookie('id', '', time() - 3600, '/'); // expire cookie
}

// Destroy the session completely
session_destroy();

// Redirect to login page or homepage
header("Location: home.php");
exit;
?>

