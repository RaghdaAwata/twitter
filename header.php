<?php
include("function.php");
include("connction.php");
?>
<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-target="#bs-example-navbar-collapse-1" data-toggle="collapse" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="home.php">Coding Cafe</a>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	      	
	      	<?php 
			$user = $_SESSION['Email'];
			$get_user = "select * from users where email='$user'"; 
			$run_user = mysqli_query($con,$get_user);
			$row=mysqli_fetch_array($run_user);
					
			$user_id = $row['id']; 
			$user_name = $row['usernaam'];
			$first_name = $row['Firstnaam'];
			$last_name = $row['Lastnaam'];
			$user_pass = $row['Passwoord'];
			$user_email = $row['Email'];
			$user_country = $row['Land'];
			$user_gender = $row['Geslacht'];
			$user_birthday = $row['Geboortdatum'];
					
					
			$user_posts = "select * from posts where user_id='$user_id'"; 
			$run_posts = mysqli_query($con,$user_posts); 
			$posts = mysqli_num_rows($run_posts);
			?>

	      
</nav>