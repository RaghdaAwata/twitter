<!-- 
<?php

include("connction.php");


// echo"hi <br>";
if (isset($_POST["verzenden"])){
  // echo"hi5 <br>";
  $firstname = htmlentities(mysqli_real_escape_string($con,$_POST["fname"]));
  $lastname = htmlentities(mysqli_real_escape_string($con,$_POST["lname"]));
  $E_mail= htmlentities(mysqli_real_escape_string($con,$_POST["mail"]));
  $password = htmlentities(mysqli_real_escape_string($con,$_POST["pass"]));
  $country = htmlentities(mysqli_real_escape_string($con,$_POST["land"]));
  $gender = htmlentities(mysqli_real_escape_string($con,$_POST["u_gender"]));
  $birthday = htmlentities(mysqli_real_escape_string($con,$_POST["u_birthday"]));
  $status = "verified";
  $posts = "no";
  $newgid = sprintf('%05d', rand(0, 999999));

  $username = strtolower($firstname . "_" . $lastname . "_" . $newgid );
  $check_username_query = "select username from users where Email='$E_mail'";
  $run_username = mysqli_query($con,$check_username_query);

  if(strlen($password) <9 ){
    echo"<script>alert('Password should be minimum 9 characters!')</script>";
    exit();
  }
  
  // echo"hi99 <br>";

  $check_email ="select * from users where email='$E_mail'";
  $run_email=mysqli_query($con,$check_email);
  $check = mysqli_num_rows($run_email);
  if($check == 1){
    echo "<script>alert('Email aleady exist, Please try using another email')</script>";
    echo "<sript>window.open('login.php', '_self)</sript>";
    exit();
  }
  // echo"hi8<br>";

$insert = "insert into users (Firstname,Lastname,Email,Passwoord,Land,Geslacht,Geboortdatum,username) 
VALUES ('$firstname','$lastname','$E_mail','$password','$country','$gender','$birthday','$username')";
 $query = mysqli_query($con,$insert);
 if ($query){
  echo "<script>alert('well Done $firstname, you are good to go.')</script>";
    echo "<sript>window.open('login.php', '_self')</sript>";
 }
 else{
 echo "<script>alert('Regestration failed, pleas try again.')</script>";
 echo "<sript>window.open('login.php', '_self')</sript>";
 }
}
?> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <title>Login</title>
</head>
<style>
    <?php include "Css/main.css"?>
</style>
<body>
<div class="login">
    <h1>Login</h1>
    <form action="Login.php" method="post">
        <label for="username">
            <i class="fas fa-user"></i>
        </label>
        <input type="text" name="username" placeholder="Username" id="username" required>
        <label for="password">
            <i class="fas fa-lock"></i>
        </label>
        <input type="password" name="password" placeholder="Password" id="password" required>
        <a href="Login.php">Already have an account? Click here to log in!</a>
        <input type="submit" value="Login">
    </form>

</div>
</body>
<?php
require "connction.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $encrypt_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // $insert_user = $conn->prepare("INSERT INTO user_info (Username, Password) VALUES (:gebruikersnaam, :wachtwoord)");
    $insert_user = $conn->prepare("INSERT INTO users (Firstname, Password) VALUES (:gebruikersnaam, :wachtwoord)");

    $insert_user->bindParam(":gebruikersnaam", $_POST['username']);
    $insert_user->bindParam(":wachtwoord", $encrypt_password);

    if ($insert_user->execute()) {
        header("Location: login.php");
        exit;
    }
}
?>