<?php
$dbhost = "127.0.0.1";
$dbuser = "root";
$dbpass = "";
$dbname = "quiz";

$connection = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

if(mysqli_connect_errno()){
  die("Database connection failed".mysqli_connect_error()."(".mysqli_connect_errno().")"); 
}
?>