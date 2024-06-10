<?php
include_once "connection.php";
session_start();

$seatQuantities = $_GET['quantity'];
$seatIDs = $_GET['ID_kursi'];
$seatNames = $_GET['seat_name'];

// Ensure all required data is available
if (empty($seatQuantities) || empty($seatIDs) || empty($seatNames)) {
    echo "No seat data found for the given ID.";
    exit();
}

$seatData = [];
$totalPrice = 0;

// Fetch seat details from the database and calculate total price
foreach ($seatIDs as $index => $seatID) {
    $quantity = (int)$seatQuantities[$seatID];
    if ($quantity > 0) {
        $sql = "SELECT ID_kursi, nama_kursi, harga FROM kursi WHERE ID_kursi = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Preparation failed: " . $conn->error);
        }
        $stmt->bind_param("i", $seatID);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        if ($data) {
            $data['quantity'] = $quantity;
            $seatData[$seatID] = $data;
            $totalPrice += $data['harga'] * $quantity;
        }
        $stmt->close();
    }
}

$conn->close();

// Store seat data and total price in session
$_SESSION['seatData'] = $seatData;
$_SESSION['totalPrice'] = $totalPrice;

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

        // Assuming $ID_pemesanan is obtained from the context or previous steps
        $ID_pemesanan = 1; // Replace with actual logic to retrieve or generate ID_pemesanan

        // Begin transaction
        $conn->begin_transaction();

        try {
            // Insert each ticket into the `tiket` table
            $stmt = $conn->prepare("INSERT INTO tiket (ID_pemesanan, nama_lengkap, email, no_telp) VALUES (?, ?, ?, ?)");
            if (!$stmt) {
                throw new Exception("Preparation failed: " . $conn->error);
            }

            // Loop through buyer details and insert each ticket
            $buyerNames = $_POST['buyerName'];
            $buyerEmails = $_POST['buyerEmail'];
            $buyerPhones = $_POST['buyerPhone'];

            $index = 0;
            foreach ($seatData as $seatID => $data) {
                for ($i = 0; $i < $data['quantity']; $i++) {
                    $buyerName = $buyerNames[$index];
                    $buyerEmail = $buyerEmails[$index];
                    $buyerPhone = $buyerPhones[$index];

                    $stmt->bind_param("isss", $ID_pemesanan, $buyerName, $buyerEmail, $buyerPhone);
                    $stmt->execute();
                    $index++;
                }
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
    <title>Owl's Ticket - Pemesanan</title>
    <link rel="stylesheet" href="pemesanan.css">
    <style>
        .inputan input, .inputan h5 {
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
        <h2>BOOKING FORM</h2>
        <?php foreach ($seatData as $seatID => $data): ?>
            <p>Seat Category: <?php echo htmlspecialchars($data['nama_kursi']); ?> - Price: Rp. <?php echo number_format($data['harga'], 0, ',', '.'); ?>,- Quantity: <?php echo $data['quantity']; ?></p>
        <?php endforeach; ?>
        <form id="bookingForm" action="payment.php" method="post" enctype="multipart/form-data">
            <h4>JUMLAH TIKET</h4>
            <p>Jumlah Tiket: <?php echo array_sum(array_column($seatData, 'quantity')); ?></p>
            <input type="hidden" id="ticketQuantity" name="ticketQuantity" value="<?php echo array_sum(array_column($seatData, 'quantity')); ?>" required>

            <h4>DETAIL PEMBELI</h4>
            <div class="inputan" id="buyerDetails">
                <?php $index = 0; ?>
                <?php foreach ($seatData as $seatID => $data): ?>
                    <?php for ($i = 0; $i < $data['quantity']; $i++): ?>
                        <h5>Data Pembeli <?php echo ++$index; ?> (Seat: <?php echo htmlspecialchars($data['nama_kursi']); ?>)</h5>
                        <input type="text" name="buyerName[]" placeholder="Nama Lengkap Pembeli <?php echo $index; ?>" required>
                        <input type="email" name="buyerEmail[]" placeholder="Email Pembeli <?php echo $index; ?>" required>
                        <input type="text" name="buyerPhone[]" placeholder="08xxxxxxxxxx" required>
                    <?php endfor; ?>
                <?php endforeach; ?>
            </div>
            <input type="hidden" id="totalPrice" name="totalPrice" value="<?php echo $totalPrice; ?>">

            <h4>TOTAL HARGA</h4>
            <p id="totalPrice">Rp. <?php echo number_format($totalPrice, 0, ',', '.'); ?>,-</p>
            
            <h4>PAYMENT METHOD</h4>
            <select id="paymentMethod" name="paymentMethod" onchange="updatePaymentMethod()">
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

        switch (paymentMethod) {
            case 'gopay':
                virtualAccountElement.textContent = 'Virtual Account: 310258234032';
                break;
            case 'ovo':
                virtualAccountElement.textContent = 'Virtual Account: 38058205325432';
                break;
            case 'dana':
                virtualAccountElement.textContent = 'Virtual Account: 8294032520532';
                break;
        }
    }

    // Initial update for payment method
    updatePaymentMethod();
</script>
</body>
</html>
