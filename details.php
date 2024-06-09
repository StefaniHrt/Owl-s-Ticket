<?php
include 'connection.php';

$ID_konser = isset($_GET['ID_konser']) ? intval($_GET['ID_konser']) : 0;

$sql = "SELECT kon.nama_konser, kon.tanggal_awal, kon.tanggal_akhir, kon.waktu, kon.venue, kon.poster, kon.deskripsi, kon.syarat, kon.seating_plan, kur.ID_kursi, kur.nama_kursi, kur.tanggal, kur.harga, kur.stok
        FROM konser kon
        JOIN kursi kur ON kon.ID_konser = kur.ID_konser
        WHERE kon.ID_konser = ?
        ORDER BY kur.nama_kursi, kur.tanggal";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ID_konser);
$stmt->execute();
$result = $stmt->get_result();

$concert = $result->num_rows > 0 ? $result->fetch_assoc() : null;

// Group seats by name and date
$grouped_seats = array();
while ($row = $result->fetch_assoc()) {
    $seat_name = $row["nama_kursi"];
    $seat_id = $row["ID_kursi"];
    $date = $row["tanggal"];
    if (!isset($grouped_seats[$seat_name])) {
        $grouped_seats[$seat_name] = array();
    }
    if (!isset($grouped_seats[$seat_name][$date])) {
        $grouped_seats[$seat_name][$date] = array(
            "harga" => $row["harga"],
            "stok" => $row["stok"],
            "ID_kursi" => $seat_id // Add seat ID to the grouped data
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
        <?php if ($concert): ?>
            <div class="poster">
                <img src="img/<?php echo htmlspecialchars($concert['poster']); ?>" alt="<?php echo htmlspecialchars($concert['nama_konser']); ?>">
                <div class="back_detail">
                    <h2><?php echo htmlspecialchars($concert['nama_konser']); ?></h2>
                    <hr>
                    <div class="icon">
                        <p><img src="img/calendar.png" alt="calendar">Tanggal: <?php echo date("d F Y", strtotime($concert['tanggal_awal'])); ?><?php if ($concert['tanggal_akhir']): ?> - <?php echo date("d F Y", strtotime($concert['tanggal_akhir'])); ?><?php endif; ?></p>
                        <p><img src="img/time.png" alt="time">Waktu: <?php echo date("H:i", strtotime($concert['waktu'])); ?></p>
                        <p><img src="img/location.png" alt="location">Lokasi: <?php echo htmlspecialchars($concert['venue']); ?></p>
                    </div>
                </div>
            </div>

            <div class="back_desc">
                <h2>Deskripsi</h2>
                <hr>
                <p><?php echo nl2br(htmlspecialchars($concert['deskripsi'])); ?></p>
                <br>
                <h2>Term & Condition</h2>
                <hr>
                <h3>Ketentuan Umum</h3>
                <ol>
                    <?php foreach (explode("\n", $concert['syarat']) as $syarat): ?>
                        <li><?php echo htmlspecialchars(trim($syarat)); ?></li>
                    <?php endforeach; ?>
                </ol>
                <h2>Seating Plan</h2>
                <hr>
                <div class="seat">
                    <img src="img/<?php echo htmlspecialchars($concert['seating_plan']); ?>" alt="seating_plan">
                    <br>

                    <!-- Form for selecting seats -->
                    <form id="bookingForm" method="GET" action="pemesanan3.php">
                        <div class="seat">
                            <?php foreach ($grouped_seats as $seat_name => $dates): ?>
                                <div class="tiket">
                                    <p><?php echo htmlspecialchars($seat_name); ?> (Rp <?php echo number_format($dates[key($dates)]['harga']); ?>)</p>
                                    <hr>
                                    <?php foreach ($dates as $date => $seat_info): ?>
                                        <p><?php echo date("d F Y", strtotime($date)); ?></p>
                                        <?php if (isset($seat_info['stok']) && $seat_info['stok'] > 0): ?>
                                            <span id="availability-<?php echo htmlspecialchars($seat_info['ID_kursi']); ?>"><?php echo $seat_info['stok']; ?> tickets left</span><br>
                                            <input type="number" id="quantity-<?php echo htmlspecialchars($seat_info['ID_kursi']); ?>" name="quantity[<?php echo htmlspecialchars($seat_info['ID_kursi']); ?>]" min="0" max="<?php echo $seat_info['stok']; ?>" value="0">
                                            <input type="hidden" name="ID_kursi[]" value="<?php echo htmlspecialchars($seat_info['ID_kursi']); ?>">
                                            <input type="hidden" name="seat_name[<?php echo htmlspecialchars($seat_info['ID_kursi']); ?>]" value="<?php echo htmlspecialchars($seat_name); ?>">
                                        <?php else: ?>
                                            <span>sold out</span>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <input type="submit" id="pesan" value="PESAN TIKET">
                    </form>
                </div>
            </div>
        <?php else: ?>
            <p>No concert found with the given ID.</p>
        <?php endif; ?>
    </main>
    <footer>
        <span>2024 &copy Owl's Ticket, All rights reserved.</span>
    </footer>
    <script>
        document.getElementById('bookingForm').addEventListener('submit', function(event) {
            var quantities = document.querySelectorAll('input[name^="quantity"]');
            var hasTickets = false;

            quantities.forEach(function(input) {
                if (parseInt(input.value) > 0) {
                    hasTickets = true;
                }
            });

            if (!hasTickets) {
                event.preventDefault();
                alert('Please select at least one ticket.');
            }
        });
    </script>
</body>
</html>