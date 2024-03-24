<?php

require ("home.php");
session_start();

$user_id = $_SESSION['user_id'];
if (isset ($_POST["btn_add_post"])) {

	$Post_Text = $_POST["post_text"];
	// if ($Post_Text != "") {
	// ......uploadImage......

	if (isset ($_FILES["image"]) && $_FILES["image"]["error"] == 0) {

		$target_dir = "uploadImages/";
		$target_file = $target_dir . basename($_FILES["image"]["name"]);

		echo ($target_file);

		$name = $_FILES["image"]["name"];
		$tmp = explode('.', $name);
		$file_extension = end($tmp);
		$milliseconds = floor(microtime(true) * 1000);
		$target_file = $target_dir . $milliseconds . $name;


		if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {

			$insertPost = $conn->prepare("INSERT INTO posts (user_id, post_content, upload_image, post_date) VALUES (:user_id, :post_content,:upload_image, now())");
			$insertPost->bindParam(":user_id", $user_id);
			$insertPost->bindParam(":post_content", $Post_Text);
			$insertPost->bindParam(":upload_image", $target_file);
			$insertPost->execute();
			// require_once ("home.php");


			echo "Post added successfully with image.";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	} else {

		// require_once ("home.php");

		$insertPost = $conn->prepare("INSERT INTO posts (user_id, post_content, post_date) VALUES (:user_id, :post_content, now())");
		$insertPost->bindParam(":user_id", $user_id);
		$insertPost->bindParam(":post_content", $Post_Text);
		$insertPost->execute();

		echo "Post added successfully.";

	}

}

?>

<body>
	<div class="grid-container" id="blur">
		<div class="sidebar">
		</div>
		<div class="main">
			<p class="page_titel">Home</p>
			<div class="tweet_box tweet_add">
				<div class="tweet_left">
					<img src="RAlogo.jpeg" alt="">
				</div>

				<div class="tweet_body">

					<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
						<textarea name="post_text" id="update" cols="100%" rows="3"
							placeholder="what's happening?"></textarea>
						<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
						<script
							src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.js"></script>
						<div class="tweet_icons-wrapper">
							<div class="content">
								<div class="tweet_icons-add">
									<label for="img-add-input" class="inputimg"><i
											class="fa-regular fa-image icon"></i></label>
									<input type="file" class="img-input" name="image" value="image" id="img-add-input"
										accept="image/*">

								</div>
								<div id="image-add-preview"></div>
							</div>
							<!-- <button class="button_tweet" type="submit" name="btn_add_post">Tweet</button> -->
							<button class="btn btn-outline-primary" type="submit" name="btn_add_post">Tweet</button>

						</div>
					</form>
				</div>
			</div>
			<?php

			require_once "tweet.php";

			?>

		</div>

	</div>
	<!-- update textarea -->
	<div id="popup-window" class='popup-close'>
		<div id="close-btn">
			&times;
		</div>
		<div class="tweet_display">
			<div class="main">
				<div class="tweet_body ">
					<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
						<input type="hidden" id='updatepost-id' name='post_id'></input>
						<textarea name="post_text" id="updatepost-text" cols="100%" rows="3"
							placeholder="update"></textarea>
						<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
						<script
							src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.js"></script>

						<div class="tweet_icons-wrapper">
							<div class="tweet_icons-add">
								<!-- <a href=""> <i class="fa-regular fa-image"></i></a> -->
								<label for="img-update-input" class="inputimg"><i
										class="fa-regular fa-image icon"></i></label>
								<input type="file" name="image-update" class="img-input" id="img-update-input"
									accept="image/*">

							</div>
							<div id="image-update-preview"></div>
							<!-- <i class="fa-regular fa-face-smile"></i> -->
						</div>
						<button class="btn btn-outline-primary" type="submit" name="btn_update_post">opslaan</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	</div>




	<!-- Update Post -->
	<?php
	if (isset ($_POST["btn_update_post"])) {

		if ($_POST["post_text"] != "") {


			if (isset ($_FILES["image-update"]) && $_FILES["image-update"]["error"] == 0) {

				$target_up = "uploadImages/";
				$target_file = $target_up . basename($_FILES["image-update"]["name"]);

				echo ($target_file);

				$name = $_FILES["image-update"]["name"];
				$tmp = explode('.', $name);
				$file_extension = end($tmp);
				$milliseconds = floor(microtime(true) * 1000);
				$target_file = $target_up . $milliseconds . $name;

				if (move_uploaded_file($_FILES["image-update"]["tmp_name"], $target_file)) {

					$updatePost = $conn->prepare(query: "UPDATE posts SET post_content= :post_content, upload_image= :upload_image WHERE post_id= :post_id");
					$updatePost->bindParam(":post_id", $_POST["post_id"]);
					$updatePost->bindParam(":post_content", $_POST["post_text"]);
					$updatePost->bindParam(":upload_image", $target_file);
					$updatePost->execute();
					// require_once ("home.php");
	

					echo "Post added successfully with image.";
				} else {
					echo "Sorry, there was an error uploading your file.";
				}
			} else {

				// require_once ("home.php");
	
				$updatePost = $conn->prepare(query: "UPDATE posts SET post_content= :post_content WHERE post_id= :post_id");
				$updatePost->bindParam(":post_id", $_POST["post_id"]);
				$updatePost->bindParam(":post_content", $_POST["post_text"]);
				$updatePost->execute();

				echo "Post added successfully.";

			}
		}
		//! Fix refresh after update ----------------------------------------------->
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=' . $location . '">';
		//! Fix refresh after update ----------------------------------------------->
	}



	?>
	<script>
		const closeButton = document.getElementById('close-btn')

		closeButton.addEventListener('click', () => {
			document.getElementById("blur").classList.remove("active");
			document.getElementById('popup-window').classList.remove('popup-show')
			document.getElementById('popup-window').classList.add('popup-close')
		})


		document.getElementById('img-add-input').addEventListener('change', function () {
			let file = this.files[0];
			if (file) showImage(file, 'image-add-preview')
		});


		//  ..............update.................

		document.getElementById('img-update-input').addEventListener('change', function () {
			let file = this.files[0];
			if (file) showImage(file, 'image-update-preview')
		});

		function showImage(file, id) {
			var reader = new FileReader();
			reader.onload = function (event) {
				var img = document.createElement('img');
				img.classList.add('s-img')
				img.src = event.target.result;
				document.getElementById(id).innerHTML = ''; // Clear previous preview
				document.getElementById(id).appendChild(img);
			};
			reader.readAsDataURL(file);
		}
	</script>
	<script type="text/javascript">
		$('#update').emojioneArea({ pickerPosition: 'bottom' });

	</script>

	<script>
		function updatePost(postText, postId, postImg) {
			console.log(postId, postText)
			const blur = document.getElementById("blur");
			blur.classList.add('active');
			document.getElementById("updatepost-id").value = postId;
			document.getElementById("updatepost-text").innerText = postText;

			let img = document.createElement('img');
			img.classList.add('s-img')
			img.src = postImg;
			document.getElementById('image-update-preview').innerHTML = ''; // Clear previous preview
			document.getElementById('image-update-preview').appendChild(img);


			document.getElementById('popup-window').classList.add('popup-show');
			document.getElementById('popup-window').classList.remove('popup-close');

			$('#updatepost-text').emojioneArea({ pickerPosition: 'bottom' });

		}




	</script>
</body>