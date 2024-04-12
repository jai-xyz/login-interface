<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registraton</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="register.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100italic,300,300italic,regular,italic,500,500italic,700,700italic,900,900italic" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:regular,500,600,700,800,900,italic,500italic,600italic,700italic,800italic,900italic" rel="stylesheet" />
</head>

<div class="container">
    <header>
        <nav>
            <img src="imgs/logo.png" alt="" class="logo" width="40px"> <span class="logo-title">Lorem <span class="title-dark">Ipsum</span> </span>
            <ul class="nav_list">
                <li class="nav_item"><a href="#" class="nav_link">home</a></li>
                <li class="nav_item"><a href="#" class="nav_link">about us</a></li>
                <li class="nav_item"><a href="#" class="nav_link">contact</a></li>
                <li class="nav_item"><a href="index.php" class="nav_link nav_link_button">login</a></li>
            </ul>
        </nav>
    </header>
</div>

<body>
    <div class="register-main-container">
        <div class="register-container">

            <form action="register.php" method="POST">
                <h2>REGISTER</h2>
                <div class="form-box">
                    <label for="fname">First name </label> <br>
                    <input type="text" name="fname" required> <br>
                </div>

                <div class="form-box">
                    <label for="mname">Middle name </label> <br>
                    <input type="text" name="mname" > <br>
                </div>

                <div class="form-box">
                    <label for="lname">Last name </label> <br>
                    <input type="text" name="lname" required> <br>
                </div>

                <div class="form-box">
                    <label for="dob" class="dob">Date of Birth:</label>
                    <input type="date" name="dob" required> <br>
                </div>

                <div class="form-box">
                    <label for="gender" class="gender">Gender: </label>

                    <input type="radio" name="gender" value="male" id="male" required>
                    <label for="male">Male</label>

                    <input type="radio" name="gender" value="female" id="female" required>
                    <label for="female">Female</label> <br>
                </div>

                <div class="form-box">
                    <label for="email">Email </label> <br>
                    <input type="email" name="email" required> <br>
                </div>

                <div class="form-box">
                    <label for="password">Password</label> <br>
                    <input type="password" name="password" required> <br>
                </div>

                <div class="form-box">
                    <label for="cpassword">Confirm Password</label> <br>
                    <input type="password" name="cpassword" required> <br>
                </div>

                <div class="form-box-submit">
                    <input type="submit" value="Register" name="register">
                </div>

                <?php 
                if(isset($_GET['fill'])){
                    if($_GET['fill'] === "empty"){
                        echo '<div class="fill">Please input all fields.</div>';
                    }

                    if($_GET['fill'] === "gender"){
                        echo '<div class="fill">Please select your gender.</div>';
                    }
                }
                
                if(isset($_GET['error'])){
                    if($_GET['error'] === 'invalidcred'){
                        echo '<div class="error">Password does not match.</div>';
                    }

                    if($_GET['error'] === 'duplicateemail'){
                        echo '<div class="error">The email already used.</div>';
                    }
                    
                }

                ?>

                <div class="form-box">
          <span class="login">Already have account?  <a href="login.php">Click here to login</a></span>
        </div>

            </form>
        </div>
    </div>
</body>

</html>

<?php

include_once 'db.php';

if (isset($_POST['register']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    $hash = password_hash($password, PASSWORD_DEFAULT);
    if ($password != $cpassword) {
        header('Location: register.php?error=invalidcred');
        exit();
    } elseif (empty($gender)) {
        header('Location: register.php?fill=gender');
        exit();
    } elseif (empty($fname && $lname && $dob  && $email && $password && $cpassword)) {
        header('Location: register.php?fill=empty');
        exit();
    } else {

        $sql_check = "SELECT * FROM user_info WHERE email = ?";
        $stmt_check = mysqli_prepare($conn, $sql_check);

        if (!$stmt_check) {
            echo 'Error preparing statement: ' . mysqli_error($conn);
            exit();
        }

        mysqli_stmt_bind_param($stmt_check, "s", $email);

        if (!mysqli_stmt_execute($stmt_check)) {
            echo 'Error executing check statement: ' . mysqli_error($conn);
            exit();
          }
        
          mysqli_stmt_store_result($stmt_check);
          $rows = mysqli_stmt_num_rows($stmt_check);
          mysqli_stmt_close($stmt_check);
      
          if ($rows > 0) {
            // Email already exists
            header('Location: register.php?error=duplicateemail');
            exit();
          } else {
        $sql = "INSERT INTO user_info (email, fname, mname, lname, dob, gender, password)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        if (!$stmt) {
            echo 'Error preparing statement: ' . mysqli_error($conn);
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sssssss", $email, $fname, $mname, $lname, $dob, $gender, $hash);

        if (!mysqli_stmt_execute($stmt)) {
            echo 'Error executing statement: ' . mysqli_error($conn);
            exit();
        }

        mysqli_stmt_close($stmt);

        if (mysqli_error($conn)) {
            echo "Registration Failed: " . mysqli_error($conn);
        } else {
            header ('Location:index.php?register=success');
        }
    }
}
}


?>