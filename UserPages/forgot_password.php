<?php
session_start();
require_once __DIR__ . '/../includes/db_connection.php'; // $mysqli expected

$notice = $_SESSION['reset_notice'] ?? '';
unset($_SESSION['reset_notice']);
$error = $_SESSION['reset_error'] ?? '';
unset($_SESSION['reset_error']);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="../CSS/user_style.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
</head>
<body>
  <?php include '../UserPages/User_Header.php'; ?>

  <section class="register-section">
    <div class="register-card">
      <h2>Forgot Password</h2>

      <?php if ($notice): ?>
        <div class="success-message"><?= htmlspecialchars($notice) ?></div>
      <?php endif; ?>
      <?php if ($error): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form action="process_forgot_password.php" method="post">
        <div class="form-group">
          <label for="email">Enter your registered email</label>
          <input type="email" name="email" id="email" required>
        </div>
        <button type="submit" class="button btn-primary">Send Reset Link</button>
      </form>

      <div class="divider"><span>or</span></div>
      <a href="login.php" class="btn-link">Back to login</a>
    </div>
  </section>

  <?php include '../Components/footer.php'; ?>
</body>
</html>
