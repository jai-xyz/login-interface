<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
if(!isset($_SESSION['user_info'])){
    header('Location:index.php');
    exit();
}
$user_data = $_SESSION['user_info'];
$user_id = $user_data['id'];
$user_fname = $user_data['fname'];
 ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link rel="stylesheet" href="style.css">
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
                <li class="nav_item"><a href="index.php" class="nav_link nav_link_button">log out</a></li>
            </ul>
        </nav>
    </header>
</div>
<body>

    <h1 class="welcome-text">Welcome, <?php echo $user_fname; ?></h1> 
</body>

</html>