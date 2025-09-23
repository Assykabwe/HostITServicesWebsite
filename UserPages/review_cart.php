<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" type="text/css" href="../CSS/user_style.css" />
  <script src="../JavaScript/user_script.js" defer></script>
  <title>Host IT Services - Review & Checkout</title>
</head>
<body>
  <?php include '../UserPages/User_Header.php'; ?>

  <section class="services-container">
    <!-- Sidebar -->
    <div class="sidebar">
      <h3>Categories</h3>
      <ul>
        <li><a href="#" data-target="web_hosting">Web Hosting</a></li>
        <li><a href="#" data-target="website_design">Website Design</a></li>
        <li><a href="#" data-target="ecommerce">E-Commerce Website</a></li>
        <li><a href="#" data-target="social_media">Social Media Management</a></li>
        <li><a href="#" data-target="branding">Branding Design</a></li>
        <li><a href="#" data-target="graphic">Graphic Design</a></li>
      </ul>
      <h3>Actions</h3>
      <ul>
        <li><a href="/HOSTITSERVICESWEBSITE-1/UserPages/register_domain.php">Register a New Domain</a></li>
        <li><a href="/HOSTITSERVICESWEBSITE-1/UserPages/transfer_domain.php">Transfer in a Domain</a></li>
        <li><a href="/HOSTITSERVICESWEBSITE-1/UserPages/cart.php">View Cart</a></li>
      </ul>
      <h3>Choose Currency</h3>
      <select>
        <option>ZAR</option>
        <option>USD</option>
        <option>EUR</option>
      </select>
    </div>

    <!-- Main Content -->
    <main class="main-content">
      <h1>Review & Checkout</h1>

      <div class="checkout-tabs">
        <button class="tab active">Product/Options</button>
        <button class="tab">Price/Cycle</button>
      </div>

      <div class="cart-status">
        <p>Your Shopping Cart is Empty</p>
      </div>

      <form class="promo-code-form">
        <input type="text" placeholder="Enter Promo Code" />
        <button type="submit" class="btn">Validate Code</button>
      </form>

      <div class="order-summary-box">
        <p><strong>Subtotal:</strong> R0.00 ZAR</p>
        <p><strong>Total Due Today:</strong> R0.00 ZAR</p>
        <button class="btn checkout-btn">Checkout</button>
      </div>
    </main>
  </section>

  <?php include '../Components/footer.php'; ?>
</body>
</html>
