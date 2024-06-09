<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Directory where the uploaded files will be saved
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["paymentProof"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is an actual image or fake image
    $check = getimagesize($_FILES["paymentProof"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size (5MB maximum)
    if ($_FILES["paymentProof"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // If everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["paymentProof"]["tmp_name"], $target_file)) {
            // Save payment details to database (code for this is not included in this snippet)
            echo "The file ". htmlspecialchars(basename($_FILES["paymentProof"]["name"])). " has been uploaded.";
            // Redirect or show success message
            echo "Payment successful!";
            // Clear session data
            session_unset();
            session_destroy();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
} else {
    header('Location: pemesanan3.php');
    exit();
}
?>
