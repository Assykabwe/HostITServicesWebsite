<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../CSS/user_style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="../JS_Script/user_script.js" defer></script>
    <title>Host IT Servicea - Home page</title>
</head>
<body>
    <?php include '../UserPages/User_Header.php';?>
    <!---- slider 1 section start ---->
    <section class="container">
        <div class="wrapper">
            <div class="slide">
                <img src="../Images/HomePage.webp">
                <div class="slide-text">
                    <h1>Host IT Services</h1>
                    <h2>Bringing you a variety of tech services</h2>
                    <div class="btn_1">
                        <a href="services.php" class="btn">Renew Domain</a>
                    </div>
                    <div class="btn_2">
                        <a href="support_ticket.php" class="btn">Create Ticket</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="services">
        <div class="heading">
            <h1>My Services</h1>
        </div>
    </section>
    <section class="support">
        <div class="heading">
            <h1>Support Ticket</h1>
        </div>
    </section>

    <?php include '../Components/footer.php';?>
</body>
</html>