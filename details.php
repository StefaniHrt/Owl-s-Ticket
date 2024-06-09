<?php
include 'connection.php';

$ID_konser = isset($_GET['ID_konser']) ? intval($_GET['ID_konser']) : 0;

$sql = "SELECT kon.nama_konser, kon.tanggal_awal, kon.tanggal_akhir, kon.waktu, kon.venue, kon.poster, kon.deskripsi, kon.syarat, kon.seating_plan, kur.nama_kursi, kur.tanggal, kur.harga, kur.stok
        FROM konser kon
        JOIN kursi kur ON kon.ID_konser = kur.ID_konser
        WHERE kon.ID_konser = ?
        ORDER BY kur.nama_kursi, kur.tanggal"; // Order by seat name and date for clarity

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ID_konser);
$stmt->execute();
$result = $stmt->get_result();

$concert = $result->num_rows > 0 ? $result->fetch_assoc() : null;

// Group seats by name and date
$grouped_seats = array();
while ($row = $result->fetch_assoc()) {
    $seat_name = $row["nama_kursi"];
    $date = $row["tanggal"];
    if (!isset($grouped_seats[$seat_name])) {
        $grouped_seats[$seat_name] = array();
    }
    if (!isset($grouped_seats[$seat_name][$date])) {
        $grouped_seats[$seat_name][$date] = array(
            "harga" => $row["harga"],
            "stok" => $row["stok"]
        );
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $concert ? htmlspecialchars($concert["nama_konser"]) : "Concert Details"; ?></title>
    <link rel="stylesheet" href="detail.css">
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
    <main>
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
        <?php
        if ($concert) {
            echo "<div class='poster'>";
            echo "<img src='img/" . htmlspecialchars($concert["poster"]) . "' alt='" . htmlspecialchars($concert["nama_konser"]) . "'>";
            echo "<div class='back_detail'>";
            echo "<h2>" . htmlspecialchars($concert["nama_konser"]) . "</h2>";
            echo "<hr>";
            echo "<div class='icon'>";
            echo "<p><img src='img/calendar.png' alt='calendar'>Tanggal: " . date("d F Y", strtotime($concert["tanggal_awal"]));
            if ($concert["tanggal_akhir"]) {
                echo " - " . date("d F Y", strtotime($concert["tanggal_akhir"]));
            }
            echo "</p>";
            echo "<p><img src='img/time.png' alt='time'>Waktu: " . date("H:i", strtotime($concert["waktu"])) . "</p>";
            echo "<p><img src='img/location.png' alt='location'>Lokasi: " . htmlspecialchars($concert["venue"]) . "</p>";
            echo "</div>";
            echo "</div>";
            echo "</div>";

            echo "<div class='back_desc'>";
            echo "<h2>Deskripsi</h2>";
            echo "<hr>";
            echo "<p>" . nl2br(htmlspecialchars($concert["deskripsi"])) . "</p>";
            echo "<br>";
            echo "<h2>Term & Condition</h2>";
            echo "<hr>";
            echo "<h3>Ketentuan Umum</h3>";
            echo "<ol>";
            $syarat_list = explode("\n", $concert["syarat"]);
            foreach ($syarat_list as $syarat) {
                echo "<li>" . htmlspecialchars(trim($syarat)) . "</li>";
            }
            echo "</ol>";
            echo "<h2>Seating Plan</h2>";
            echo "<hr>";
            echo "<div class='seat'>";
            echo "<img src='img/" . htmlspecialchars($concert["seating_plan"]) . "' alt='seating_plan'>";
            echo "<br>";

            // Form for selecting seats
            echo "<form id='bookingForm' action='pemesanan3.php' method='get'>";
            echo "<div class='seat'>";

            // Display grouped seats
            foreach ($grouped_seats as $seat_name => $dates) {
                echo "<div class='tiket'>";
                echo "<p>" . htmlspecialchars($seat_name) . " (Rp " . number_format($dates[key($dates)]["harga"]) . ")</p>"; // Price next to seat name
                echo "<hr>";
                foreach ($dates as $date => $seat_info) {
                    echo "<p>" . date("d F Y", strtotime($date)) . "</p>";
                    if ($seat_info["stok"] > 0) {
                        echo "<span id='availability-" . htmlspecialchars($seat_name) . "'>" . $seat_info["stok"] . " tickets left</span><br>";
                        echo "<input type='number' id='quantity' name='quantity[" . htmlspecialchars($seat_name) . "]' min='1' max='" . $seat_info["stok"] . "' value='1'>";
                        echo "<input type='hidden' name='ID_kursi' value='" . $seat_name . "'>"; // Send seat ID to pemesanan3.php
                        echo "<input type='submit' id='pesan' value='PESAN TIKET' onclick='return validateBooking(\"" . htmlspecialchars($seat_name) . "\", " . $seat_info["stok"] . ")'>";
                    } else {
                        echo "<span>sold out</span>";
                    }
                }
                echo "</div>";
            }

            echo "</div>";
            echo "</form>";

            echo "</div>";
        } else {
            echo "No concert found with the given ID.";
        }
        ?>
    </main>
    <footer>
        <span>2024 &copy Owl's Ticket, All rights reserved.</span>
    </footer>
    <script>
        function validateBooking(seatName, availableTickets) {
            var quantity = document.getElementById('quantity-' + seatName).value;
            if (quantity > availableTickets) {
                alert('The quantity exceeds the available tickets for ' + seatName);
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
