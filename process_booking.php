<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ticketQuantity = $_POST['ticketQuantity'];
    $seatPrice = $_POST['seatPrice'];
    $totalPrice = $ticketQuantity * $seatPrice;

    $_SESSION['ticketQuantity'] = $ticketQuantity;
    $_SESSION['totalPrice'] = $totalPrice;

    header('Location: payment.php');
    exit();
} else {
    header('Location: pemesanan3.php');
    exit();
}
?>
