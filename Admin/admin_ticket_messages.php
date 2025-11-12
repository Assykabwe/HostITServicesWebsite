<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include '../Includes/db_connection.php';

if (!isset($_SESSION['Admin_ID'])) exit;

$ticketID = intval($_GET['ticket_id'] ?? 0);
$data = [];

if ($ticketID) {
    $stmt = $mysqli->prepare("SELECT Sender_Type, Message, Created_At FROM ticket_replies WHERE Ticket_ID=? ORDER BY Created_At ASC");
    $stmt->bind_param("i", $ticketID);
    $stmt->execute();
    $res = $stmt->get_result();
    while($row = $res->fetch_assoc()) {
        $data[] = [
            'sender' => $row['Sender_Type'],
            'message' => $row['Message'],
            'created_at' => $row['Created_At']
        ];
    }
    $stmt->close();
}

echo json_encode($data);

