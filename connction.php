<?php
$servername = "localhost";
$username = "root";
$password = "";
$con = mysqli_connect("localhost","root","","twitter");
try {
    echo "Connected successfully <br>";
  } catch(PDOException $e) {
    echo "Connection failed: <br>" . $e->getMessage();
  }
  
?>
