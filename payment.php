<?php
session_start();
include_once "connection.php";

// Check if session data is set
if (!isset($_SESSION['seatData']) || !isset($_SESSION['totalPrice'])) {
    header('Location: pemesanan3.php');
    exit();
}

$seatData = $_SESSION['seatData'];
$totalPrice = $_SESSION['totalPrice'];

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['paymentMethod']) && isset($_FILES['paymentProof'])) {
        $paymentMethod = $_POST['paymentMethod'];
        $paymentProof = $_FILES['paymentProof'];

        // Validate file upload
        if ($paymentProof['error'] !== UPLOAD_ERR_OK) {
            echo "Error uploading file.";
            exit();
        }

        // Generate a unique file name and save the file
        $targetDir = "uploads/";
        $fileName = uniqid() . "_" . basename($paymentProof['name']);
        $targetFilePath = $targetDir . $fileName;

        if (!move_uploaded_file($paymentProof['tmp_name'], $targetFilePath)) {
            echo "Error saving the uploaded file.";
            exit();
        }

        // Assuming $ID_user and $ID_konser are obtained from the context or previous steps
        $ID_user = 1; // Replace with actual logic to retrieve or generate ID_user
        $ID_konser = 1; // Replace with actual logic to retrieve or generate ID_konser

        // Begin transaction
        $conn->begin_transaction();

        try {
            // Insert into `pemesanan` table
            $stmt = $conn->prepare("INSERT INTO pemesanan (ID_user, ID_konser, ID_kursi, total_pembayaran, jenis_pembayaran, bukti_pembayaran) VALUES (?, ?, ?, ?, ?, ?)");
            if (!$stmt) {
                throw new Exception("Preparation failed: " . $conn->error);
            }

            // For the sake of simplicity, assume the ID_kursi is taken from the first seat data
            $ID_kursi = reset($seatData)['ID_kursi'];

            $stmt->bind_param("iiiiss", $ID_user, $ID_konser, $ID_kursi, $totalPrice, $paymentMethod, $fileName);
            $stmt->execute();
            $ID_pemesanan = $stmt->insert_id;

            // Insert each ticket into the `tiket` table
            $stmt = $conn->prepare("INSERT INTO tiket (ID_pemesanan, nama_lengkap, email, no_telp) VALUES (?, ?, ?, ?)");
            if (!$stmt) {
                throw new Exception("Preparation failed: " . $conn->error);
            }

            // Loop through buyer details and insert each ticket
            if (isset($_POST['buyerName']) && isset($_POST['buyerEmail']) && isset($_POST['buyerPhone'])) {
                $buyerNames = $_POST['buyerName'];
                $buyerEmails = $_POST['buyerEmail'];
                $buyerPhones = $_POST['buyerPhone'];

                $index = 0;
                foreach ($seatData as $seatID => $data) {
                    for ($i = 0; $i < $data['quantity']; $i++) {
                        $buyerName = $buyerNames[$index];
                        $buyerEmail = $buyerEmails[$index];
                        $buyerPhone = $buyerPhones[$index];

                        // Validate non-null values
                        if (!empty($buyerName) && !empty($buyerEmail) && !empty($buyerPhone)) {
                            $stmt->bind_param("isss", $ID_pemesanan, $buyerName, $buyerEmail, $buyerPhone);
                            $stmt->execute();
                        } else {
                            throw new Exception("Buyer details cannot be null.");
                        }
                        $index++;
                    }
                }
            } else {
                throw new Exception("Buyer details are not set.");
            }

            // Commit transaction
            $conn->commit();

            echo "Tickets successfully booked!";
            // Optionally, redirect to a success or confirmation page
            header('Location: confirmation.php');
            exit();

        } catch (Exception $e) {
            // Rollback transaction if something failed
            $conn->rollback();
            echo "Failed to book tickets: " . $e->getMessage();
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Payment method or payment proof not provided.";
    }
}
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
    <form action="payment.php" method="post" enctype="multipart/form-data">
        <h4>TOTAL HARGA</h4>
        <p id="totalPrice">Rp. <?php echo number_format($totalPrice, 0, ',', '.'); ?>,-</p>
        
        <h4>PAYMENT METHOD</h4>
        <select id="paymentMethod" name="paymentMethod" onchange="updatePaymentMethod()">
            <option value="Virtual Account">Virtual Account</option>
            <option value="Gopay">GoPay</option>
            <option value="OVO">OVO</option>
            <option value="Dana">Dana</option>
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
        if (paymentMethod === 'Virtual Account') {
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
