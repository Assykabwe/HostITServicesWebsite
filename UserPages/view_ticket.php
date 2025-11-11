<?php
include '../Includes/db_connection.php';
session_start();

if (!isset($_SESSION['User_ID'])) {
    echo "<script>
        alert('Please log in to view tickets.');
        window.location.href = 'login.php';
    </script>";
    exit;
}

$userID = $_SESSION['User_ID'];
$ticketID = $_GET['ticket_id'] ?? null;

if (!$ticketID) {
    echo "<script>
        alert('Invalid ticket ID.');
        window.location.href = 'home.php';
    </script>";
    exit;
}

// Fetch ticket details
$query = "SELECT * FROM support_tickets WHERE Ticket_ID = ? AND User_ID = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("ii", $ticketID, $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>
        alert('Ticket not found.');
        window.location.href = 'home.php';
    </script>";
    exit;
}

$ticket = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Ticket - <?php echo htmlspecialchars($ticket['Subject']); ?></title>
    <link rel="stylesheet" href="../CSS/user_style.css">
</head>
<body>
    <?php include '../UserPages/User_Header.php'; ?>

    <section class="ticket-details">
        <div class="heading">
            <h1>Ticket Details</h1>
        </div>

        <div class="ticket-box">
            <p><strong>Subject:</strong> <?php echo htmlspecialchars($ticket['Subject']); ?></p>
            <p><strong>Category:</strong> <?php echo htmlspecialchars($ticket['Category']); ?></p>
            <p><strong>Priority:</strong> <?php echo htmlspecialchars($ticket['Priority']); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($ticket['Status']); ?></p>
            <p><strong>Created At:</strong> <?php echo htmlspecialchars($ticket['Created_At']); ?></p>
            <hr>
            <p><strong>Message:</strong></p>
            <p><?php echo nl2br(htmlspecialchars($ticket['Message'])); ?></p>

            <?php if (!empty($ticket['File_Path'])): ?>
                <p><strong>Attachment:</strong> <a href="../<?php echo htmlspecialchars($ticket['File_Path']); ?>" target="_blank">Download</a></p>
            <?php endif; ?>
        </div>

        <div class="back-btn">
            <a href="home.php" class="btn">← Back to My Tickets</a>
        </div>
    </section>

    <?php include '../Components/footer.php'; ?>
</body>
</html>

