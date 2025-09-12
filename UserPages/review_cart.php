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

  <main class="checkout-wrapper">
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
      <p><strong>Total:</strong> R0.00 ZAR</p>
      <p><strong>Total Due Today:</strong> R0.00 ZAR</p>
      <button class="btn checkout-btn">Checkout</button>
    </div>
  </main>

  <?php include '../Components/footer.php'; ?>
</body>
</html>
