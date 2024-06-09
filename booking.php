<?php
    session_start();
    include 'connection.php'; 

    if(isset($_SESSION['id_user'])) {
        $user_id = $_SESSION['id_user'];
        $sql = "SELECT p.*, t.nama_lengkap, t.email, t.no_telp, k.nama_konser, kur.nama_kursi
                FROM Pemesanan p
                JOIN Tiket t ON p.ID_pemesanan = t.ID_pemesanan
                JOIN Konser k ON p.ID_konser = k.ID_konser
                JOIN Kursi kur ON p.ID_kursi = ku.ID_kursi
                WHERE p.ID_user = $user_id";
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) > 0) {
            // Display booking data in a table
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking List <?php echo $user_id?></title>
    <link rel="stylesheet" href="booking.css">
</head>
<body>
    <header>
        <h1>List Booking</h1>
    </header>
    <main>
        <table>
            <tr>
                <th>ID</th>
                <th>Concert</th>
                <th>Seat</th>
                <th>Total Payment</th>
                <th>Payment Method</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
        <?php
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".$row['ID_pemesanan']."</td>";
                echo "<td>".$row['nama_konser']."</td>";
                echo "<td>".$row['nama_kursi']."</td>";
                echo "<td>".$row['total_pembayaran']."</td>";
                echo "<td>".$row['jenis_pembayaran']."</td>";
                echo "<td>".$row['nama_lengkap']."</td>";
                echo "<td>".$row['email']."</td>";
                echo "<td>".$row['no_telp']."</td>";
                echo "<td>";
        ?>
                <form class="edit-form" method="post" action="edit_booking.php">
                    <input type="hidden" name="id_pemesanan" value="<?php echo $row['ID_pemesanan']; ?>">
                    <input type="submit" value="Edit">
                </form>

                <form class="cancel-form" method="post" action="cancel_booking.php">
                    <input type="hidden" name="id_pemesanan" value="<?php echo $row['ID_pemesanan']; ?>">
                    <input type="submit" value="Cancel">
                </form>

        <?php
                echo "</td>";
                echo "</tr>";
            }
        ?>
    </main>
    <footer>
        <span>2024 &copy Owl's Ticket, All rights reserved.</span>
    </footer>
    <?php
        } else {
            echo "<p>No bookings found for this user.</p>";
        }
    } else {
        echo "<p>Please log in to view your bookings.</p>";
    }
?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var editForms = document.querySelectorAll(".edit-form");
            var cancelForms = document.querySelectorAll(".cancel-form");

            // Event listener for edit forms
            editForms.forEach(function(form) {
                form.addEventListener("submit", function(event) {
                    event.preventDefault();
                    var idPemesanan = form.querySelector('input[name="id_pemesanan"]').value;
                    // Redirect to edit_booking.php with the ID_pemesanan parameter
                    window.location.href = "edit_booking.php?id_pemesanan=" + idPemesanan;
                });
            });

            // Event listener for cancel forms
            cancelForms.forEach(function(form) {
                form.addEventListener("submit", function(event) {
                    event.preventDefault();
                    var idPemesanan = form.querySelector('input[name="id_pemesanan"]').value;
                    // Redirect to cancel_booking.php with the ID_pemesanan parameter
                    window.location.href = "cancel_booking.php?id_pemesanan=" + idPemesanan;
                });
            });
        });

    </script>
</body>
</html>
