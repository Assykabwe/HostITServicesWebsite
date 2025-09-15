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
    <title>Host IT Services - Home page</title>
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
                    <div class="btn-container">
                        <a href="services.php" class="btn">Renew Domain</a>
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
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Status</th>
                        <th>Billing</th>
                        <th>Date</th>
                        <th>Billing Cycle</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>example.com</td>
                        <td>Active</td>
                        <td>R5 000.00</td>
                        <td>06/15/2025</td>
                        <td>Annual</td>
                        <td><button class="renew-btn">Renew</button></td>
                    </tr>
                    <tr>
                        <td>Web Hosting</td>
                        <td class="expired">Expired</td>
                        <td>R42 040.00</td>
                        <td>09/20/2023</td>
                        <td>Annual</td>
                        <td><button class="renew-btn">Renew</button></td>
                    </tr>
                    <tr>
                        <td>Professional Website</td>
                        <td>Active</td>
                        <td>R8 000.00</td>
                        <td>12/20/2025</td>
                        <td>Monthly</td>
                        <td><button class="renew-btn">Renew</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="support">
        <div class="heading">
            <h1>Support Ticket</h1>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Priority</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Can not access email</td>
                        <td>High</td>
                        <td class="open">Open</td>
                    </tr>
                    <tr>
                        <td>How can renew my domain name</td>
                        <td>Medium</td>
                        <td class="closed">Closed</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="new-ticket">
            <a href="support_ticket.php" class="btn">New Ticket</a>
        </div>
    </section>
    <?php include '../Components/footer.php';?>
</body>
</html>