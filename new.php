<?php 

session_start();
$servername = "ec2-79-125-2-142.eu-west-1.compute.amazonaws.com:5432";
$username = "ixpbvdzakdhcrm";
$password = "5bd7efa38326e79f34cd08ffca8bdf5ac17f7dd5c0ea5670b144873ef4ca2dfd";
$db = "d6kg1bsc34mrv4"; 
$conn = pg_connect($servername, $username, $password , $db);
if(!empty($_SESSION['id'])){
    $userId=$_SESSION['id'];
    $query="delete from cart where userId=$userId";
    $result=pg_query($conn,$query);
}



header('Location:index.php');
?>