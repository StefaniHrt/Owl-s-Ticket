<?php
include_once "connection.php";
session_start();

// Fetch seat data
$sql = "SELECT ID_kursi, nama_kursi, harga FROM kursi";
$result = $conn->query($sql);

$seatData = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $seatData[] = $row;
    }
} else {
    echo "0 results";
}
$conn->close();
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
        <select id="seatCategory" onchange="updatePrice()">
            <?php foreach ($seatData as $seat): ?>
                <option value="<?php echo $seat['harga']; ?>">
                    <?php echo $seat['nama_kursi']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <p id="price">Price: Rp. 0,- / pcs</p>
        <form action="payment.php" method="post">
            <h4>JUMLAH TIKET</h4>
            <input type="number" id="ticketQuantity" name="ticketQuantity" placeholder="Ex: 3" required class="number" min="1" oninput="updateBuyerDetails()">
            
            <h4>DETAIL PEMBELI</h4>
            <div class="inputan" id="buyerDetails">
                <!-- Buyer details input fields will be inserted here -->
            </div>
            <input type="hidden" id="totalPrice" name="totalPrice">
            <div class="submitcontainer">
                <button type="submit">Continue to Payment</button>
            </div>
        </form>
    </section>

    <footer>
        <span>2024 &copy Owl's Ticket, All rights reserved.</span>
    </footer>

    <script>
        function updatePrice() {
            const seatCategory = document.getElementById('seatCategory');
            const selectedOption = seatCategory.options[seatCategory.selectedIndex];
            const price = selectedOption.value;
            const priceElement = document.getElementById('price');
            priceElement.textContent = `Price: Rp. ${parseInt(price).toLocaleString('id-ID')},- / pcs`;
            
            const ticketQuantity = document.getElementById('ticketQuantity').value || 1;
            const totalPrice = price * ticketQuantity;
            document.getElementById('totalPrice').value = totalPrice;
        }

        function updateBuyerDetails() {
            const ticketQuantity = document.getElementById('ticketQuantity').value;
            const buyerDetailsContainer = document.getElementById('buyerDetails');
            
            // Clear existing input fields
            buyerDetailsContainer.innerHTML = '';

            // Create new input fields based on ticket quantity
            for (let i = 1; i <= ticketQuantity; i++) {
                const subheading = document.createElement('h5');
                subheading.textContent = `Data Pembeli ${i}`;
                buyerDetailsContainer.appendChild(subheading);

                const nameInput = document.createElement('input');
                nameInput.type = 'text';
                nameInput.placeholder = `Nama Lengkap Pembeli ${i}`;
                nameInput.required = true;
                nameInput.classList.add('buyer-input');

                const emailInput = document.createElement('input');
                emailInput.type = 'email';
                emailInput.placeholder = `Email Pembeli ${i} (name${i}.example@gmail.com)`;
                emailInput.required = true;
                emailInput.classList.add('buyer-input');

                const phoneInput = document.createElement('input');
                phoneInput.type = 'text';
                phoneInput.placeholder = `08xxxxxxxxxx`;
                phoneInput.required = true;
                phoneInput.classList.add('buyer-input');

                buyerDetailsContainer.appendChild(nameInput);
                buyerDetailsContainer.appendChild(emailInput);
                buyerDetailsContainer.appendChild(phoneInput);
            }
            updatePrice(); // Update the total price whenever the quantity changes
        }

        // Initial price update
        updatePrice();
    </script>
</body>
</html>
