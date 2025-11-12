<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include '../Includes/db_connection.php';

// Check admin login
if (!isset($_SESSION['Admin_ID'])) {
    header("Location: admin_login.php");
    exit;
}

$adminID = $_SESSION['Admin_ID'] ?? null;

// Handle sending a reply
if (isset($_POST['send_reply'])) {
    $ticketID = intval($_POST['ticket_id']);
    $message = $_POST['message'];

    $stmt = $mysqli->prepare("INSERT INTO ticket_replies (Ticket_ID, Sender_Type, Sender_ID, Message) VALUES (?, 'Admin', ?, ?)");
    $stmt->bind_param("iis", $ticketID, $adminID, $message);
    $stmt->execute();
    $stmt->close();
}

// Handle closing a ticket
if (isset($_POST['close_ticket'])) {
    $ticketID = intval($_POST['ticket_id']);
    $stmt = $mysqli->prepare("UPDATE support_tickets SET Status='Closed' WHERE Ticket_ID=?");
    $stmt->bind_param("i", $ticketID);
    $stmt->execute();
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Tickets</title>
    <link rel="stylesheet" href="admin_style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <style>
        /* Chat-style modal */
        #ticketModal {
            display:none; 
            position:fixed; 
            top:10%; 
            left:25%; 
            width:50%; 
            height:70%; 
            background:#fff; 
            border:1px solid #ccc; 
            box-shadow:0 0 10px rgba(0,0,0,0.3);
            z-index:1000;
            overflow-y:auto;
            padding:15px;
        }
        #ticketModal h3 { margin-top:0; }
        .chat-message { margin:5px 0; padding:8px 12px; border-radius:10px; max-width:80%; }
        .user-msg { background:#e0f7fa; align-self:flex-start; }
        .admin-msg { background:#dcedc8; align-self:flex-end; }
        .chat-container { display:flex; flex-direction:column; }
        .close-btn { float:right; cursor:pointer; background:#f44336; color:#fff; border:none; padding:5px 10px; border-radius:3px; }
    </style>
</head>
<body>

<?php include 'admin_header.php'; ?>
<div class="admin-container">
    <?php include 'admin_sidebar.php'; ?>

    <main class="admin-main">
        <h1>Manage Support Tickets</h1>

        <table border="1" cellpadding="10" style="width:100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Ticket ID</th>
                    <th>User ID</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $tickets = $mysqli->query("SELECT * FROM support_tickets ORDER BY Created_At DESC");

            if ($tickets->num_rows > 0) {
                while($ticket = $tickets->fetch_assoc()) {
                    echo "<tr>
                            <td>{$ticket['Ticket_ID']}</td>
                            <td>{$ticket['User_ID']}</td>
                            <td>{$ticket['Subject']}</td>
                            <td>{$ticket['Status']}</td>
                            <td>{$ticket['Created_At']}</td>
                            <td>
                                <button onclick='openTicket({$ticket['Ticket_ID']})'>View / Reply</button>
                                <form method='post' style='display:inline-block;'>
                                    <input type='hidden' name='ticket_id' value='{$ticket['Ticket_ID']}'>
                                    <button type='submit' name='close_ticket'>Close</button>
                                </form>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='6' style='text-align:center;'>No tickets found.</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </main>
</div>
<!-- Modal -->
<div id="ticketModal">
    <button class="close-btn" onclick="closeTicket()">Close</button>
    <h3>Ticket #<span id="modalTicketID"></span></h3>
    <div id="chatContainer" class="chat-container"></div>

    <form method="post" id="replyForm">
        <input type="hidden" name="ticket_id" id="reply_ticket_id">
        <textarea name="message" placeholder="Type your reply..." required style="width:100%; height:80px; margin-top:10px;"></textarea>
        <button type="submit" name="send_reply">Send Reply</button>
    </form>
</div>

<script>
function openTicket(ticketID){
    document.getElementById('ticketModal').style.display = 'block';
    document.getElementById('modalTicketID').innerText = ticketID;
    document.getElementById('reply_ticket_id').value = ticketID;

    // Load conversation via AJAX
    fetch(`admin_ticket_messages.php?ticket_id=${ticketID}`)
        .then(res => res.json())
        .then(data => {
            const chatContainer = document.getElementById('chatContainer');
            chatContainer.innerHTML = '';
            data.forEach(msg => {
                const div = document.createElement('div');
                div.classList.add('chat-message', msg.sender === 'Admin' ? 'admin-msg' : 'user-msg');
                div.innerHTML = `<strong>${msg.sender}:</strong> ${msg.message}<br><small>${msg.created_at}</small>`;
                chatContainer.appendChild(div);
            });
            chatContainer.scrollTop = chatContainer.scrollHeight;
        });
}

function closeTicket(){
    document.getElementById('ticketModal').style.display = 'none';
}
</script>

</body>
</html>



