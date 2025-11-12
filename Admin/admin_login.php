<?php
session_start();
include '../Includes/db_connection.php';

// Redirect if already logged in
if (isset($_SESSION['Admin_ID'])) {
    header("Location: dashboard.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        $stmt = $mysqli->prepare("SELECT Admin_ID, Name, Password FROM admins WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();
        $stmt->close();

        if ($admin) {
            // Verify password using PHP hash
            if (password_verify($password, $admin['Password'])) {
                $_SESSION['Admin_ID'] = $admin['Admin_ID'];
                $_SESSION['Admin_Name'] = $admin['Name'];
                header("Location: dashboard.php");
                exit();
            }
        }

        // Generic error to prevent email enumeration
        $error = "Invalid email or password.";
    } else {
        $error = "Please enter both email and password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Host IT Services</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body class="login-body">
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST">
            <label>Email</label>
            <input type="email" name="email" required value="<?php echo htmlspecialchars($email ?? ''); ?>">
            <label>Password</label>
            <input type="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>

