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
    <title>Host IT Services - Services</title>
</head>
<body>
    <?php include '../UserPages/User_Header.php';?>

    <section class="services-container">
        <div class="service">
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
            <div class="main-content">
                <!-- Web Hosting (default active) -->
                <div id="web_hosting" class="content-section active">
                    <h2>Web Hosting</h2>
                    <div class="plans">
                        <div class="plan-card">
                            <h4>Starter Web Hosting</h4>
                            <ul>
                                <li>3GB Storage (SSD)</li>
                                <li>1 website domain</li>
                                <li>10 email accounts</li>
                                <li>Unlimited bandwidth</li>
                                <li>Free cPanel</li>
                                <li>Free SSL Certificate</li>
                                <li>Free Website Migration</li>
                            </ul>
                            <div class="price">R99.00 ZAR / Monthly</div>
                            <a href="#" class="order-btn">Order Now</a>
                        </div>

                        <div class="plan-card">
                            <h4>Basic Web Hosting</h4>
                            <ul>
                                <li>5GB Storage (SSD)</li>
                                <li>3 website domains</li>
                                <li>25 email accounts</li>
                                <li>Unlimited bandwidth</li>
                                <li>Free cPanel</li>
                                <li>Free SSL Certificate</li>
                                <li>Free Website Migration</li>
                            </ul>
                            <div class="price">R149.00 ZAR / Monthly</div>
                            <a href="#" class="order-btn">Order Now</a>
                        </div>

                        <div class="plan-card">
                            <h4>Pro Web Hosting</h4>
                            <ul>
                                <li>10GB Storage (SSD)</li>
                                <li>5 website domains</li>
                                <li>100 email accounts</li>
                                <li>Unlimited bandwidth</li>
                                <li>Free cPanel</li>
                                <li>Free SSL Certificate</li>
                                <li>Free Website Migration</li>
                            </ul>
                            <div class="price">R190.00 ZAR / Monthly</div>
                            <a href="#" class="order-btn">Order Now</a>
                        </div>

                        <div class="plan-card">
                            <h4>Hosting Business</h4>
                            <ul>
                                <li>20GB Storage (SSD)</li>
                                <li>Free .co.za Domain</li>
                                <li>10 website domains</li>
                                <li>10 FTP Accounts</li>
                                <li>Unlimited email accounts</li>
                                <li>Unlimited bandwidth</li>
                                <li>Free cPanel</li>
                                <li>Free SSL Certificate</li>
                                <li>Free Website Migration</li>
                            </ul>
                            <div class="price">R350.00 ZAR / Monthly</div>
                            <a href="#" class="order-btn">Order Now</a>
                        </div>
                    </div>
                </div>
                <!-- Website Design -->
                <div id="website_design" class="content-section">
                    <h2>Website Design</h2>
                    <div class="plans">
                        <div class="plan-card">
                            <h4>Landing Page</h4>
                            <ul>
                                <li>1 Page Website</li>
                                <li>Responsive Design (Mobile-Friendly)</li>
                                <li>SEO-Friendly Setup</li>
                                <li>FREE Business Emails</li>
                                <li>FREE .co.za Domain (1 Year)</li>
                                <li>FREE SSL Certificate</li>
                                <li>Clear Call-to-Action Buttons</li>
                                <li>Fast Loading Speed</li>
                                <li>Priority Support</li>
                            </ul>
                            <div class="price">R2,500.00 ZAR / Monthly</div>
                            <a href="#" class="order-btn">Order Now</a>
                        </div>

                        <div class="plan-card">
                            <h4>Basic Website</h4>
                            <ul>
                                <li> 1-3 Website Pages</li>
                                <li>Responsive Design (Mobile-Friendly)</li>
                                <li>SEO-Friendly Setup</li>
                                <li>FREE Business Emails</li>
                                <li>FREE .co.za Domain (1 Year)</li>
                                <li>FREE .com Domain (1 Year)</li>
                                <li>FREE Website Hosting (1 Year)</li>
                                <li>Multi-Page Design</li>
                                <li>Social Media Integration</li>
                                <li>WhatsApp Chat Integration</li>
                                <li>Google Business Profile Setup</li>
                            </ul>
                            <div class="price">R4,500.00 ZAR</div>
                            <a href="#" class="order-btn">Order Now</a>
                        </div>

                        <div class="plan-card">
                            <h4>Professional Website</h4>
                            <ul>
                                <li>1-6 Website Pages</li>
                                <li>Responsive Design (Mobile-Friendly)</li>
                                <li>SEO-Friendly Setup</li>
                                <li>FREE Business Emails</li>
                                <li>FREE .co.za Domain (1 Year)</li>
                                <li>FREE .com Domain (1 Year)</li>
                                <li>FREE Website Hosting (1 Year)</li>
                                <li>Google Business Profile Setup</li>
                                <li>Google Analytics Integration</li>
                            </ul>
                            <div class="price">R8,000.00 ZAR</div>
                            <a href="#" class="order-btn">Order Now</a>
                        </div>

                        <div class="plan-card">
                            <h4>Business Package</h4>
                            <ul>
                                <li>1-15 Website Pages</li>
                                <li>Responsive Design (Mobile-Friendly)</li>
                                <li>SEO-Friendly Setup</li>
                                <li>FREE Business Emails</li>
                                <li>FREE Domain of your Choice (1 Year)</li>
                                <li>Dynamic Development (Interactive Features)</li>
                                <li>Business-Specific Features</li>
                                <li>Payment Gateway Integration</li>
                                <li>Customer Accounts & Login</li>
                                <li> Performance Optimization (Fast Loading Speed)</li>
                            </ul>
                            <div class="price">R15,000.00 ZAR</div>
                            <a href="#" class="order-btn">Order Now</a>
                        </div>
                    </div>
                </div>

                <!-- E-Commerce -->
                <div id="ecommerce" class="content-section">
                    <h2>E-Commerce Website</h2>
                    <p>We build secure and scalable e-commerce stores with integrated payment solutions.</p>
                </div>

                <!-- Social Media -->
                <div id="social_media" class="content-section">
                    <h2>Social Media Management</h2>
                    <p>Boost your brand with our professional social media management services.</p>
                </div>

                <!-- Branding -->
                <div id="branding" class="content-section">
                    <h2>Branding Design</h2>
                    <p>Create a strong identity with our branding and logo design services.</p>
                </div>

                <!-- Graphic Design -->
                <div id="graphic" class="content-section">
                    <h2>Graphic Design</h2>
                    <p>High-quality graphics for digital and print to elevate your brand presence.</p>
                </div>
            </div>
        </div>
        
    </section>

    <?php include '../Components/footer.php';?>
</body>
</html>
