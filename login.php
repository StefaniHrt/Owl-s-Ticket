<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result -> fetch_assoc();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['ID_user'] = $user['ID_user'];
        echo "<script>alert('Logged In Successfully!');</script>";
        header("Location: main_page.php");
        exit;
    } else {
        echo "<script>alert('Login Failed! Invalid username or password');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owl's Ticket Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <center>
        <div class="block">
            <div class="head">
                <img src="img/owlsticketlogo.png" alt="Owl's Ticket Logo">
                <h5>Log in first to order your tickets!</h5>
            </div>
            <div class="forms">
                <?php if (!empty($message)): ?>
                    <div class="alert"><?php echo $message; ?></div>
                <?php endif; ?>
                <h5>Username</h5>
                <form method="post" action="login.php">  
                    <input type="text" name="username" id="username" placeholder="Username" required>
                    <h5 class="psw">Password</h5>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <button type="submit" name="login">Log In</button>
                </form>
            </div>
            <div class="signup">
                <p>Are you new?</p>
                <a href="signup.php">Sign Up</a>
            </div>
        </div>
    </center>
</body>
</html>
