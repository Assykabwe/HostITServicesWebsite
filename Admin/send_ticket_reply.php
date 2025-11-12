<?php
include '../Includes/db_connection.php';
session_start();

if (!isset($_COOKIE['Admin_ID'])) {
    header("Location: admin_login.php");
    exit;
}

$ticket_id = $_POST['ticket_id'];
$message = trim($_POST['message']);
$admin_id = $_COOKIE['Admin_ID'];

if ($message !== "") {
    $stmt = $conn->prepare("INSERT INTO ticket_replies (Ticket_ID, Sender_Type, Sender_ID, Message) VALUES (?, 'Admin', ?, ?)");
    $stmt->bind_param("iis", $ticket_id, $admin_id, $message);
    $stmt->execute();
}

header("Location: admin_view_ticket.php?id=$ticket_id");
exit;

