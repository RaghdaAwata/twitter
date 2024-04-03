<?php
session_start();

include("connction.php");


	if (isset($_POST['login'])) {

		$email = htmlentities(mysqli_real_escape_string($con, $_POST['email']));
		$pass = htmlentities(mysqli_real_escape_string($con, $_POST['pass']));

		$select_user = "select * from users where Email='$email' AND Passwoord='$pass'";
		$query= mysqli_query($con, $select_user);
		$check_user = mysqli_num_rows($query);

		if($check_user == 1){
			$_SESSION['Email'] = $email;
			$followingdata = $query->fetch_array(MYSQLI_ASSOC);
			
			echo "<script>window.open('function.php', '_self')</script>";
			// echo $_SESSION['user_id'];
			$_SESSION['user_id']= $followingdata['user_id'];
		}else{
			echo"<script>alert('Your Email or Password is incorrect')</script>";
		}
	}
?>
