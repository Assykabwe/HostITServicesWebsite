<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include '../Includes/db_connection.php';

// Check admin login
if (!isset($_SESSION['Admin_ID'])) {
    header("Location: admin_login.php");
    exit;
}

// Add Service
if (isset($_POST['add_service'])) {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $price = $_POST['price'];

    $stmt = $mysqli->prepare("INSERT INTO services (service_title, category, price) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $title, $category, $price);
    $stmt->execute();
    $stmt->close();
}

// Edit Service
if (isset($_POST['edit_service'])) {
    $id = intval($_POST['service_id']);
    $title = $_POST['title'];
    $category = $_POST['category'];
    $price = $_POST['price'];

    $stmt = $mysqli->prepare("UPDATE services SET service_title=?, category=?, price=? WHERE service_id=?");
    $stmt->bind_param("ssdi", $title, $category, $price, $id);
    $stmt->execute();
    $stmt->close();
}

// Delete Service
if (isset($_POST['delete_service'])) {
    $id = intval($_POST['service_id']);
    $stmt = $mysqli->prepare("DELETE FROM services WHERE service_id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Fetch all services
$services = $mysqli->query("SELECT * FROM services ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Services</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

<?php include 'admin_header.php'; ?>
<div class="admin-container">
    <?php include 'admin_sidebar.php'; ?>
    <main class="admin-main">
    <h1>Manage Services</h1>

    <!-- Add Service Form -->
    <h3>Add New Service</h3>
    <form method="post">
        <input type="text" name="title" placeholder="Service Title" required>
        <select name="category" required>
            <option value="">Select Category</option>
            <option value="Hosting">Hosting</option>
            <option value="Domain">Domain</option>
        </select>
        <input type="number" name="price" placeholder="Price" step="0.01" required>
        <button type="submit" name="add_service">Add Service</button>
    </form>

    <hr>

    <!-- Existing Services -->
    <h3>Existing Services</h3>
    <table border="1" cellpadding="10" style="width:100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($service = $services->fetch_assoc()): ?>
                <tr>
                    <td><?= $service['id'] ?></td>
                    <td><?= $service['service_title'] ?></td>
                    <td><?= $service['category_name'] ?></td>
                    <td>R<?= number_format($service['price'],2) ?></td>
                    <td>
                        <!-- Edit / Delete Forms -->
                        <form method="post" style="display:inline-block;">
                            <input type="hidden" name="service_id" value="<?= $service['id'] ?>">
                            <input type="text" name="title" value="<?= $service['service_title'] ?>" required>
                            <select name="category" required>
                                <option value="Hosting" <?= $service['category_name']=='Hosting'?'selected':'' ?>>Hosting</option>
                                <option value="Domain" <?= $service['category_name']=='Domain'?'selected':'' ?>>Domain</option>
                            </select>
                            <input type="number" name="price" value="<?= $service['price'] ?>" step="0.01" required>
                            <button type="submit" name="edit_service">Update</button>
                        </form>

                        <form method="post" style="display:inline-block;">
                            <input type="hidden" name="service_id" value="<?= $service['id'] ?>">
                            <button type="submit" name="delete_service" style="background:#f44336; color:#fff;">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </main>
</div>
</body>
</html>

