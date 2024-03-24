<?php
$Categorie_ID = $_POST["categorie_id"];
		
		if (!isset($categorie_id)) {
			// Handle error: Categorie not selected
			echo "Please select a category.";
			exit;
		}
        ?>

<?php
				$query = "SELECT * FROM categorie";
				$cate = mysqli_query($con, $query);
			?>
				<div class="tweet_body">
					<select name="categorie" id="categorie">
				
				<?php while ($row = mysqli_fetch_assoc($cate)) { ?>
					
					<option value="<?php echo $row['categorie']; ?>"> <?php echo $row['categorie']; ?> </option>
				<?php } ?>
					</select>
					