<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="../CSS/user_style.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <script src="../JavaScript/user_script.js" defer></script>
  <title>Host IT Services - Register Domain</title>
</head>
<body>
  <?php include '../UserPages/User_Header.php';?>

  <main class="main-content centered-content">
  <h1>Register Domain</h1>
  <h2>Starter Web Hosting</h2>
  <p>Find your new domain name. Enter your name or keywords below to check availability.</p>

  <form class="domain-search-form">
    <input type="text" placeholder="Find your new domain name" required />
    <button type="submit" class="btn">Search</button>
  </form>

  <div class="domain-options">
    <div class="domain-card">
      <h3>.com</h3>
      <p>R300.00/yr</p>
    </div>
    <div class="domain-card">
      <h3>.net</h3>
      <p>R368.44/yr</p>
    </div>
  </div>

  <ul class="domain-tabs">
    <li class="active">Popular</li>
    <li>New</li>
    <li>Cheap</li>
    <li>Transfer</li>
    <li>Renewal</li>
  </ul>

  <div class="promo-section">
    <div class="promo-box">
      <h4>Add Web Hosting</h4>
      <p>You can add web hosting to your domain purchase by selecting a hosting package.</p>
      <a href="services.php" class="btn">Explore Packages Now</a>
    </div>
    <div class="promo-box">
      <h4>Transfer your domain to us</h4>
      <p>Transfer your domain to us and extend your domain by 1 year.</p>
      <a href="transfer_domain.php" class="btn">Transfer a Domain</a>
    </div>
  </div>
</main>

  <?php include '../Components/footer.php';?>
</body>
</html>
