<?php
  session_start();

  // Retrieve server-side validation errors (from process_register.php)
  $errors = $_SESSION['register_errors'] ?? [];
  $oldData = $_SESSION['old_data'] ?? [];
  $success = $_SESSION['registered_success'] ?? false;

  // Clear session messages
  unset($_SESSION['register_errors'], $_SESSION['old_data'], $_SESSION['registered_success']);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <title>Register - HostIT Services</title>
      <link rel="stylesheet" type="text/css" href="../CSS/user_style.css">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
      <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <script src="../JavaScript/register.js" defer></script>
      <script src="../JavaScript/user_script.js" defer></script>
  </head>
  <body>

      <section class="register-section">
          <div class="register-card">
            <!-- Logo Left -->
        <a href="home.php" class="logo">
          <img src="../Images/logo2.png" alt="Logo">
            <span class="logo-text">Host IT Services</span>
        </a>
              <h2>Sign up</h2>
              <form action="../UserPages/process_register.php" method="post" id="registerForm">
                  <div class="form-group">
                    <label for="registerName">Full Name</label>
                    <input type="text" id="registerName" name="full_name" required value="<?= htmlspecialchars($oldData['full_name'] ?? '') ?>">
                    <span class="error-message" id="nameError"></span>
                  </div>

                  <div class="form-group">
                    <label for="registerEmail">Email address</label>
                    <input type="email" id="registerEmail" name="email" required value="<?= htmlspecialchars($oldData['email'] ?? '') ?>">
                    <span class="error-message" id="emailError"></span>
                  </div>

                  <div class="form-group password-group">
                      <label for="registerPassword">Password</label>
                      <input type="password" id="registerPassword" name="password" required>
                      <span class="error-message" id="passwordError"></span>
                  </div>

                  <div class="form-group password-group">
                      <label for="confirmPassword">Confirm Password</label>
                      <input type="password" id="confirmPassword" name="confirmpassword" required>
                      <span class="error-message" id="confirmError"></span>
                  </div>

                  <div class="checkbox-group"> 
                      <input type="checkbox" id="showRegisterPasswords">
                      <label for="showResetPasswords">Show Passwords</label>
                  </div>


                  <button type="submit" class="button btn-primary">Register</button>
                  <a href="login.php" class="btn-link">Already have an account? Login</a>

                  <div class="divider"><span>or</span></div>

                  <div class="social-buttons">
                      <a href="../UserPages/google_login.php" class="btn-google">
                        <img src="https://img.icons8.com/color/20/000000/google-logo.png" alt="Google logo">
                        Register with Google
                      </a>

                    <button class="btn-facebook">
                      <i class="fa-brands fa-facebook-f"></i>
                      Register with Facebook
                    </button>
                  </div>
              </form>
          </div>
      </section>

      <!-- Pass PHP errors and success to JS -->
      <script>
          window.serverErrors = <?= json_encode([
              'full_name' => $errors['full_name'] ?? ($errors[0] ?? ''),
              'email' => $errors['email'] ?? ($errors[1] ?? ''),
              'password' => $errors['password'] ?? ($errors[2] ?? ''),
              'confirm' => $errors['confirm'] ?? ($errors[3] ?? '')
          ]) ?>;

          window.registrationSuccess = <?= $success ? 'true' : 'false' ?>;

          //facebook functionality
          window.fbAsyncInit = function() {
            FB.init({
              appId      : '1452262059177265', // replace with your app ID
              cookie     : true,
              xfbml      : true,
              version    : 'v18.0' // latest version
            });
          };

          (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
          }(document, 'script', 'facebook-jssdk'));
      </script>

  </body>
</html>


