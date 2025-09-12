<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" type="text/css" href="../CSS/user_style.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <script src="../JavaScript/user_script.js" defer></script>
  <title>Host IT Services - Transfer Domain</title>
</head>
<body>
  <?php include '../UserPages/User_Header.php'; ?>

  <main class="main-content centered-content">
    <h1>Transfer Your Domain</h1>
    <p>Transfer now to extend your domain by 1 year!*</p>

    <form class="domain-transfer-form">
      <div class="form-group">
        <label for="domain">Domain Name</label>
        <input type="text" id="domain" name="domain" placeholder="example.com" required />
      </div>

      <div class="form-group">
        <label for="auth-code">Authorization Code</label>
        <input type="text" id="auth-code" name="auth_code" placeholder="Enter your Auth Code" required />
      </div>

      <div class="form-group">
        <label for="epp-code">EPP Code / Auth Code</label>
        <input type="text" id="epp-code" name="epp_code" placeholder="Enter your EPP Code" required />
      </div>

      <button type="submit" class="btn">Add to Cart</button>
    </form>
  </main>

  <?php include '../Components/footer.php'; ?>
</body>
</html>
