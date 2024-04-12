<?php 

$server = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'logindb';

$conn = mysqli_connect($server, $user, $pass, $dbname);

if(!$conn){ 
    echo 'Failed';
} else {
    // echo 'Connected';
}

?>