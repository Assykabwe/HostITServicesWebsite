<header class="header">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <section class="flex">
        <div class="header-top">
            <!-- Logo Left -->
            <a href="home.php" class="logo">
                <img src="../Images/logo2.png" alt="Logo">
                <span class="logo-text">Host IT Services</span>
            </a>

            <!-- Right side: Navbar + Account + Cart -->
            <div class="right-section">
                <?php 
                    $current_page = basename($_SERVER['PHP_SELF']); 
                ?>
                <nav class="navbar" id="menulist">
                    <a href="home.php" class="<?= ($current_page === 'home.php') ? 'active' : '' ?>">home</a>
                    <a href="services.php" class="<?= ($current_page === 'services.php') ? 'active' : '' ?>">services</a>
                    <a href="support_ticket.php" class="<?= ($current_page === 'support_ticket.php') ? 'active' : '' ?>">support ticket</a>
                </nav>

                <div class="header-icons">
                    <div class="user-icon">
                        <p>account</p>
                        <i class="fa-solid fa-square-check"></i>
                    </div>
                    <a href="#" class="icon-link view-cart-link">
                        <button class="btn">view cart</button>
                    </a>
                </div>
            </div>
        </div>

        <!-- Profile Section -->
        <div class="profile-detail">
            <?php if (isset($_SESSION['User_Name'])): ?>
                <h3>
                    <a href="profile.php" class="user-name-link">
                        <?= htmlspecialchars($_SESSION['User_Name']); ?>
                    </a>
                </h3>
                <div class="flex-btn">
                    <a href="logout.php" class="btn logout-btn">Logout</a>
                    <p><a href="forgot_password.php">Forgot password?</a></p>
                </div>
            <?php else: ?>
                <h3>Sign up or Sign in</h3>
                <div class="flex-btn">
                    <a href="login.php" class="btn">Login</a>
                    <a href="register.php" class="btn">Register</a>
                    <p><a href="forgot_password.php">Forgot password?</a></p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</header>


