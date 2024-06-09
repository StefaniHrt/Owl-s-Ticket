<?php
    include 'connection.php';
    // Menangkap parameter ID_konser dari URL
    $ID_konser = isset($_GET['ID_konser']) ? intval($_GET['ID_konser']) : 0;

    // Query untuk mengambil data konser berdasarkan ID_konser
    $sql = "SELECT k.nama_konser, k.tanggal_awal, k.tanggal_akhir, k.venue, k.poster, k.deskripsi, k.syarat, 
                MIN(c.harga) as harga_terendah, MAX(c.harga) as harga_tertinggi 
            FROM konser k
            JOIN kursi c ON k.ID_konser = c.ID_konser
            WHERE k.ID_konser = ?
            GROUP BY k.ID_konser";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ID_konser);
    $stmt->execute();
    $result = $stmt->get_result();

    $concert = $result->num_rows > 0 ? $result->fetch_assoc() : null;
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
                echo "<p><img src='/img/calendar.png' alt='calendar'>Tanggal: " . date("d F Y", strtotime($concert["tanggal_awal"]));
                if ($concert["tanggal_akhir"]) {
                    echo " - " . date("d F Y", strtotime($concert["tanggal_akhir"]));
                }
                echo "</p>";
                echo "<p><img src='/img/time.png' alt='time'>Waktu: 19.00 | 17.00</p>";
                echo "<p><img src='/img/location.png' alt='location'>Lokasi: " . htmlspecialchars($concert["venue"]) . "</p>";
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
                echo "<p>" . nl2br(htmlspecialchars($concert["syarat"])) . "</p>";
                echo "<p><strong>Price: </strong>Rp " . number_format($concert["harga_terendah"]) . " - Rp " . number_format($concert["harga_tertinggi"]) . "</p>";
                echo "</div>";
            } else {
                echo "No concert found with the given ID.";
            }

            $stmt->close();
            $conn->close();
        ?>
    </main>
    <footer>
        <span>2024 &copy Owl's Ticket, All rights reserved.</span>
    </footer>
</body>
</html>