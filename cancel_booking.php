<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_pemesanan'])) {
    $idPemesanan = $_POST['id_pemesanan'];

    $sql = "DELETE FROM Tiket WHERE ID_pemesanan = $idPemesanan";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: main_page.php");
        exit();
    } else {
        echo "Gagal membatalkan pemesanan.";
    }
} else {
    echo "Akses tidak sah.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Booking</title>
    <link rel="stylesheet" href="cancel_booking.css">
</head>
<body>
    <div class="container">
        <h2>Cancel Booking</h2>
        <p>Apakah Anda yakin ingin membatalkan pemesanan ini?</p>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <input type="hidden" name="id_pemesanan" value="<?php echo isset($_GET['id_pemesanan']) ? $_GET['id_pemesanan'] : ''; ?>">
            <button type="submit" name="cancel">Ya</button>
            <a href="booking.php">Tidak</a>
        </form>
    </div>
</body>
</html>
