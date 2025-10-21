<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - HostIT Services</title>
  <link rel="stylesheet" type="text/css" href="../CSS/user_style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="../JavaScript/user_script.js" defer></script>
</head>
<body>
  <!-- Header -->
  <?php include '../UserPages/User_Header.php';?>

        <section class="register-section">
          <div class="register-card">
            <h2>Login</h2>
            <form>
              <div class="form-group">
                <label for="loginEmail">Email address</label>
                <input type="email" id="loginEmail" required>
              </div>
              <div class="form-group">
                <label for="loginPassword">Password</label>
                <input type="password" id="loginPassword" required>
              </div>
              <button type="submit" class="button btn-primary">Login</button>
              <a href="register.php" class="btn-link">Register</a>
            </form>

            <div class="divider"><span>or</span></div>

            <div class="social-buttons">
              <button class="btn-google">
                <img src="https://img.icons8.com/color/20/000000/google-logo.png" alt="Google logo">
                Register with Google
              </button>
              <button class="btn-facebook">
                <i class="fa-brands fa-facebook-f"></i>
                Register with Facebook
              </button>
            </div>
          </div>
        </section>

  <!-- Footer -->
  <?php include '../Components/footer.php';?>
</body>
</html>
