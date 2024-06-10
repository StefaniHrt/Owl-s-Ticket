<?php
session_start();

// Retrieve seat data and total price from session
$seatData = isset($_SESSION['seatData']) ? $_SESSION['seatData'] : [];
$totalPrice = isset($_SESSION['totalPrice']) ? $_SESSION['totalPrice'] : 0;

if (empty($seatData)) {
    echo "No seat data available.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owl's Ticket - Confirmation</title>
    <link rel="stylesheet" href="confirmation.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* HEADER */
        header {
            background-color: rgb(89, 62, 168);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        header img {
            height: 50px;
            margin-left: 1.5%;
        }

        nav ul {
            list-style: none;
            display: flex;
        }

        nav ul li {
            margin-right: 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
        }

        nav ul li a:hover {
            color: cyan;
        }

        /* BACK BUTTON */
        .backbutton {
            display: inline-block;
            margin-left: 25%;
        }

        .backbutton img {
            width: 17%;
            background-color: rgba(83.1, 67.8, 98.8, 0.5);
            border-radius: 50%;
            transition: transform 0.3s;
        }

        .backbutton img:hover {
            transform: scale(1.1);
            background-color: #eee;
        }

        /* BODY */
        body {
            font-family: Arial, sans-serif;
            background-image: url(img/bg_main.jpg);
            background-attachment: fixed;
            background-size: cover;
            width: 100%;
        }

        h1 {
            font-size: 30px;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            margin: 1% auto;
            color: #D4ADFC;
        }


        .confirmation {
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            margin: 25px auto;
            text-align: center;
        }

        .confirmation h1, .confirmation p {
            margin-bottom: 20px;
            color: #5C3FA4;
        }

        .ticket-details {
            margin: 20px auto;
            text-align: left;
            width: 100%;
            border-collapse: collapse;
        }

        .ticket-details th, .ticket-details td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .ticket-details th {
            background-color: #f2f2f2;
            color: #5C3FA4;
        }

        .ticket-details td {
            text-align: center;
        }

    </style>
</head>
<body>
    <header>
        <img src="img/owlsticketlogo.png" alt="logo owl's ticket">
        <nav>
            <ul>
                <li><a href="main_page.html">Main Page</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">FAQ</a></li>
            </ul>
        </nav>
    </header>
    
    <div class="confirmation">
        <h1>Thank you for your purchase!</h1>
        <p>Your tickets have been successfully booked. Here are the details:</p>

        <table class="ticket-details">
            <tr>
                <th>Seat Category</th>
                <th>Price per Ticket</th>
                <th>Quantity</th>
                <th>Total Price</th>
            </tr>
            <?php foreach ($seatData as $seatID => $data): ?>
                <tr>
                    <td><?php echo htmlspecialchars($data['nama_kursi']); ?></td>
                    <td>Rp. <?php echo number_format($data['harga'], 0, ',', '.'); ?>,-</td>
                    <td><?php echo $data['quantity']; ?></td>
                    <td>Rp. <?php echo number_format($data['harga'] * $data['quantity'], 0, ',', '.'); ?>,-</td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <th colspan="3">Total Price</th>
                <th>Rp. <?php echo number_format($totalPrice, 0, ',', '.'); ?>,-</th>
            </tr>
        </table>

        <p>We will send you an email with the payment confirmation and your e-tickets.</p>
        <p>If you have any questions, feel free to contact our support team.</p>
    </div>


</body>
</html>
