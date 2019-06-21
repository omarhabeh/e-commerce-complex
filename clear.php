<?php 

session_start();
$servername = "localhost:3307";
$username = "root";
$password = "password";
$db = "test"; 
$conn = newpg($servername, $username, $password , $db);
if(!empty($_SESSION['id'])){
    $userId=$_SESSION['id'];
    $query="delete from cart where userId=$userId";
    $result=mysqli_query($conn,$query);
}



header('Location:cart.php');
?>