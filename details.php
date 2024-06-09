<?php
    include 'connection.php';
    if(isset($_GET)){
        $ID_konser=intval($_GET['ID_konser']);
        $sql = "SELECT kon.nama_konser, kon.tanggal_awal, kon.tanggal_akhir, kon.waktu, kon.venue, kon.poster, kon.deskripsi, kon.syarat, kon.seating_plan, kur.ID_kursi, kur.nama_kursi, kur.tanggal, kur.harga, kur.stok
                FROM konser kon
                JOIN kursi kur ON kon.ID_konser = kur.ID_konser
                WHERE kon.ID_konser = $ID_konser
                ORDER BY kur.nama_kursi, kur.tanggal";
        $result = mysqli_query($conn, $sql);
    
        if ($result && mysqli_num_rows($result) > 0) {
            $concert = mysqli_fetch_assoc($result);
        } else {
            echo "No concert found with the given ID.";
            if (!$result) {
                echo "Error: " . mysqli_error($conn); // Output any SQL error for debugging
            }
        }
        if ($result) {
            mysqli_data_seek($result, 0); // Reset pointer hasil query untuk looping pengelompokan kursi
        }
    }

    // Group seats by name and date
    $grouped_seats = array();
    while ($result && $row = mysqli_fetch_assoc($result)) {
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

    // $conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $concert['nama_konser']; ?></title>
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
                <img src="img/<?php echo $concert['poster']; ?>" alt="<?php echo $concert['nama_konser']; ?>">
                <div class="back_detail">
                    <h2><?php echo $concert['nama_konser']; ?></h2>
                    <hr>
                    <div class="icon">
                        <p><img src="img/calendar.png" alt="calendar">Tanggal: <?php echo date("d F Y", strtotime($concert['tanggal_awal'])); ?><?php if ($concert['tanggal_akhir']): ?> - <?php echo date("d F Y", strtotime($concert['tanggal_akhir'])); ?><?php endif; ?></p>
                        <p><img src="img/time.png" alt="time">Waktu: <?php echo date("H:i", strtotime($concert['waktu'])); ?></p>
                        <p><img src="img/location.png" alt="location">Lokasi: <?php echo $concert['venue']; ?></p>
                    </div>
                </div>
            </div>

            <div class="back_desc">
                <h2>Deskripsi</h2>
                <hr>
                <p><?php echo($concert['deskripsi']); ?></p>
                <br>
                <h2>Term & Condition</h2>
                <hr>
                <h3>Ketentuan Umum</h3>
                <ol>
                    <?php foreach (explode("\n", $concert['syarat']) as $syarat): 
                        echo "<li> $syarat</li>";
                        endforeach ?>
                        
                </ol>
                <h2>Seating Plan</h2>
                <hr>
                <div class="seat">
                    <img src="img/<?php echo $concert['seating_plan']; ?>" alt="seating_plan">
                    <br>

                    <!-- Pemilihan tempat duduk -->
                    <form id="bookingForm" method="GET" action="pemesanan3.php">
                        <div class="seat">
                            <?php foreach ($grouped_seats as $seat_name => $dates): ?>
                                <div class="tiket">
                                    <p><?php echo $seat_name; ?> (Rp <?php echo number_format($dates[key($dates)]['harga']); ?>)</p>
                                    <hr>
                                    <?php foreach ($dates as $date => $seat_info): 
                                        echo "<p> ".date("d F Y", strtotime($date))."<br>";
                                        if (isset($seat_info['stok']) && $seat_info['stok'] > 0):
                                            echo '<span id="availability">' . $seat_info['stok'] . ' tickets left</span><br>';
                                            echo '<input type="number" id="quantity" name="quantity[' . $seat_info['ID_kursi'] . ']" min="0" max="' . $seat_info['stok'] . '" value="0">';
                                            echo '<input type="hidden" name="ID_kursi[]" value="' . $seat_info['ID_kursi'] . '">';
                                            echo '<input type="hidden" name="seat_name[' . $seat_info['ID_kursi'] . ']" value="' . $seat_name . '">';
                                        else:
                                            echo "<span>sold out</span>";
                                        endif;
                                    endforeach;
                                    ?>                                
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <input type="submit" id="pesan" value="PESAN TIKET">
                    </form>
                </div>
            </div>
        <?php 
        else:
            echo "<p>No concert found with the given ID.</p>";
        endif; 
        ?>
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