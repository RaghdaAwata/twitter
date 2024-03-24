	<?php
	// require_once("tweet.php");

	?>
	<div class="tweet_display">
		<div class="main">
	<div class="tweet_body1 ">
					<form method="update">
						<textarea name="post_text1" id="" cols="100%" rows="3" ></textarea>

						<div class="tweet_icons-wrapper">
							<div class="tweet_icons-add">
								<a href=""> <i class="fa-regular fa-image"></i></a>
								<!-- <i class="fa-solid fa-chart-bar"></i> -->
								<i class="fa-regular fa-heart"></i>
								<i class="fa-regular fa-face-smile"></i>
								<!-- <i class="fa-solid fa-calendar-days"></i> -->
							</div>
							<button class="button_tweet" type="submit" name="btn_update_post">opslaan</button>
						</div>
					</form>
				</div>
		</div>
	</div>
<?php


    if (isset($_GET["update"])) {
        $Post_Text = $_POST["post_text"];
        $update_ID = $_GET["update"];
        $sql = "UPDATE FROM posts SET post_content= $Post_Text WHERE post_id = '$update_ID'";
        $result = mysqli_query($con, $sql);

        // if($result) {
        //     header("location: function.php");
        //     exit; // Het is een goede praktijk om de scriptuitvoering hier te beëindigen na een header-omleiding
        // } else {
        //     echo "Er is een fout opgetreden bij het verwijderen van de post.";
        // }
    }
?>