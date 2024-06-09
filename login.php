<?php
  include 'connection.php';
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE username = username AND password = password";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      if (password_verify($password, $row['password'])) {
        echo "<script>alert('Login successful!');</script>";
        header("Location: main_page.php");
      } else {
        echo "<script>alert('Invalid password. Please try again.');</script>";
      }
    } else {
      echo "<script>alert('No user found with that username.');</script>";
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
        <h5>Username</h5>
        <form method="post" action="main_page.php">  
          <input type="text" name="username" id="username" placeholder="Username" required>
          <h5 class="psw">Password</h5>
          <input type="password" name="password" id="password" placeholder="Password" required>
          <button type="submit" name="login">Log In</button>
        </form>
      </div>
      <div class="signup">
        <p>Are you new?</p>
        <a href="/signup.html">Sign Up</a>
      </div>
    </div>
  </center>
</body>
</html>
