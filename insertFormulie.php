<!DOCTYPE html>
<html>
<body>

<h2>Nieuw account maken</h2>

<form action="/sql/index.php" method="post">

  <label for="fname">First name:</label><br>
  <input type="text" id="fname" name="fname"><br>

  <label for="lname">Last name:</label><br>
  <input type="text" id="lname" name="lname"><br>

  <label for="email">E-mail:</label><br>
  <input type="text" id="email" name="mail"><br>

  <label for="pass">Passwoord:</label><br>
  <input type="Password" id="pass" name="pass"><br>
  
  <label for="land">Land:</label><br>
  <input type="text" id="land" name="land"><br><br>

  <select name="u_gender" required="required">
    <option disabled>Select your Gender</option>
    <option>Male</option>
    <option>Female</option>
  </select><br><br>
  <label >Birthday:</label><br>
  <input type="date" name="u_birthday" value="Submit"><br><br>

  <!-- <button type="submit">-- go-- </button><br> -->
 
  <input type="submit" name="verzenden" required="required"><br><br>
  <?php 
  if(isset($_POST['verzenden'])){
    
    // $data = $query->fetch_array(MYSQLI_ASSOC);
       echo"<sript>window.open('index.php','_self')</sript>";
			// echo $_SESSION['user_id'];
			// $_SESSION['user_id']= $data['user_id'];
  }
  ?>
</form> 
</body>
</html>

