<?php
include '../Includes/db_connection.php';
session_start();

// Check admin login
if (!isset($_COOKIE['Admin_ID'])) {
    header("Location: admin_login.php");
    exit;
}

$ticket_id = $_GET['id'] ?? null;
if (!$ticket_id) {
    die("Invalid ticket ID");
}

// Fetch ticket info
$query = "SELECT st.*, u.Name AS UserName, u.Email
          FROM support_tickets st
          JOIN users u ON st.User_ID = u.User_ID
          WHERE st.Ticket_ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $ticket_id);
$stmt->execute();
$ticket = $stmt->get_result()->fetch_assoc();

if (!$ticket) {
    die("Ticket not found");
}

// Fetch replies
$replies_query = "SELECT * FROM ticket_replies WHERE Ticket_ID = ? ORDER BY Created_At ASC";
$stmt_replies = $conn->prepare($replies_query);
$stmt_replies->bind_param("i", $ticket_id);
$stmt_replies->execute();
$replies = $stmt_replies->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ticket #<?= $ticket_id; ?> - Admin Reply</title>
    <link rel="stylesheet" href="../Admin/admin_style.css">
    <style>
        .chat-box {
            background: #f9f9f9;
            border: 1px solid #ccc;
            padding: 1em;
            max-width: 800px;
            margin: 1em auto;
            border-radius: 8px;
        }
        .reply {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 10px;
            width: fit-content;
            max-width: 70%;
            clear: both;
        }
        .reply.admin {
            background-color: #d1e7ff;
            float: right;
            text-align: right;
        }
        .reply.user {
            background-color: #e8e8e8;
            float: left;
        }
        .reply small {
            display: block;
            font-size: 0.8em;
            color: #555;
            margin-top: 5px;
        }
        form.reply-form {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        form.reply-form textarea {
            resize: none;
            padding: 10px;
            height: 100px;
        }
        form.reply-form button {
            width: 150px;
            align-self: flex-end;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        form.reply-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<?php include 'admin_header.php'; ?>
<div class="admin-container">
    <?php include 'admin_sidebar.php'; ?>

    <main class="admin-main">
    <h2>🎫 Ticket #<?= $ticket_id; ?> — <?= htmlspecialchars($ticket['Subject']); ?></h2>
    <p><strong>User:</strong> <?= htmlspecialchars($ticket['UserName']); ?> (<?= $ticket['Email']; ?>)</p>
    <p><strong>Category:</strong> <?= htmlspecialchars($ticket['Category']); ?></p>
    <p><strong>Priority:</strong> <?= htmlspecialchars($ticket['Priority']); ?></p>
    <p><strong>Status:</strong> <?= htmlspecialchars($ticket['Status']); ?></p>
    <p><strong>Message:</strong><br><?= nl2br(htmlspecialchars($ticket['Message'])); ?></p>

    <?php if (!empty($ticket['File_Path'])): ?>
        <p><strong>Attached File:</strong>
            <a href="../Uploads/<?= htmlspecialchars($ticket['File_Path']); ?>" target="_blank">Download</a>
        </p>
    <?php endif; ?>

    <hr>

    <h3>Conversation</h3>
    <div class="chat-box">
        <?php if ($replies->num_rows > 0): ?>
            <?php while ($reply = $replies->fetch_assoc()): ?>
                <div class="reply <?= strtolower($reply['Sender_Type']); ?>">
                    <p><?= nl2br(htmlspecialchars($reply['Message'])); ?></p>
                    <small>
                        <?= ucfirst($reply['Sender_Type']); ?> |
                        <?= date('M d, Y H:i', strtotime($reply['Created_At'])); ?>
                    </small>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align:center;">No replies yet.</p>
        <?php endif; ?>
        <div style="clear:both;"></div>
    </div>

    <form class="reply-form" action="send_ticket_reply.php" method="POST">
        <input type="hidden" name="ticket_id" value="<?= $ticket_id; ?>">
        <textarea name="message" placeholder="Type your reply here..." required></textarea>
        <button type="submit">Send Reply</button>
    </form>

    <form action="update_ticket_status.php" method="POST" style="margin-top:20px;">
        <input type="hidden" name="ticket_id" value="<?= $ticket_id; ?>">
        <select name="status">
            <option value="Open" <?= $ticket['Status'] == 'Open' ? 'selected' : ''; ?>>Open</option>
            <option value="Pending" <?= $ticket['Status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
            <option value="Closed" <?= $ticket['Status'] == 'Closed' ? 'selected' : ''; ?>>Closed</option>
        </select>
        <button type="submit" class="btn">Update Status</button>
    </form>
    </main>
</div>
</body>
</html>

