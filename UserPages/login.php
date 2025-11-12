<?php
session_start();
$oldData = $_SESSION['old_data'] ?? [];
$errors = $_SESSION['login_errors'] ?? [];
unset($_SESSION['old_data'], $_SESSION['login_errors']);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Login - HostIT Services</title>
    <link rel="stylesheet" type="text/css" href="../CSS/user_style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="../JavaScript/register.js" defer></script>
    <script src="../JavaScript/user_script.js" defer></script>
  </head>
  <body>


      <section class="register-section">
        <!-- Logo Left -->
        <a href="home.php" class="logo">
          <img src="../Images/logo2.png" alt="Logo">
            <span class="logo-text">Host IT Services</span>
        </a>
        <div class="register-card">
          <h2>Login</h2>
          <form action="../UserPages/process_login.php" method="post" id="loginForm">
            
            <!-- Email -->
            <div class="form-group">
              <label for="loginEmail">Email address</label>
              <input type="email" id="loginEmail" name="email" 
                    required 
                    value="<?= htmlspecialchars($_SESSION['old_login']['email'] ?? '') ?>">
              <span class="error-message" id="emailError">
                <?= $_SESSION['login_errors']['email'] ?? '' ?>
              </span>
            </div>

            <!-- Password -->
            <div class="form-group">
              <label for="loginPassword">Password</label>
              <input type="password" id="loginPassword" name="password" required>
              <span class="error-message" id="passwordError">
                <?= $_SESSION['login_errors']['password'] ?? '' ?>
              </span>
            </div>

            <!-- Show Password Checkbox -->
            <div class="checkbox-group"> 
              <input type="checkbox" id="showLoginPassword">
              <label for="showResetPasswords">Show Password</label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="button btn-primary">Login</button>

            <a href="register.php" class="btn-link">Do not have an account? Register</a>
          </form>

          <div class="divider"><span>or</span></div>

          <div class="social-buttons">
            <button class="btn-google">
              <img src="https://img.icons8.com/color/20/000000/google-logo.png" alt="Google logo">
              Login with Google
            </button>
            <button class="btn-facebook">
              <i class="fa-brands fa-facebook-f"></i>
              Login with Facebook
            </button>
          </div>
        </div>
      </section>

      <?php
      // Clear login errors after displaying
      unset($_SESSION['login_errors'], $_SESSION['old_login']);
      ?>

      
  </body>
</html>

