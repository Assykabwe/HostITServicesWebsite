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
                <a href="register_domain.php" class="<?= ($current_page === 'register_domain.php') ? 'active' : '' ?>">register domain</a>
                <a href="transfer_domain.php" class="<?= ($current_page === 'transfer_domain.php') ? 'active' : '' ?>">transfer domain</a>
                <a href="support_ticket.php" class="<?= ($current_page === 'support_ticket.php') ? 'active' : '' ?>">support ticket</a>
            </nav>
            <!-- Icons -->
            <div class="header-icons">
                <div class="icons">
                    <div class="user-icon">
                        <p>account</p>
                        <a class="icon-link">
                            <i class="fa-solid fa-square-check"></i>
                    </div>
                    <a href="cart.php" class="icon-link">
                        <button class="btn">view cart</button>
                    </a>
                    <div class="menu-bar">
                        <i class="fa-solid fa-bars"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>
</header>
