<?php 
session_start();
require_once __DIR__ . '/../includes/db_connection.php'; // $mysqli

$token = $_GET['token'] ?? '';
$token = trim($token);

if (empty($token)) {
    exit('Invalid token.');
}

// Verify token
$stmt = $mysqli->prepare("SELECT email, expires_at FROM password_resets WHERE token = ? LIMIT 1");
$stmt->bind_param("s", $token);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    exit('Invalid or expired token.');
}

$row = $res->fetch_assoc();
if (strtotime($row['expires_at']) < time()) {
    // token expired - cleanup and message
    $del = $mysqli->prepare("DELETE FROM password_resets WHERE token = ?");
    $del->bind_param("s", $token);
    $del->execute();
    exit('This reset link has expired.');
}

$reset_email = $row['email'];
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Reset Password</title>
        <link rel="stylesheet" href="../CSS/user_style.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <script src="../JavaScript/RegisterLoginReset.js" defer></script>
        <script src="../JavaScript/user_script.js" defer></script>
        <script></script>
    </head>
    <body>
        <?php include '../UserPages/User_Header.php'; ?>

        <section class="register-section">
            <!-- Logo Left -->
            <a href="home.php" class="logo">
            <img src="../Images/logo2.png" alt="Logo">
                <span class="logo-text">Host IT Services</span>
            </a>
            <div class="register-card">
                <h2>Set a New Password</h2>

                <?php if (!empty($_SESSION['reset_error'])): ?>
                    <div class="error-message"><?= htmlspecialchars($_SESSION['reset_error']) ?></div>
                    <?php unset($_SESSION['reset_error']); endif; ?>

                <form id="resetPasswordForm" action="process_reset_password.php" method="POST">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token, ENT_QUOTES, 'UTF-8') ?>">

                    <div class="form-group">
                        <label for="newPassword">New Password:</label>
                        <input type="password" id="newPassword" name="new_password" required>
                        <small id="newPasswordError" class="error-message"></small>
                    </div>

                    <div class="form-group">
                        <label for="confirmNewPassword">Confirm Password:</label>
                        <input type="password" id="confirmNewPassword" name="confirm_password" required>
                        <small id="confirmNewPasswordError" class="error-message"></small>
                    </div>

                    <div class="checkbox-group"> 
                        <input type="checkbox" id="showLoginPassword">
                        <label for="showResetPasswords">Show Passwords</label>
                    </div>

                    <button type="submit" class="btn">Reset Password</button>
                </form>
            </div>
        </section>

        <?php include '../Components/footer.php'; ?>
    </body>
</html>

