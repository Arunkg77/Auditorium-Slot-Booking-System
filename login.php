<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbHost = 'localhost';
    $dbName = 'dummy_db';
    $dbUser = 'root';
    $dbPass = '';

    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $username = $conn->real_escape_string($username);
        $password = $conn->real_escape_string($password);

        $query = "SELECT * FROM login WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($query);

        if ($result->num_rows === 1) {
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid username or password";
        }
    }

    if (isset($_POST['username1']) && isset($_POST['password1'])) {
        $username1 = $_POST['username1'];
        $password1 = $_POST['password1'];

        if ($username1 === 'arun' && $password1 === '1234') {
            $_SESSION['username1'] = $username1;
            header("Location: deleteForm.php");
            exit();
        } else {
            $error = "Invalid username or password";
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registraton</title>
  <link rel="stylesheet" href="style.css">
  <!-- https://bytewebster.com/ -->
  <!-- https://bytewebster.com/ -->
  <!-- https://bytewebster.com/ -->
</head>
<body>
    
  <div class="container">
    <div class="forms-container">
      <div class="form-control signup-form">
        <form method="post">
          <label for="username">Username:</label>
          <input type="text" name="username" required>
          <label for="password">Password:</label>
          <input type="password" name="password" required>
          <button type="submit"><span class="emoji">🔒</span> Login</button>
        </form>
        
        
      </div>
      <div class="form-control signin-form">
        <form method="post">
          <label for="username1">Username:</label>
          <input type="text" name="username1" required>
          <label for="password1">Password:</label>
          <input type="password" name="password1" required>
          <button type="submit"><span class="emoji">🔒</span> Login</button>
        </form>
        
        
      </div>
    </div>
    <div class="intros-container">
      <div class="intro-control signin-intro">
        <div class="intro-control__inner">
          <h2>Welcome back!</h2>
          <p>
            Welcome back! We are so happy to have you here. It's great to see you again. We hope you had a safe and enjoyable time away.
          </p>
          <button id="signup-btn">Sign-in to register slot.</button>
        </div>
      </div>
      <div class="intro-control signup-intro">
        <div class="intro-control__inner">
          <h2>Come join us!</h2>
          <p>
            We are so excited to have you here.GM hallamma Auditorium ,GMIT Davangere.
          </p>
          <button id="signin-btn">Managers portal Sign-in.</button>
        </div>
      </div>
    </div>
  </div>
  <script src="./script.js"></script>
</body>
</html>
