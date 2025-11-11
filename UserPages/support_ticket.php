<?php
    include '../Includes/db_connection.php';
    if (session_status() === PHP_SESSION_NONE) session_start();

    // Show login success popup if needed
    if (!empty($_SESSION['login_success'])) {
        $msg = $_SESSION['login_success'];
        unset($_SESSION['login_success']);
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                swal('Login Successful', '$msg', 'success');
            });
        </script>";
    }

    $userID = $_SESSION['User_ID'] ?? null;
    if (!$userID) {
        header("Location: login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Host IT Services - Support Ticket</title>
    <link rel="stylesheet" type="text/css" href="../CSS/user_style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="../JavaScript/user_script.js" defer></script>
    </head>

    <body>
        <?php include '../UserPages/User_Header.php'; ?>

        <div class="support-container">
            <div class="support-card">
                <h2>Submit a Support Ticket</h2>

                <form id="supportForm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="ticketsubject">Subject</label>
                        <input type="text" id="ticketsubject" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="ticketCategory">Category</label>
                        <input type="text" id="ticketCategory" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="ticketPriority">Priority</label>
                        <select id="ticketPriority" class="form-control" required>
                        <option value="">Select Priority</option>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="ticketfile">Upload File (optional)</label>
                        <input type="file" id="ticketfile" class="form-control-file" accept=".jpg,.png,.pdf,.docx">
                    </div>

                    <div class="form-group">
                        <label for="ticketMessage">Message</label>
                        <textarea id="ticketMessage" rows="5" class="form-control" required></textarea>
                    </div>

                    <div class="button-group">
                        <button type="reset" class="button btn-secondary">Cancel</button>
                        <button type="submit" class="button btn-primary">Submit Ticket</button>
                    </div>
                </form>
            </div>
        </div>

        <section class="support">
        <div class="heading">
            <h1>Your Support Tickets</h1>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Category</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $stmt = $mysqli->prepare("SELECT Subject, Category, Priority, Status, Created_At FROM support_tickets WHERE User_ID = ? ORDER BY Created_At DESC");
                $stmt->bind_param("i", $userID);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['Subject']) . "</td>
                                <td>" . htmlspecialchars($row['Category']) . "</td>
                                <td>" . htmlspecialchars($row['Priority']) . "</td>
                                <td class='" . strtolower($row['Status']) . "'>" . htmlspecialchars($row['Status']) . "</td>
                                <td>" . htmlspecialchars($row['Created_At']) . "</td>
                                </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' style='text-align:center;'>No tickets yet</td></tr>";
                }
                $stmt->close();
                ?>
                </tbody>
            </table>
        </div>
        </section>

        <?php include '../Components/footer.php'; ?>

        <script>
            document.getElementById('supportForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData();
                formData.append('subject', document.getElementById('ticketsubject').value);
                formData.append('category', document.getElementById('ticketCategory').value);
                formData.append('priority', document.getElementById('ticketPriority').value);
                formData.append('message', document.getElementById('ticketMessage').value);
                const file = document.getElementById('ticketfile').files[0];
                if (file) formData.append('file', file);

                fetch('submit_ticket.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        swal('Success!', 'Your support ticket has been submitted successfully!', 'success')
                            .then(() => location.reload());
                    } else {
                        swal('Error', data.message, 'error');
                    }
                })
                .catch(err => {
                    console.error(err);
                    swal('Error', 'Something went wrong while submitting the ticket.', 'error');
                });
            });
        </script>

    </body>
</html>
