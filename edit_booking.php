<?php
    include 'connection.php';

    if(isset($_GET['id'])) {
        $idPemesanan = $_GET['id'];
        $sql = "SELECT * FROM Tiket WHERE ID_pemesanan = $idPemesanan";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
        } else {
            echo "Data pemesanan tidak ditemukan.";
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama_lengkap = $_POST['nama_lengkap'];
        $email = $_POST['email'];
        $no_telp = $_POST['no_telp'];
        $id_pemesanan = $_POST['id_pemesanan'];
        $update_query = "UPDATE Tiket SET nama_lengkap='$nama_lengkap', email='$email', no_telp='$no_telp' WHERE ID_pemesanan=$id_pemesanan";
        $update_result = mysqli_query($conn, $update_query);

        if ($update_result) {
            echo "Data pemesanan berhasil diperbarui.";
        } else {
            echo "Gagal memperbarui data pemesanan: " . mysqli_error($conn);
        }
    }
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
    <link rel="stylesheet" href="edit_booking.css">
</head>
<body>
    <div class="container">
        <h2>Edit Booking</h2>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <input type="hidden" name="id_pemesanan" value="<?php echo $idPemesanan; ?>">
            <label for="nama_lengkap">Nama Lengkap:</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo $row['nama_lengkap']; ?>" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>
            <label for="no_telp">No. Telepon:</label>
            <input type="tel" id="no_telp" name="no_telp" value="<?php echo $row['no_telp']; ?>" required>
            <button type="submit">Simpan</button>
        </form>
    </div>
</body>
</html>
