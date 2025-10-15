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
                        <li><a href="#" data-target="register_domain">Register a New Domain</a></li>
                        <li><a href="#" data-target="tansfer_domain">Transfer in a Domain</a></li>
                        <li><a href="#" data-target="view_cart">View Cart</a></li>
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
                            <div class="price">R2,500.00 ZAR</div>
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
                            <a href="#" class="order-btn">Order Now</a>
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
                                <li>Shipping Options• Order Tacking</li>
                                <li>WhatsApp Orders</li>
                            </ul>
                            <div class="price">R 15,000.00 ZAR</div>
                            <a href="#" class="order-btn">Order Now</a>
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
                            <div class="price">R 25,000.00 ZAR</div>
                            <a href="#" class="order-btn">Order Now</a>
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
                            <a href="#" class="order-btn">Order Now</a>
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
                            <a href="#" class="order-btn">Order Now</a>
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
                            <a href="#" class="order-btn">Order Now</a>
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
                            <a href="#" class="order-btn">Order Now</a>
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
                            <a href="#" class="order-btn">Order Now</a>
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
                            <a href="#" class="order-btn">Order Now</a>
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
                            <a href="#" class="order-btn">Order Now</a>
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
                            <a href="#" class="order-btn">Order Now</a>
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
                            <a href="#" class="order-btn">Order Now</a>
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
                            <a href="#" class="order-btn">Order Now</a>
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
                            <a href="#" class="order-btn">Order Now</a>
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
                            <a href="#" class="order-btn">Order Now</a>
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
                            <a href="#" class="order-btn">Order Now</a>
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
                            <a href="#" class="order-btn">Order Now</a>
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
                            <a href="#" class="order-btn">Order Now</a>
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
                            <a href="#" class="order-btn">Order Now</a>
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
                            <a href="#" class="order-btn">Order Now</a>
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
                            <a href="#" class="order-btn">Order Now</a>
                        </div>
                    </div>
                </div>
                <!--- Register a New Domain -->
                <div id="register_domain" class="content-section">
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
                </div>
                <!--- Transfer in a Domain -->
                <div id="tansfer_domain" class="content-section">
                    <h2>Transfer Your Domain</h2>
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
                </div>
                <!--- View Cart  -->
                <div id="view_cart" class="content-section">
                    <h2>Check & Order</h2>
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
                        <p>contibue shopping</p>
                    </div>
                </div>
            </div>
        </div>
        
    </section>

    <?php include '../Components/footer.php';?>
</body>
</html>
