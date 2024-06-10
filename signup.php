<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);  // Tanpa hashing

    $sql = "INSERT INTO user (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        echo "<script>alert('User registered successfully!');</script>";
        header("Location: login.php");
        exit();
    } else {
        echo "<script>alert('Error registering user.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owl's Ticket Sign Up</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>
    <center>
        <div class="block">
            <div class="head">
                <img src="img/owlsticketlogo.png" alt="Owl's Ticket Logo">
                <h5>Sign up first to make an account!</h5>
            </div>
            <div class="forms">
                <form method="post" action="signup.php">
                    <h5>Username</h5>
                    <input type="text" name="username" id="username" placeholder="Enter your username" required>
                    <h5 class="psw">Email Address</h5>
                    <input type="email" name="email" id="email" placeholder="Enter your email address" required>
                    <h5 class="psw">Password</h5>
                    <input type="password" name="password" id="password" placeholder="Enter your password" required>
                    <button type="submit">Sign Up</button>
                </form>
            </div>
            <div class="login">
                <p>Already signed up?</p>
                <a href="login.php">Log In</a>
            </div>
        </div>
    </center>
</body>
</html>
