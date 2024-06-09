<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['ticketQuantity'] = $_POST['ticketQuantity'];
    $_SESSION['totalPrice'] = $_POST['totalPrice'];
    header('Location: payment.php');
    exit();
}

if (!isset($_SESSION['ticketQuantity']) || !isset($_SESSION['totalPrice'])) {
    header('Location: pemesanan3.php');
    exit();
}

$ticketQuantity = $_SESSION['ticketQuantity'];
$totalPrice = $_SESSION['totalPrice'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owl's Ticket - Pembayaran</title>
    <link rel="stylesheet" href="pemesanan.css">
    <style>
        .inputan input {
            margin-bottom: 10px;
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
    
    <h1>HOW TO ORDER: </h1>
    <div class="steps">
        <div class="step">
            <img src="img/step_01.png" width="150px" height="150px">
            <p>1. Find the Concert</p>
        </div>
        <div class="step">
            <img src="img/step_02.png" width="150px" height="150px">
            <p>2. Read the Details</p>
        </div>
        <div class="step">
            <img src="img/step_03.png" width="150px" height="150px">
            <p>3. Fill the Form</p>
        </div>
        <div class="step">
            <img src="img/step_04.png" width="150px" height="150px">
            <p>4. Pay the Ticket</p>
        </div>
    </div>
    
    <a href="detail_iu.html" class="backbutton">
        <img src="img/back.png" alt="backbutton">
    </a>
    
    <section class="booking">
        <h2>PAYMENT FORM</h2>
        <form action="complete_payment.php" method="post" enctype="multipart/form-data">
            <h4>TOTAL HARGA</h4>
            <p id="totalPrice">Rp. <?php echo number_format($totalPrice, 0, ',', '.'); ?>,-</p>
            
            <h4>PAYMENT METHOD</h4>
            <select id="paymentMethod" name="paymentMethod" onchange="updatePaymentMethod()">
                <option value="virtual_account">Virtual Account</option>
                <option value="gopay">GoPay</option>
                <option value="ovo">OVO</option>
                <option value="dana">Dana</option>
            </select>
            
            <p id="virtualAccount">Virtual Account: 1229876548</p>

            <h4>Upload Bukti Pembayaran</h4>
            <input type="file" name="paymentProof" accept="image/*" required>

            <div class="submitcontainer">
                <button type="submit">Submit Payment</button>
            </div>
        </form>
    </section>

    <footer>
        <span>2024 &copy Owl's Ticket, All rights reserved.</span>
    </footer>

    <script>
        function updatePaymentMethod() {
            const paymentMethod = document.getElementById('paymentMethod').value;
            const virtualAccountElement = document.getElementById('virtualAccount');
            if (paymentMethod === 'virtual_account') {
                virtualAccountElement.textContent = 'Virtual Account: 1229876548';
            } else {
                virtualAccountElement.textContent = 'Virtual Account: 1229876550';
            }
        }

        // Initial update for payment method
        updatePaymentMethod();
    </script>
</body>
</html>
