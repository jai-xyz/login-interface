<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="login.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100italic,300,300italic,regular,italic,500,500italic,700,700italic,900,900italic" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:regular,500,600,700,800,900,italic,500italic,600italic,700italic,800italic,900italic" rel="stylesheet" />
</head>

<div class="container">
    <header>
        <nav>
        <img src="imgs/logo.png" alt="" class="logo" width="40px"> <span class="logo-title">Lorem  <span class="title-dark">Ipsum</span> </span>
          
        <ul class="nav_list">
                <li class="nav_item"><a href="#" class="nav_link">home</a></li>
                <li class="nav_item"><a href="#" class="nav_link">about us</a></li>
                <li class="nav_item"><a href="#" class="nav_link">contact</a></li>
                <li class="nav_item"><a href="register.php" class="nav_link nav_link_button">Register</a></li>
            </ul>
            
        </nav>
    </header>
</div>
<body>
  <div class="login-main-container">
    <div class="login-container">
      <form action="index.php" method="POST">
        <h2>LOGIN</h2>
        <div class="form-box">
        <label for="email">EMAIL</label> <br>
        <input type="email" name="email"> <br>
        </div>

        <div class="form-box">
        <label for="password">PASSWORD</label> <br>
        <input type="password" name="password"> <br>
        </div>

        <div class="form-box-submit">
        <input type="submit" value="LOGIN" name="login">
        </div>

        <?php 
        if(isset($_GET['error'])){
          if($_GET['error'] === 'invalidcred'){
            echo '<div class="error">Invalid username or password</div>';
          } elseif ($_GET['error'] === 'invalidpassword'){
            echo '<div class="error">Invalid username or password</div>';
          }
        }

        if(isset($_GET['fill'])){
          if($_GET['fill'] === 'empty'){
            echo '<div class="fill">Please enter email and password. </div>';
          }
        }

        if(isset($_GET['register'])){
          if($_GET['register'] === 'success'){
            echo '<div class="success">High five! Your account is good to go. </div>';
          }
        }
        ?>
        <div class="form-box">
          <span class="register">Don't have account?  <a href="register.php">Sign Up Now</a></span>
        </div>
      </form>
    </div>
  </div>

  <?php

include_once 'db.php'; // Include the database connection file

if (isset($_POST['login']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Validate if email and password are empty
  if (empty($email) || empty($password)) {
    header('Location: login.php?fill=empty');
    exit();
  }

  // Fetch user data by email from database
  $sql = "SELECT * FROM user_info WHERE email = ?";
  $stmt = mysqli_prepare($conn, $sql);

  if (!$stmt) {
    echo 'Error preparing statement: ' . mysqli_error($conn);
    exit();
  }

  mysqli_stmt_bind_param($stmt, "s", $email);

  if (!mysqli_stmt_execute($stmt)) {
    echo 'Error executing statement: ' . mysqli_error($conn);
    exit();
  }

  $result = mysqli_stmt_get_result($stmt);
  $user = mysqli_fetch_assoc($result); // Get user data as an associative array

  mysqli_stmt_close($stmt);

  // Check if user exists
  if (!$user) {
    header('Location: index.php?error=invalidcred');
    exit();
  }


  // Verify password using password_verify()
  if (!$user['password'] === $password) {
    // echo 'Invalid email or password.';
    header('Location: index.php?error=invalidpassword');
    exit();
  }

  session_start();
  
  $_SESSION['user_info'] = $user;
  header('Location: home.php');
  exit(); 

}

?>
</body>

</html> 