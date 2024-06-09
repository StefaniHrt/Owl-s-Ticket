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
            <input type="text" class="search" placeholder="Search the Concerts"> 
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
                        <th>
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
                        </th>
                    </tr>
                </thead>
            </table>
            <br>
            
            <?php
        include 'connection.php';

        $sql = "SELECT k.ID_konser, k.nama_konser, k.tanggal_awal, k.tanggal_akhir, k.venue, k.poster, 
                    MIN(c.harga) as harga_terendah, MAX(c.harga) as harga_tertinggi 
                FROM konser k
                JOIN kursi c ON k.ID_konser = c.ID_konser
                GROUP BY k.ID_konser";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
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

        $conn->close();
        ?>
        </div>
    </main>
    <footer>
        <span>2024 &copy Owl's Ticket, All rights reserved.</span>
    </footer>
</body>
</html>