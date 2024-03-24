<?php
$servername = "localhost";
$username = "root";
$password = "";
$con = mysqli_connect("localhost","root","","users");
try {
    echo "Connected successfully <br>";
  } catch(PDOException $e) {
    echo "Connection failed: <br>" . $e->getMessage();
  }
  
?>
