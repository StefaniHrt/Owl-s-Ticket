<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owl's Ticket - Main Page</title>
    <link rel="stylesheet" href="main_page.css">
</head>
<body>
    <main>
        <header>
            <img src="img/owlsticketlogo.png" alt="logo owl's ticket">
            <form method="POST" action="">
                <input type="text" name="search" class="search" placeholder="Search the Concert">
                <button type="submit" name="submit_search"><img src="img/search.png"></button>
            </form>
            <nav>
                <ul>
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
        <div>
            <table class="dropdown">
                <thead>
                    <tr>
                        <th>
                            <h1>UPCOMING CONCERTS</h1>
                        </th>
                        <!-- <th>
                            <select class="loc">
                                <option value="location">--- LOCATION --- </option>
                                <option value="jkt">DKI JAKARTA</option>
                                <option value="jogja">DI YOGYAKARTA</option>
                            </select>
                        </th>
                        <th>
                            <select class="category">
                                <option value="cat">--- CATEGORY ---</option>
                                <option value="kpop">K-POP</option>
                                <option value="west">WESTERN</option>
                                <option value="fest">FESTIVAL</option>
                            </select>
                        </th>
                        <th>
                            <input type="date" class="dt">
                        </th> -->
                    </tr>
                </thead>
            </table>
            <br>
            <?php
include 'connection.php';

if (isset($_POST['submit_search'])) {
    // Ambil input pencarian
    $search = isset($_POST['search']) ? strtolower($_POST['search']) : '';
    $search = mysqli_real_escape_string($conn, $search);

    // Query pencarian
    $sql = "SELECT k.ID_konser, k.nama_konser, k.tanggal_awal, k.tanggal_akhir, k.venue, k.poster, 
                MIN(c.harga) AS harga_terendah, MAX(c.harga) AS harga_tertinggi 
            FROM konser k
            JOIN kursi c ON k.ID_konser = c.ID_konser
            LEFT JOIN artis_konser ak ON k.ID_konser = ak.ID_konser
            LEFT JOIN artis a ON ak.ID_artis = a.ID_artis
            WHERE k.tanggal_akhir >= CURDATE()";

    // Tambahkan kondisi pencarian jika input tidak kosong
    if (!empty($search)) {
        $sql .= " AND (
                    LOWER(k.nama_konser) LIKE '%$search%' OR 
                    LOWER(a.nama_artis) LIKE '%$search%' OR 
                    LOWER(k.lokasi) LIKE '%$search%' OR 
                    LOWER(k.venue) LIKE '%$search%' OR 
                    LOWER(k.tanggal_awal) LIKE '%$search%' OR 
                    LOWER(k.tanggal_akhir) LIKE '%$search%'
                )";
    }

    $sql .= " GROUP BY k.ID_konser";

    // Eksekusi query
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        // Tampilkan hasil pencarian
        while($row = $result->fetch_assoc()) {
            echo "<table class='concerts'>";
            echo "<tr>";
            echo "<td class='poster'><img src='img/" . $row["poster"] . "' width='157px' height='222px' alt='" . $row["poster"] . "'></td>";
            echo "<td class='desc'>";
            echo "<span class='judul'>" . $row["nama_konser"] . "</span>";
            echo "<p class='date'>" . date("d F Y", strtotime($row["tanggal_awal"]));
            if ($row["tanggal_akhir"]) {
                echo " - " . date("d F Y", strtotime($row["tanggal_akhir"]));
            }
            echo "</p>";
            echo "<p class='place'>" . $row["venue"] . "<p>";
            echo "<p class='price'>Rp " . number_format($row["harga_terendah"]) . " - Rp " . number_format($row["harga_tertinggi"]) . "<p>";
            echo "<br>";
            echo "<a href='details.php?ID_konser=" . $row["ID_konser"] . "'>SEE DETAILS</a>"; 
            echo "</td>";
            echo "</tr>";
            echo "</table>";
        }
    } else {
        echo "0 results";
    }
} else {
    // Tampilkan semua konser jika tombol search tidak ditekan
    $sql = "SELECT k.ID_konser, k.nama_konser, k.tanggal_awal, k.tanggal_akhir, k.venue, k.poster, 
                MIN(c.harga) AS harga_terendah, MAX(c.harga) AS harga_tertinggi 
            FROM konser k
            JOIN kursi c ON k.ID_konser = c.ID_konser
            GROUP BY k.ID_konser";

    // Eksekusi query
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Tampilkan semua konser
        while($row = $result->fetch_assoc()) {
            echo "<table class='concerts'>";
            echo "<tr>";
            echo "<td class='poster'><img src='img/" . $row["poster"] . "' width='157px' height='222px' alt='" . $row["poster"] . "'></td>";
            echo "<td class='desc'>";
            echo "<span class='judul'>" . $row["nama_konser"] . "</span>";
            echo "<p class='date'>" . date("d F Y", strtotime($row["tanggal_awal"]));
            if ($row["tanggal_akhir"]) {
                echo " - " . date("d F Y", strtotime($row["tanggal_akhir"]));
            }
            echo "</p>";
            echo "<p class='place'>" . $row["venue"] . "<p>";
            echo "<p class='price'>Rp " . number_format($row["harga_terendah"]) . " - Rp " . number_format($row["harga_tertinggi"]) . "<p>";
            echo "<br>";
            echo "<a href='details.php?ID_konser=" . $row["ID_konser"] . "'>SEE DETAILS</a>"; 
            echo "</td>";
            echo "</tr>";
            echo "</table>";
        }
    } else {
        echo "0 results";
    }
}

// Tutup koneksi
$conn->close();
?>

        </div>
    </main>
    <footer>
        <span>2024 &copy Owl's Ticket, All rights reserved.</span>
    </footer>
</body>
</html>