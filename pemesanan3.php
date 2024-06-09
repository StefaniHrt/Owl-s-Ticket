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
        <form action="payment.php" method="post">
            <h4>JUMLAH TIKET</h4>
            <p>Jumlah Tiket: <?php echo array_sum(array_column($seatData, 'quantity')); ?></p>
            <input type="hidden" id="ticketQuantity" name="ticketQuantity" value="<?php echo array_sum(array_column($seatData, 'quantity')); ?>" required>

            <h4>DETAIL PEMBELI</h4>
            <div class="inputan" id="buyerDetails">
                <!-- Buyer details input fields will be inserted here -->
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
            <div class="submitcontainer">
                <button type="submit">Continue to Payment</button>
            </div>
        </form>
    </section>

    <footer>
        <span>2024 &copy Owl's Ticket, All rights reserved.</span>
    </footer>
</body>
</html>
