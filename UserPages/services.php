<?php
    include '../Includes/db_connection.php'; // keep this to have $conn ready
    if (session_status() === PHP_SESSION_NONE) session_start();

    if (!empty($_SESSION['login_success'])) {
        $msg = $_SESSION['login_success'];
        unset($_SESSION['login_success']);
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                swal('Login Successful', '$msg', 'success');
            });
        </script>";
    }

?>

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
        <script src="../JavaScript/register.js" defer></script>
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
                            <li><a href="#" data-target="register_domain">Register a New Domain</a></li>
                            <li><a href="#" data-target="transfer_domain">Transfer in a Domain</a></li>
                            <li><a href="#" data-target="view_cart">View Cart / Checkout</a></li>
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
                                <a href="#" class="order-btn" data-service-id="1"data-service-name="Web Hosting" >Order Now</a>
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
                                <a href="#" class="order-btn" data-service-id="2" data-service-name="Web Hosting">Order Now</a>
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
                                <a href="#" class="order-btn" data-service-id="3"data-service-name="Web Hosting" >Order Now</a>
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
                                <a href="#" class="order-btn" data-service-id="4" data-service-name="Web Hosting">Order Now</a>
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
                                <div class="price">R2,500.00 ZAR</div>
                                <a href="#" class="order-btn" data-service-id="5" data-service-name="Website Design">Order Now</a>
                            </div>

                            <div class="plan-card">
                                <h4>Basic Website</h4>
                                <ul>
                                    <li>1-3 Website Pages</li>
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
                                <a href="#" class="order-btn" data-service-id="6" data-service-name="Website Design">Order Now</a>
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
                                <a href="#" class="order-btn" data-service-id="7" data-service-name="Website Design">Order Now</a>
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
                                    <li>Performance Optimization (Fast Loading Speed)</li>
                                </ul>
                                <div class="price">R15,000.00 ZAR</div>
                                <a href="#" class="order-btn" data-service-id="8" data-service-name="Website Design">Order Now</a>
                            </div>
                        </div>
                    </div>

                    <!-- E-Commerce -->
                    <div id="ecommerce" class="content-section">
                        <h2>E-Commerce Website</h2>
                        <div class="plans">
                            <div class="plan-card">
                                <h4>Basic E-Commerce Website</h4>
                                <ul>
                                    <li>Up to 20 Products</li>
                                    <li>Responsive Design and Mobile-friendly</li>
                                    <li>SEO-Friendly Setup</li>
                                    <li>FREE Business Emails</li>
                                    <li>FREE .co.za Domain</li>
                                    <li>FREE .com Domain</li>
                                    <li>FREE SSL Certificate</li>
                                    <li>Product Categories & Filters</li>
                                    <li>Basic Shopping Cart</li>
                                    <li>Payment Gateway Integration</li>
                                    <li>Website Support</li>
                                </ul>
                                <div class="price">R8,500.00 ZAR</div>
                                <a href="#" class="order-btn" data-service-id="9"data-service-name="E-Commerce Website" >Order Now</a>
                            </div>

                            <div class="plan-card">
                                <h4>Standard E-Commerce Website</h4>
                                <ul>
                                    <li>Up to 50 Products</li>
                                    <li>Responsive Design</li>
                                    <li>SEO-Friendly Setup</li>
                                    <li>FREE Business Emails</li>
                                    <li>FREE Domain of your choice (1 year)</li>
                                    <li>Product Search Functionality</li>
                                    <li>Advanced Shopping Cart</li>
                                    <li>Multiple Payment Options</li>
                                    <li>Shipping Options & Order Tracking</li>
                                    <li>WhatsApp Orders</li>
                                </ul>
                                <div class="price">R15,000.00 ZAR</div>
                                <a href="#" class="order-btn" data-service-id="10" data-service-name="E-Commerce Website">Order Now</a>
                            </div>

                            <div class="plan-card">
                                <h4>Professional E-Commerce Website</h4>
                                <ul>
                                    <li>Up to 200 Products</li>
                                    <li>Responsive Design</li>
                                    <li>SEO-Friendly Setup</li>
                                    <li>FREE Business Emails</li>
                                    <li>FREE Domain (1 year)</li>
                                    <li>Advanced Product Filters</li>
                                    <li>Multi-Currency Support</li>
                                    <li>Custom Checkout</li>
                                    <li>Product Variation</li>
                                    <li>Subscription Product</li>
                                    <li>Shipping Integration</li>
                                    <li>CRM Integration</li>
                                    <li>Wholesale Pricing Groups</li>
                                    <li>API Integration</li>
                                </ul>
                                <div class="price">R25,000.00 ZAR</div>
                                <a href="#" class="order-btn" data-service-id="11" data-service-name="E-Commerce Website">Order Now</a>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div id="social_media" class="content-section">
                        <h2>Social Media Management</h2>
                        <div class="plans">
                            <div class="plan-card">
                                <h4>Basic Social Media Management</h4>
                                <ul>
                                    <li>3 posts per week (1 platform)</li>
                                    <li>Basic content creation (graphics & captions)</li>
                                    <li>Hashtag research</li>
                                    <li>Monthly analytics report</li>
                                </ul>
                                <div class="price">R2,500.00 ZAR/ Monthly</div>
                                <a href="#" class="order-btn" data-service-id="12">Order Now</a>
                            </div>

                            <div class="plan-card">
                                <h4>Digital Essentials</h4>
                                <ul>
                                    <li>4 posts per week (2 platforms)</li>
                                    <li>Basic content calendar</li>
                                    <li>Hashtag & keyword optimization</li>
                                    <li>Community engagement (comments & DMs - limited)</li>
                                    <li>Monthly report</li>
                                </ul>
                                <div class="price">R4,700.00 ZAR/ Monthly</div>
                                <a href="#" class="order-btn" data-service-id="13">Order Now</a>
                            </div>

                            <div class="plan-card">
                                <h4>Startup Boost</h4>
                                <ul>
                                    <li>5 posts per week (2 platforms)</li>
                                    <li>Basic ad setup and monitoring</li>
                                    <li>Hashtag research and content optimization</li>
                                    <li>engagement management</li>
                                    <li>Monthly strategy call</li>
                                </ul>
                                <div class="price">R6,500.00 ZAR/ Monthly</div>
                                <a href="#" class="order-btn" data-service-id="14">Order Now</a>
                            </div>

                            <div class="plan-card">
                                <h4>Launch Pad</h4>
                                <ul>
                                    <li>5 posts per week (3 platforms)</li>
                                    <li>Video content (1 short-form video per week)</li>
                                    <li>Ad campaign setup (limited budget)</li>
                                    <li>Engagement & growth tracking</li>
                                    <li>Monthly performance call</li>
                                </ul>
                                <div class="price">R8,300.00 ZAR/ Monthly</div>
                                <a href="#" class="order-btn" data-service-id="15">Order Now</a>
                            </div>
                        </div>
                    </div>
                    <!-- Branding -->
                    <div id="branding" class="content-section">
                        <h2>Branding Design</h2>
                        <div class="plans">
                            <div class="plan-card">
                                <h4>Standard Branding Package</h4>
                                <ul>
                                    <li>A unique logo that represents your brand</li>
                                    <li>Custom Logo Design</li>
                                    <li>Professional design for your business cards</li>
                                    <li>Business Card Design</li>
                                    <li>Matching stationery for a polished look</li>
                                    <li>Letterhead & Envelope Design</li>
                                    <li>Profile and cover designs for Facebook, Instagram, and LinkedIn</li>
                                    <li>Social Media Kit</li>
                                    <li>We will fine-tune your designs to perfection</li>
                                    <li>3 Revisions</li>
                                    <li>Fast and reliable service</li>
                                    <li>Delivery in 5-7 Business Days</li>
                                </ul>
                                <div class="price">R4,500.00 ZAR</div>
                                <a href="#" class="order-btn" data-service-id="16">Order Now</a>
                            </div>

                            <div class="plan-card">
                                <h4>Comprehensive Branding Package</h4>
                                <ul>
                                    <li> A standout logo for your brand</li>
                                    <li>Custom Logo Design</li>
                                    <li>Define your brand’s colors, fonts, and tone of voice</li>
                                    <li>Brand Style Guide</li>
                                    <li>Professional and eye-catching design</li>
                                    <li>Business Card Design</li>
                                    <li>Cohesive stationery suite</li>
                                    <li>Letterhead, Envelope, & Email Signature Design</li>
                                    <li>Profile and cover designs for all major platforms</li>
                                    <li>Social Media Kit</li>
                                    <li>A 2-page design to showcase your services</li>
                                    <li> Brochure or Flyer Design</li>
                                    <li>We will work with you until you are 100% satisfied</li>
                                    <li>5 Revisions</li>
                                    <li>High-quality designs delivered on time</li>
                                    <li>Delivery in 7-10 Business Days</li>
                                </ul>
                                <div class="price">R8,000.00 ZAR</div>
                                <a href="#" class="order-btn" data-service-id="17">Order Now</a>
                            </div>

                            <div class="plan-card">
                                <h4>Professional Branding Package</h4>
                                <ul>
                                    <li>A unique and memorable logo (Custom Logo Design)</li>
                                    <li>Full guidelines for consistent branding </li>
                                    <li>Premium design for your business cards</li>
                                    <li>Business Card Design</li>
                                    <li>Complete stationery suite (Letterhead, Envelope, & Email Signature Design)</li>
                                    <li>Profile and cover designs for all platforms </li>
                                    <li>Media Kit</li>
                                    <li>Up to 6 pages of professional design</li>
                                    <li>Brochure Catalog Design</li>
                                    <li>Design for one product</li>
                                    <li>packaging (e.g., box or label)</li>
                                    <li>We will refine your designs until they are perfect</li>
                                    <li>Unlimited Revisions</li>
                                    <li>Comprehensive and detailed work</li>
                                    <li>in 10-14 Business Days</li>
                                </ul>
                                <div class="price">R15,000.00 ZAR</div>
                                <a href="#" class="order-btn" data-service-id="18">Order Now</a>
                            </div>

                            <div class="plan-card">
                                <h4>Brand Style Guide</h4>
                                <ul>
                                    <li> A comprehensive guide defining your brand’s colors, fonts, and tone of voice.</li>
                                    <li>3 revisions included</li>
                                    <li>Digital PDF file</li>
                                    <li>Delivery in 5-7 business days</li>
                                </ul>
                                <div class="price">R2,500.00 ZAR</div>
                                <a href="#" class="order-btn" data-service-id="19">Order Now</a>
                            </div>
                        </div>
                    </div>
                    <!-- Graphic Design -->
                    <div id="graphic" class="content-section">
                        <h2>Quality Graphic Designs and Branding Solutions</h2>
                        <div class="plans">
                            <div class="plan-card">
                                <h4>Logo Design</h4>
                                <ul>
                                    <li>Custom logo design tailored to your brand.</li>
                                    <li>2 revisions included</li>
                                    <li>Vector file formats (AI, EPS, PDF)</li>
                                    <li>Transparent background PNG</li>
                                    <li>Delivery in 3-5 business days</li>
                                </ul>
                                <div class="price">R500.00 ZAR</div>
                                <a href="#" class="order-btn" data-service-id="20">Order Now</a>
                            </div>

                            <div class="plan-card">
                                <h4>Business Card Design</h4>
                                <ul>
                                    <li>Professional business card design (front and back)</li>
                                    <li>2 revisions included</li>
                                    <li>Print-ready files (PDF, PNG)</li>
                                    <li>Delivery in 2-3 business days</li>
                                    <li>+R50 For Any additional Changes</li>
                                </ul>
                                <div class="price">R350.00 ZAR</div>
                                <a href="#" class="order-btn" data-service-id="21">Order Now</a>
                            </div>

                            <div class="plan-card">
                                <h4>Poster Design</h4>
                                <ul>
                                    <li>Custom poster design for events, promotions, or advertisements.</li>
                                    <li>2 revisions included</li>
                                    <li>Print-ready files (PDF, PNG)</li>
                                    <li>Delivery in 3-5 business days</li>
                                    <li> +R100 For Each additional poster</li>
                                </ul>
                                <div class="price">R350.00 ZAR</div>
                                <a href="#" class="order-btn" data-service-id="22">Order Now</a>
                            </div>

                            <div class="plan-card">
                                <h4>Flyer Design</h4>
                                <ul>
                                    <li>1-15 Website Pages</li>
                                    <li>Responsive Design (Mobile-Friendly)</li>
                                    <li>SEO-Friendly Setup</li>
                                    <li>FREE Business Emails</li>
                                    <li>FREE Domain of your Choice (1 Year)</li>
                                </ul>
                                <div class="price">R350.00 ZAR</div>
                                <a href="#" class="order-btn" data-service-id="23">Order Now</a>
                            </div>
                            <div class="plan-card">
                                <h4>Flyer Design</h4>
                                <ul>
                                    <li>Custom flyer design (single or double-sided)</li>
                                    <li>2 revisions included</li>
                                    <li>Print-ready files (PDF, PNG)</li>
                                    <li>Delivery in 3-5 business days</li>
                                    <li>+R100 For Each additional Flyer Design</li>
                                </ul>
                                <div class="price">R350.00 ZAR</div>
                                <a href="#" class="order-btn" data-service-id="24">Order Now</a>
                            </div>
                            <div class="plan-card">
                                <h4>Company Letter Head Design</h4>
                                <ul>
                                    <li>Professional letterhead and envelope design</li>
                                    <li>2 revisions included</li>
                                    <li>Print-ready files (PDF, PNG)</li>
                                    <li>Delivery in 3-5 business days</li>
                                </ul>
                                <div class="price">R500.00 ZAR</div>
                                <a href="#" class="order-btn" data-service-id="25">Order Now</a>
                            </div>
                            <div class="plan-card">
                                <h4>Social Media Kit Design</h4>
                                <ul>
                                    <li>Profile and cover designs for Facebook, Instagram, and LinkedIn</li>
                                    <li>3 revisions included</li>
                                    <li>High-resolution files (PNG, JPG)</li>
                                    <li>Delivery in 5-7 business days</li>
                                </ul>
                                <div class="price">R450.00 ZAR</div>
                                <a href="#" class="order-btn" data-service-id="26">Order Now</a>
                            </div>
                            <div class="plan-card">
                                <h4>Brochure Design</h4>
                                <ul>
                                    <li>Custom brochure design (up to 2 pages)</li>
                                    <li>3 revisions included</li>
                                    <li>Print-ready files (PDF)</li>
                                    <li>Delivery in 5-7 business days</li>
                                    <li>+R500 For Any additional Page</li>
                                </ul>
                                <div class="price">R2,000.00 ZAR</div>
                                <a href="#" class="order-btn" data-service-id="27">Order Now</a>
                            </div>
                            <div class="plan-card">
                                <h4>Packaging Design</h4>
                                <ul>
                                    <li>Custom design for one product packaging (e.g., box, label, or bag)</li>
                                    <li>3 revisions included</li>
                                    <li>Print-ready files (PDF, AI)</li>
                                    <li>Delivery in 7-10 business days</li>
                                </ul>
                                <div class="price">R3,000.00 ZAR</div>
                                <a href="#" class="order-btn" data-service-id="28">Order Now</a>
                            </div>
                            <div class="plan-card">
                                <h4>Email Signature Design</h4>
                                <ul>
                                    <li>Professional & Custom Email Signature Design</li>
                                    <li>Includes 1 Revision</li>
                                    <li>Delivered in Both HTML & Image Formats (for easy integration)</li>
                                    <li>1-2 Business Days</li>
                                </ul>
                                <div class="price">R300.00 ZAR</div>
                                <a href="#" class="order-btn" data-service-id="29">Order Now</a>
                            </div>
                        </div>
                    </div>
                    <!--- Register a New Domain -->
                    <div id="register_domain" class="content-section">
                        <div class="heading-row">
                            <h2>Register Domain</h2>
                            <h3 id="registerDomainServiceName">Starter Web Hosting</h3>
                        </div>
                        <p>Find your new domain name. Enter your name or keywords below to check availability.</p>

                        <form id="domainSearchForm" class="domain-search-form">
                            <input type="text" id="domainNameInput" placeholder="Find your new domain name" required />
                            <button type="submit" id="add-to-cart-after-domain" class="btn">Search</button>
                        </form>


                        <div class="domain-options">
                            <div class="domain-card">
                            <img src="../Images/com.png" alt=".com">
                            <p>R300.00/yr</p>
                            </div>
                            <div class="domain-cards">
                            <img src="../Images/net.png" alt=".net">
                            <p>R368.44/yr</p>
                            </div>
                        </div>
                        <p>Browse extensions by category</p>
                        <!-- Tabs -->
                        <ul class="domain-tabs">
                            <li class="active" data-tab="popular">Popular</li>
                            <li data-tab="business">Business</li>
                            <li data-tab="sports">Sports</li>
                            <li data-tab="education">Education</li>
                            <li data-tab="food">Food and Drink</li>
                            <li data-tab="technology">Technology</li>
                            <li data-tab="services">Services</li>
                            <li data-tab="others">Others</li>
                        </ul>
                        <!-- Tab Content -->
                        <div class="domain-tables-container">
                            <!-- Example table structure -->
                            <div class="domain-table active" id="popular">
                                <table>
                                    <tr><th>Domain</th><th>Price</th><th>Select</th></tr>
                                    <tr><td>.com</td><td>R150.00</td><td><input type="radio" name="domain_option" value=".com" data-price="150" data-category="Popular"></td></tr>
                                    <tr><td>.net</td><td>R130.00</td><td><input type="radio" name="domain_option" value=".net" data-price="130" data-category="Popular"></td></tr>
                                    <tr><td>.org</td><td>R120.00</td><td><input type="radio" name="domain_option" value=".org" data-price="120" data-category="Popular"></td></tr>
                                    <tr><td>.co.za</td><td>R100.00</td><td><input type="radio" name="domain_option" value=".co.za" data-price="100" data-category="Popular"></td></tr>
                                    <tr><td>.info</td><td>R90.00</td><td><input type="radio" name="domain_option" value=".info" data-price="90" data-category="Popular"></td></tr>
                                </table>
                            </div>
                            <!-- Example for another category -->
                            <div class="domain-table" id="business">
                                <table>
                                    <tr><th>Domain</th><th>Price</th><th>Select</th></tr>
                                    <tr><td>.biz</td><td>R160.00</td><td><input type="radio" name="domain_option" value=".biz" data-price="160" data-category="Business"></td></tr>
                                    <tr><td>.co</td><td>R180.00</td><td><input type="radio" name="domain_option" value=".co" data-price="180" data-category="Business"></td></tr>
                                    <tr><td>.company</td><td>R200.00</td><td><input type="radio" name="domain_option" value=".company" data-price="200" data-category="Business"></td></tr>
                                    <tr><td>.group</td><td>R170.00</td><td><input type="radio" name="domain_option" value=".group" data-price="170" data-category="Business"></td></tr>
                                    <tr><td>.consulting</td><td>R190.00</td><td><input type="radio" name="domain_option" value=".consulting" data-price="190" data-category="Business"></td></tr>
                                </table>
                            </div>
                            <!-- Sports -->
                            <div class="domain-table" id="sports">
                            <table>
                                <tr><th>Domain</th><th>Price</th><th>Select</th></tr>
                                <tr><td>.sports</td><td>R210.00</td><td><input type="radio" name="domain_option" value=".sports" data-price="210" data-category="Sports"></td></tr>
                                <tr><td>.fitness</td><td>R195.00</td><td><input type="radio" name="domain_option" value=".fitness" data-price="195" data-category="Sports"></td></tr>
                                <tr><td>.football</td><td>R220.00</td><td><input type="radio" name="domain_option" value=".football" data-price="220" data-category="Sports"></td></tr>
                                <tr><td>.team</td><td>R180.00</td><td><input type="radio" name="domain_option" value=".team" data-price="180" data-category="Sports"></td></tr>
                                <tr><td>.coach</td><td>R190.00</td><td><input type="radio" name="domain_option" value=".coach" data-price="190" data-category="Sports"></td></tr>
                            </table>
                            </div>
                            <!-- Education -->
                            <div class="domain-table" id="education">
                            <table>
                                <tr><th>Domain</th><th>Price</th><th>Select</th></tr>
                                <tr><td>.academy</td><td>R160.00</td><td><input type="radio" name="domain_option" value=".academy" data-price="160" data-category="Education"></td></tr>
                                <tr><td>.school</td><td>R150.00</td><td><input type="radio" name="domain_option" value=".school" data-price="150" data-category="Education"></td></tr>
                                <tr><td>.college</td><td>R180.00</td><td><input type="radio" name="domain_option" value=".college" data-price="180" data-category="Education"></td></tr>
                                <tr><td>.university</td><td>R200.00</td><td><input type="radio" name="domain_option" value=".university" data-price="200" data-category="Education"></td></tr>
                                <tr><td>.training</td><td>R170.00</td><td><input type="radio" name="domain_option" value=".training" data-price="170" data-category="Education"></td></tr>
                            </table>
                            </div>
                            <!-- Food and Drink -->
                            <div class="domain-table" id="food">
                            <table>
                                <tr><th>Domain</th><th>Price</th><th>Select</th></tr>
                                <tr><td>.food</td><td>R200.00</td><td><input type="radio" name="domain_option" value=".food" data-price="200" data-category="Food and Drink"></td></tr>
                                <tr><td>.restaurant</td><td>R190.00</td><td><input type="radio" name="domain_option" value=".restaurant" data-price="190" data-category="Food and Drink"></td></tr>
                                <tr><td>.cafe</td><td>R160.00</td><td><input type="radio" name="domain_option" value=".cafe" data-price="160" data-category="Food and Drink"></td></tr>
                                <tr><td>.bar</td><td>R170.00</td><td><input type="radio" name="domain_option" value=".bar" data-price="170" data-category="Food and Drink"></td></tr>
                                <tr><td>.drink</td><td>R180.00</td><td><input type="radio" name="domain_option" value=".drink" data-price="180" data-category="Food and Drink"></td></tr>
                            </table>
                            </div>
                            <!-- Technology -->
                            <div class="domain-table" id="technology">
                            <table>
                                <tr><th>Domain</th><th>Price</th><th>Select</th></tr>
                                <tr><td>.tech</td><td>R190.00</td><td><input type="radio" name="domain_option" value=".tech" data-price="190" data-category="Technology"></td></tr>
                                <tr><td>.io</td><td>R250.00</td><td><input type="radio" name="domain_option" value=".io" data-price="250" data-category="Technology"></td></tr>
                                <tr><td>.app</td><td>R230.00</td><td><input type="radio" name="domain_option" value=".app" data-price="230" data-category="Technology"></td></tr>
                                <tr><td>.cloud</td><td>R210.00</td><td><input type="radio" name="domain_option" value=".cloud" data-price="210" data-category="Technology"></td></tr>
                                <tr><td>.dev</td><td>R200.00</td><td><input type="radio" name="domain_option" value=".dev" data-price="200" data-category="Technology"></td></tr>
                            </table>
                            </div>
                            <!-- Services -->
                            <div class="domain-table" id="services">
                            <table>
                                <tr><th>Domain</th><th>Price</th><th>Select</th></tr>
                                <tr><td>.services</td><td>R180.00</td><td><input type="radio" name="domain_option" value=".services" data-price="180" data-category="Services"></td></tr>
                                <tr><td>.repair</td><td>R170.00</td><td><input type="radio" name="domain_option" value=".repair" data-price="170" data-category="Services"></td></tr>
                                <tr><td>.support</td><td>R160.00</td><td><input type="radio" name="domain_option" value=".support" data-price="160" data-category="Services"></td></tr>
                                <tr><td>.solutions</td><td>R190.00</td><td><input type="radio" name="domain_option" value=".solutions" data-price="190" data-category="Services"></td></tr>
                                <tr><td>.consulting</td><td>R200.00</td><td><input type="radio" name="domain_option" value=".consulting" data-price="200" data-category="Services"></td></tr>
                            </table>
                            </div>
                            <!-- Others -->
                            <div class="domain-table" id="others">
                            <table>
                                <tr><th>Domain</th><th>Price</th><th>Select</th></tr>
                                <tr><td>.store</td><td>R190.00</td><td><input type="radio" name="domain_option" value=".store" data-price="190" data-category="Others"></td></tr>
                                <tr><td>.fun</td><td>R170.00</td><td><input type="radio" name="domain_option" value=".fun" data-price="170" data-category="Others"></td></tr>
                                <tr><td>.xyz</td><td>R150.00</td><td><input type="radio" name="domain_option" value=".xyz" data-price="150" data-category="Others"></td></tr>
                                <tr><td>.online</td><td>R180.00</td><td><input type="radio" name="domain_option" value=".online" data-price="180" data-category="Others"></td></tr>
                                <tr><td>.world</td><td>R160.00</td><td><input type="radio" name="domain_option" value=".world" data-price="160" data-category="Others"></td></tr>
                            </table>
                            </div>
                        </div>
                        <button id="continueDomainBtn" class="btn">Continue</button>

                        <div class="promo-section">
                            <div class="promo-box">
                                <h4>Add Web Hosting</h4>
                                <p>You can add web hosting to your domain purchase by selecting a hosting package.</p>
                                <a href="services.php" class="btns">Explore Packages Now</a>
                            </div>
                            <div class="promo-box">
                                <h4>Transfer your domain to us</h4>
                                <p>Transfer your domain to us and extend your domain by 1 year.</p>
                                <a href="#transfer_domain" data-target="transfer_domain" class="btn" id="transferDomainLink">Transfer a Domain</a>
                            </div>
                        </div>
                    </div>
                    <!--- Transfer in a Domain -->
                    <div id="transfer_domain" class="content-section">
                        <h2>Transfer Your Domain</h2>
                        <p>Transfer now to extend your domain by 1 year!*</p>

                        <form id="transferDomainForm">
                            <div class="form-group">
                                <label for="domain">Domain Name</label>
                                <input type="text" id="domain" name="domain_name" placeholder="example.com" required />
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
                    </div>

                    <!--- View Cart  -->
                    <div id= "view_cart"  class="content-section">
                        <h2>Review & Checkout</h2>
                        <div class="cart-content-wrapper">
                            <div class="cart-details">
                                <div class="product-table-header">
                                    <div class="header-item product-col">Product/Options</div>
                                    <div class="header-item price-col">Price/Cycle</div>
                                </div>
                                <!-- This is where JS will render cart items -->
                                <div id="cart-items" class="cart-content"></div>
                                <div class="empty-cart-message">Your Shopping Cart is Empty</div>

                                <hr class="cart-divider">
                            </div>

                            <div class="order-summary">
                                <h3>Order Summary</h3>
                                <div class="summary-line">
                                    <span>SubTotal</span>
                                    <span class="price">R0.00 ZAR</span>
                                </div>
                                <hr>
                                <div class="summary-line totals-line">
                                    <span>Totals</span>
                                    <span class="price">R0.00 ZAR</span>
                                </div>
                                <div class="due-today-line">
                                    Total Due Today
                                </div>
                                <a href="#" class="checkout-btn" id="checkout-btn" disabled>
                                    Checkout <i class='bx bx-right-arrow-alt'></i>
                                </a>
                                <div class="continue-shopping">
                                    <a href="#web_hosting">Continue shopping</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--- checkout  ---->
                    <div id="checkout" class="content-section">
                        <h2>Checkout</h2>
                        <!-- Toggle Buttons -->
                        <div class="account-toggle-buttons">
                            <button id="create-account-btn" class="btn">Create New Account</button>
                            <button id="already-registered-btn" class="btn">Already Registered?</button>
                        </div>

                        <!-- Full Registration Form -->
                        <div id="full-account-form" style="display:none;">
                            <h3>Create Your Account</h3>
                            <form id="registration-form" method="POST">
                                <div class="form-row">
                                    <input type="text" name="full_name" placeholder="Full Name" required>
                                    <input type="email" name="email" placeholder="Email Address" required>
                                    <input type="password" name="password" placeholder="Enter Password" required>
                                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                                </div>
                                <button type="submit" name="register" class="btn">Register</button>
                            </form>
                        </div>

                        <!-- Existing Customer Login -->
                        <div class="customer-login-section" id="existing-login-section" style="display:none;">
                            <h3>Existing Customer Login</h3>
                            <form id="existing-customer-login-form" method="POST">
                                <div class="form-row">
                                    <input type="email" name="login_email" placeholder="Email Address" required>
                                    <input type="password" name="login_password" placeholder="Password" required>
                                </div>
                                <button type="submit" name="login" class="btn">Login</button>
                            </form>
                        </div>

                        <hr class="separator">

                        <div class="payment-details-section">
                            <h3>Payment Details</h3>
                            
                            <div class="total-due-box">
                                Total Due Today: <strong id="total-due">R0.00</strong>
                            </div>
                        </div>
                        
                        <div class="additional-notes-section">
                            <h3>Additional Notes</h3>
                            <textarea id="additional-notes" rows="4" placeholder="You can enter any additional notes or information you want included with your order here..."></textarea>
                        </div>
                        
                        <!-- Mailing List -->
                        <div class="mailing-list-section">
                            <h3>Join our mailing list</h3>
                            <p>We would like to send you occasional news, information and special offers by email. Choose below whether you want to join our mailing list. You can unsubscribe at any time.</p>
                            <div class="mailing-list-toggle">
                                <label><input type="radio" name="mailing_list" value="yes"> Yes</label>
                                <label><input type="radio" name="mailing_list" value="no" checked> No</label>
                            </div>
                            <input type="hidden" id="user_email" value="<?php echo $_SESSION['User_Email'] ?? ''; ?>">
                        </div>

                        <form id="complete-order-form" method="POST">
                            <h3 class="payment-instruction">Please choose your preferred method of payment.</h3>

                            <div class="payment-options">
                                <label class="radio-label">
                                    <input type="radio" name="payment-method" value="bank-transfer" checked>
                                    Bank Transfer
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="payment-method" value="mail-in">
                                    Mail In Payment
                                </label>
                            </div>
                            <!-- Payment Details Popup -->
                            <div id="payment-popup" style="display:none;">
                                <div class="popup-content">
                                    <span id="close-popup">&times;</span>
                                    <h3>Payment Instructions</h3>
                                    <div id="payment-info"></div>
                                </div>
                            </div>
                            <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['User_ID'] ?? ''; ?>">
                            <input type="hidden" name="payment_method" id="selected-payment-method">
                            <input type="hidden" name="notes" id="order-notes">
                            <div class="complete-order-container">
                                <button type="submit" class="btn">
                                    Complete Order <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <?php include '../Components/footer.php';?>
        <script>
            document.getElementById("complete-order-form").addEventListener("submit", function(e) {
                e.preventDefault();
                
                const paymentMethod = document.querySelector('input[name="payment-method"]:checked').value;
                const amount = <?php echo isset($_SESSION['total_amount']) ? $_SESSION['total_amount'] : 250; ?>;
                const userId = document.getElementById('user_id').value;

                if (paymentMethod === "payfast") {
                    // Redirect to PayFast payment gateway
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'https://www.payfast.co.za/eng/process'; // Use sandbox for testing

                    // Required fields
                    const fields = {
                        merchant_id: '10043531',
                        merchant_key: '1teaoaq62c0db',
                        return_url: 'https://yourdomain.com/payment_success.php',
                        cancel_url: 'https://yourdomain.com/payment_cancelled.php',
                        notify_url: 'https://yourdomain.com/payfast_notify.php',
                        amount: amount.toFixed(2),
                        item_name: 'Service Purchase',
                        email_address: '<?php echo $_SESSION['User_Email'] ?? "test@example.com"; ?>',
                        custom_str1: userId
                    };

                    for (const key in fields) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = key;
                        input.value = fields[key];
                        form.appendChild(input);
                    }

                    document.body.appendChild(form);
                    form.submit();
                } else {
                    alert("Processing payment method: " + paymentMethod);
                    // Handle your other methods normally
                }
            });
        </script>

    </body>
</html>
