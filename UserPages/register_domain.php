<?php include '../Components/User_Header.php'; ?>
<?php include '../Components/Sidebar.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register Domain</title>
  <link rel="stylesheet" href="../CSS/user_style.css" />
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
</head>
<body>
  <div class="main-content">
    <h2>Register a New Domain</h2>

    <form action="domain_search.php" method="POST" class="domain-search-form">
      <label for="domain_name">Find your new domain name:</label>
      <input type="text" id="domain_name" name="domain_name" placeholder="Enter domain or keywords" required />
      <button type="submit">Search</button>
    </form>

    <div class="domain-options">
      <div class="domain-box">
        <h3>.com</h3>
        <p>R300.00/yr</p>
      </div>
      <div class="domain-box">
        <h3>.net</h3>
        <p>R368.44/yr</p>
      </div>
    </div>

    <div class="currency-selector">
      <label for="currency">Choose Currency:</label>
      <select id="currency" name="currency">
        <option value="ZAR" selected>ZAR</option>
        <option value="USD">USD</option>
        <option value="EUR">EUR</option>
      </select>
    </div>

    <div class="promo-actions">
      <div class="promo-box">
        <h4>Add Web Hosting</h4>
        <a href="services.php" class="btn">Explore Packages Now</a>
      </div>
      <div class="promo-box">
        <h4>Transfer your domain to us</h4>
        <a href="transfer_domain.php" class="btn">Transfer a Domain</a>
      </div>
    </div>
  </div>
</body>
</html>
