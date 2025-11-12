<?php
session_start();
include '../Includes/db_connection.php';

// Restrict access if not logged in
if (!isset($_SESSION['Admin_ID'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle user deletion
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $stmt = $mysqli->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        $msg = "User deleted successfully.";
    } else {
        $error = "Failed to delete user.";
    }
    $stmt->close();
}

// Handle user update
if (isset($_POST['update_user'])) {
    $user_id = intval($_POST['user_id']);
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];

    $stmt = $mysqli->prepare("UPDATE users SET full_name = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $full_name, $email, $user_id);

    if ($stmt->execute()) {
        $msg = "User updated successfully.";
    } else {
        $error = "Failed to update user.";
    }
    $stmt->close();
}

// Fetch all users
$result = $mysqli->query("SELECT id, full_name, email, Created_At FROM users ORDER BY Created_At DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users | Admin Panel</title>
    <link rel="stylesheet" href="admin_style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <style>
        .edit-mode input { width: 100%; padding: 5px; }
        .action-btn { margin-right: 5px; }
    </style>
</head>
<body>
<?php include 'admin_header.php'; ?>
<div class="admin-container">
    <?php include 'admin_sidebar.php'; ?>

    <main class="admin-main">
        <h1>👤 Manage Users</h1>

        <?php if (!empty($msg)): ?>
            <script>swal("Success", "<?php echo $msg; ?>", "success");</script>
        <?php elseif (!empty($error)): ?>
            <script>swal("Error", "<?php echo $error; ?>", "error");</script>
        <?php endif; ?>

        <div class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr data-id="<?php echo $row['id']; ?>">
                                <td class="user-id"><?php echo $row['id']; ?></td>
                                <td class="full_name"><?php echo htmlspecialchars($row['full_name']); ?></td>
                                <td class="email"><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo date("Y-m-d", strtotime($row['Created_At'])); ?></td>
                                <td class="actions">
                                    <button class="edit-btn action-btn">Edit</button>
                                    <a href="?delete=<?php echo $row['id']; ?>" 
                                       onclick="return confirm('Are you sure you want to delete this user?');"
                                       class="delete-btn action-btn">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5" style="text-align:center;">No users found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const row = btn.closest('tr');
            if (row.classList.contains('edit-mode')) return;

            row.classList.add('edit-mode');

            const fullNameCell = row.querySelector('.full_name');
            const emailCell = row.querySelector('.email');

            const fullName = fullNameCell.textContent;
            const email = emailCell.textContent;

            fullNameCell.innerHTML = `<input type="text" value="${fullName}">`;
            emailCell.innerHTML = `<input type="email" value="${email}">`;

            btn.style.display = 'none';

            const actionsCell = row.querySelector('.actions');
            const updateBtn = document.createElement('button');
            updateBtn.textContent = 'Update';
            updateBtn.className = 'action-btn';
            const cancelBtn = document.createElement('button');
            cancelBtn.textContent = 'Cancel';
            cancelBtn.className = 'action-btn';

            actionsCell.prepend(updateBtn, cancelBtn);

            updateBtn.addEventListener('click', () => {
                const updatedName = fullNameCell.querySelector('input').value;
                const updatedEmail = emailCell.querySelector('input').value;
                const userId = row.dataset.id;

                fetch('update_user.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `user_id=${userId}&full_name=${encodeURIComponent(updatedName)}&email=${encodeURIComponent(updatedEmail)}`
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        fullNameCell.textContent = updatedName;
                        emailCell.textContent = updatedEmail;
                        row.classList.remove('edit-mode');
                        btn.style.display = '';
                        updateBtn.remove();
                        cancelBtn.remove();
                        swal("Success", data.message, "success");
                    } else {
                        swal("Error", data.message, "error");
                    }
                })
                .catch(err => {
                    swal("Error", "AJAX request failed", "error");
                    console.error(err);
                });
            });


            cancelBtn.addEventListener('click', () => {
                fullNameCell.textContent = fullName;
                emailCell.textContent = email;
                row.classList.remove('edit-mode');
                btn.style.display = '';
                updateBtn.remove();
                cancelBtn.remove();
            });
        });
    });
});
</script>
</body>
</html>
