<?php
session_start();
$host = "ec2-79-125-2-142.eu-west-1.compute.amazonaws.com";
$username = "ixpbvdzakdhcrm";
$password = "5bd7efa38326e79f34cd08ffca8bdf5ac17f7dd5c0ea5670b144873ef4ca2dfd";
$db = "d6kg1bsc34mrv4"; 
$port="5432";
$dsn = "pgsql:host=$host port=$port dbname=$db user=$username password=$password ";
$conn = pg_connect($dsn);
if (!empty($conn)){
echo "yub"
;
}
else {
  echo "no";
  die $conn->error_reporting;
}
?>		