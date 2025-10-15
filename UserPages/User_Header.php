<header class="header">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <section class="flex">
        <div class="header-top">
            <!-- Logo -->
            <a href="home.php" class="logo">
                <img src="../Images/logo2.png" alt="Logo">
            </a>

            <!-- Navigation -->
            <?php $current_page = basename($_SERVER['PHP_SELF']); ?>
            <nav class="navbar" id="menulist">
                <a href="home.php" class="<?= ($current_page === 'home.php') ? 'active' : '' ?>">home</a>
                <a href="services.php" class="<?= ($current_page === 'services.php') ? 'active' : '' ?>">services</a>
                <a href="support_ticket.php" class="<?= ($current_page === 'support_ticket.php') ? 'active' : '' ?>">support ticket</a>
            </nav>
            <!-- Icons -->
            <div class="header-icons">
                <div class="icons">
                    <div class="user-icon">
                        <p>account</p>
                        <i class="fa-solid fa-square-check"></i>
                    </div>
                    <a href="../UserPages/services.php" data-target="view_cart" class="icon-link">
                        <button class="btn">view cart</button>
                    </a>
                    <div class="menu-bar">
                        <i class="fa-solid fa-bars"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Section -->
        <div class="profile-detail">
            <h3>Sign up or Sign in</h3>
            <div class="flex-btn">
                <a href="../Components/login.php" class="btn">Login</a>
                <a href="../Components/register.php" class="btn">Register</a>
                <p>Forget password?</p>
            </div>
        </div>
    </section>
</header>
