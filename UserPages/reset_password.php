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
</head>
<body>
<?php include '../UserPages/User_Header.php'; ?>

<section class="register-section">
    <div class="register-card">
        <a href="home.php" class="logo">
            <img src="../Images/logo2.png" alt="Logo">
            <span class="logo-text">Host IT Services</span>
        </a>
        <h2>Set a New Password</h2>

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
                <input type="checkbox" id="showResetPasswords">
                <label for="showResetPasswords">Show Passwords</label>
            </div>

            <button type="submit" class="btn">Reset Password</button>
        </form>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("resetPasswordForm");
    const newPassword = document.getElementById("newPassword");
    const confirmPassword = document.getElementById("confirmNewPassword");
    const newError = document.getElementById("newPasswordError");
    const confirmError = document.getElementById("confirmNewPasswordError");
    // Toggle visibility
    showPasswords?.addEventListener("change", () => {
        const type = showPasswords.checked ? "text" : "password";
        newPassword.type = type;
        confirmPassword.type = type;
    });

    // Validate before submission
    form.addEventListener("submit", (e) => {
        newError.textContent = "";
        confirmError.textContent = "";
        let hasError = false;

        if (newPassword.value.length < 9 ||
            !/[A-Z]/.test(newPassword.value) ||
            !/[0-9]/.test(newPassword.value) ||
            !/[!@#$%^&*]/.test(newPassword.value)) {
            newError.textContent = "Password must be 9+ chars with uppercase, number, and special char.";
            hasError = true;
        }

        if (newPassword.value !== confirmPassword.value) {
            confirmError.textContent = "Passwords do not match.";
            hasError = true;
        }

        if (hasError) e.preventDefault();
    });
});
</script>

<?php include '../Components/footer.php'; ?>
</body>
</html>


