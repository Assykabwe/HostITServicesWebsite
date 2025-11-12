
<?php
session_start();
include '../Includes/db_connection.php';

// Restrict access to admins only
if (!isset($_SESSION['Admin_ID'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle delete
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $stmt = $mysqli->prepare("DELETE FROM pending_services WHERE ID = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        $msg = "Pending service deleted successfully.";
    } else {
        $error = "Failed to delete pending service.";
    }
    $stmt->close();
}

// Handle update
if (isset($_POST['update_service'])) {
    $id = intval($_POST['service_id']);
    $status = $_POST['status'] ?? '';
    $price = $_POST['price'] ?? '';
    $domain_name = $_POST['domain_name'] ?? '';

    $stmt = $mysqli->prepare("UPDATE pending_services SET Status=?, Price=?, Domain_Name=? WHERE ID=?");
    $stmt->bind_param("sdsi", $status, $price, $domain_name, $id);

    if ($stmt->execute()) {
        $msg = "Pending service updated successfully.";
    } else {
        $error = "Failed to update pending service.";
    }
    $stmt->close();
}

// Fetch all pending services
$result = $mysqli->query("SELECT * FROM pending_services ORDER BY ID DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Pending Services | Admin Panel</title>
    <link rel="stylesheet" href="admin_style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <style>
        .table-container { overflow-x:auto; }
        .admin-table { width:100%; border-collapse:collapse; }
        .admin-table th, .admin-table td { padding:10px; border:1px solid #ddd; text-align:left; }
        .action-btn { padding:5px 10px; margin-right:5px; border:none; border-radius:4px; cursor:pointer; }
        .edit-btn { background:#4caf50; color:#fff; }
        .update-btn { background:#2196f3; color:#fff; }
        .cancel-btn { background:#f44336; color:#fff; }
        .delete-btn { background:#e91e63; color:#fff; text-decoration:none; padding:5px 10px; border-radius:4px; }
        .edit-mode input { width:100%; padding:5px; }
    </style>
</head>
<body>
<?php include 'admin_header.php'; ?>
<div class="admin-container">
    <?php include 'admin_sidebar.php'; ?>

    <main class="admin-main">
        <h1>📝 Manage Pending Services</h1>

        <?php if (!empty($msg)): ?>
            <script>swal("Success", "<?= $msg ?>", "success");</script>
        <?php elseif (!empty($error)): ?>
            <script>swal("Error", "<?= $error ?>", "error");</script>
        <?php endif; ?>

        <div class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Category</th>
                        <th>Service Name</th>
                        <th>Domain Name</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Billing Cycle</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr data-id="<?= $row['ID'] ?>">
                                <td><?= $row['ID'] ?></td>
                                <td><?= $row['User_ID'] ?></td>
                                <td><?= htmlspecialchars($row['Category_Name']) ?></td>
                                <td><?= htmlspecialchars($row['Service_Name']) ?></td>
                                <td class="domain_name"><?= htmlspecialchars($row['Domain_Name'] ?? '-') ?></td>
                                <td class="price"><?= number_format($row['Price'],2) ?></td>
                                <td class="status"><?= ucfirst($row['Status']) ?></td>
                                <td><?= ucfirst($row['Billing_Cycle']) ?></td>
                                <td>
                                    <button class="edit-btn action-btn">Edit</button>
                                    <a href="?delete=<?= $row['ID'] ?>" 
                                       onclick="return confirm('Are you sure you want to delete this service?');"
                                       class="delete-btn">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="9" style="text-align:center;">No pending services found.</td></tr>
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
            if(row.classList.contains('edit-mode')) return;
            row.classList.add('edit-mode');

            const statusCell = row.querySelector('.status');
            const priceCell = row.querySelector('.price');
            const domainCell = row.querySelector('.domain_name');

            const currentStatus = statusCell.textContent.trim();
            const currentPrice = priceCell.textContent.trim().replace(/,/g,'');
            const currentDomain = domainCell.textContent.trim();

            statusCell.innerHTML = `
                <select>
                    <option value="Pending" ${currentStatus=="Pending"?"selected":""}>Pending</option>
                    <option value="Active" ${currentStatus=="Active"?"selected":""}>Active</option>
                    <option value="Completed" ${currentStatus=="Completed"?"selected":""}>Completed</option>
                </select>
            `;
            priceCell.innerHTML = `<input type="number" value="${currentPrice}" step="0.01">`;
            domainCell.innerHTML = `<input type="text" value="${currentDomain}">`;

            btn.style.display = 'none';
            const actionsCell = row.querySelector('td:last-child');

            const updateBtn = document.createElement('button');
            updateBtn.textContent = 'Update';
            updateBtn.className = 'update-btn action-btn';

            const cancelBtn = document.createElement('button');
            cancelBtn.textContent = 'Cancel';
            cancelBtn.className = 'cancel-btn action-btn';

            actionsCell.prepend(updateBtn, cancelBtn);

            updateBtn.addEventListener('click', () => {
                const updatedStatus = statusCell.querySelector('select').value;
                const updatedPrice = priceCell.querySelector('input').value;
                const updatedDomain = domainCell.querySelector('input').value;
                const serviceId = row.dataset.id;

                // Send POST via AJAX
                const formData = new FormData();
                formData.append('service_id', serviceId);
                formData.append('status', updatedStatus);
                formData.append('price', updatedPrice);
                formData.append('domain_name', updatedDomain);
                formData.append('update_service', 1);

                fetch('manage_domain.php', { method:'POST', body:formData })
                    .then(res => res.text())
                    .then(() => location.reload())
                    .catch(err => alert("Failed to update service."));
            });

            cancelBtn.addEventListener('click', () => {
                statusCell.textContent = currentStatus;
                priceCell.textContent = currentPrice;
                domainCell.textContent = currentDomain;
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
