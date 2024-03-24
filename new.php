<?php
require_once ("home.php");

session_start();

// $post_id = $_GET['post'];
if (isset ($_GET['post'])) {
    $post_id = $_GET['post'];


    // $comment_id = $_SESSION['comment_id'];

    $selectPost = $conn->prepare("SELECT posts.*, users.username FROM posts INNER JOIN users  WHERE post_id = :post_id");

    $selectPost->bindParam(":post_id", $post_id);
    $selectPost->execute();

    $row = $selectPost->fetch(PDO::FETCH_ASSOC);
    $post_text = $row['post_content'];
    $post_date = $row['post_date'];
    $post_img = $row['upload_image'];
    $user_name = $row['username'];

    require_once ("tweetStructure.php");

}

if (isset ($_POST["btn_add_comment"])) {

    $comment = $_POST["comment_text"];

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

            $insertcomment = $conn->prepare("INSERT INTO comments (comment,Image_upload,commenttime) VALUES (:comment,:upload_image, now())");
            // $insertPost->bindParam(":user_id", $user_id);
            $insertcomment->bindParam(":comment", $comment);
            $insertcomment->bindParam(":upload_image", $target_file);
            $insertcomment->execute();



            echo "Post added successfully with image.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {

        require_once ("home.php");

        $insertcomment = $conn->prepare("INSERT INTO comments (comment, commenttime) VALUES (:comment, now())");
        $insertcomment->bindParam(":comment", $comment);
        $insertcomment->execute();

        echo "comment added successfully.";

    }
    // echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';
}
?>



<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
    <textarea name="comment_text" id="update" cols="100%" rows="3" placeholder="what's happening?"></textarea>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.js"></script>


    <div class="tweet_icons-wrapper">
        <div class="content">
            <div class="tweet_icons-add">
                <label for="img-add-input" class="inputimg"><i class="fa-regular fa-image icon"></i></label>
                <input type="file" class="img-input" name="image" value="image" id="img-add-input" accept="image/*">

            </div>
            <div id="image-add-preview"></div>
        </div>
        
        <button class="btn btn-outline-primary" type="submit" name="btn_add_comment"><i
                class="fa-solid fa-paper-plane"></i></button>

    </div>
</form>


<?php
// $selectcomment = $conn->prepare("SELECT comments.* , users.username FROM comments INNER JOIN users ON comments.commentBy = users.user_id WHERE comments.commentBy = :user_id ORDER BY comment_id DESC");
$selectcomment = $conn->prepare("SELECT * FROM comments");
// $selectcomment->bindParam(":user_id", $user_id);
$selectcomment->execute();



while ($row = $selectcomment->fetch(PDO::FETCH_ASSOC)) {
    $comment_text = $row['comment'];
    $comment_date = $row['commenttime'];
    $comment_img = $row['Image_upload'];
    // $user_name = $row['username'];

    ?>

    <div class="tweet_box">
        <div class="tweet_left"><img src="RAlogo.jpeg"></div>

        <div class="tweet_body">
            <div class="tweet_header">
                <p class="tweet_name">naam
                    <?php $user_name ?>
                </p>
                <p class="tweet_username"> @code</p>
                <p class="tweet_date">
                    <?php echo $comment_date = date('H d'), strtotime($comment_date); ?>
                </p>
            </div>

            <p class="tweet_text">
                <?php echo $comment_text; ?>
            </p>
            <?php
            if ($comment_img) {
                ?>
                <img class="post-img" id="uploadpost-img" src='<?php echo $comment_img ?>'>
            <?php
            }
            ?>

<div class="tweet_icons">

    <a href=""><i class="fa-regular fa-heart"></i></a>
    <a href=""><i class="fa-regular fa-comment"></i></a>
</div>

</div><br><br>

<!-- Delete / Edit-->
<div class="tweet_del">
    <div class="dropdown">
        <button class="dropbtn"><span class="fa fa-ellipsis-h"></span></button>
        <div class="dropdown-content">
            <a href="javascript:void(0);"
            onclick="updateComment('<?php echo $row['comment']; ?>', '<?php echo $row['comment_id']; ?>', '<?php echo $row['Image_upload']; ?>')"><i
            class="fa-regular fa-pen-to-square edit"></i><span> edit</span></a>
            <a href="comment.php?del=<?php echo $row['comment_id']; ?>&url=<?php echo $row['Image_upload']; ?>"><i
            class="fa-solid fa-xmark delete"></i><span> delete</span></a>
        </div>
        
    </div>
</div>
</div>
<?php
if (isset($_GET["del"])) {
        $Del_ID = $_GET["del"];
        //! Remove the image -------------------------------------------------->
        $Img_Url = $_GET['url'];
        unlink($Img_Url);
        //! Remove the image -------------------------------------------------->
        $deletecomment = $conn->prepare("DELETE FROM comments WHERE comment_id = :comment_id");
        $deletecomment->bindParam(":comment_id", $Del_ID);
        // $selectPost->bindParam(":post_text",$post_text); 
        $deletecomment->execute();

        if ($deletecomment) {
            header("location:comment.php");
            exit;
        } else {
            echo "Er is een fout opgetreden bij het verwijderen van de post.";
        }
    }?>
<?php
}
?>
<!-- update textarea -->
<div id="popup-window" class='popup-close'>
		<div id="close-btn">
			&times;

		</div>
		<div class="tweet_display">
			<div class="main">
				<div class="tweet_body ">
					<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
						<input type="hidden" id='updatecomment-id' name='post_id'></input>
						<textarea name="post_text" id="updatecomment-text" cols="100%" rows="3"
							placeholder="update"></textarea>

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
						<button class="btn btn-outline-primary" type="submit" name="btn_update_comment">opslaan</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	</div>




	<!-- Update Post -->
	<?php
	if (isset ($_POST["btn_update_comment"])) {

		if ($_POST["comment"] != "") {


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

					$updateComment = $conn->prepare(query: "UPDATE comments SET comment= :comment, Image_upload= :Image_upload WHERE comment_id= :comment_id");
					$updateComment->bindParam(":comment_id", $_POST["comment_id"]);
					$updateComment->bindParam(":comment", $_POST["comment"]);
					$updateComment->bindParam(":Image_upload", $target_file);
					$updateComment->execute();
					// require_once ("home.php");
	

					echo "Post added successfully with image.";
				} else {
					echo "Sorry, there was an error uploading your file.";
				}
			} else {

				// require_once ("home.php");
	
				$updateComment = $conn->prepare(query: "UPDATE comments SET comment= :comment WHERE comment_id= :comment_id");
				$updateComment->bindParam(":comment_id", $_POST["comment_id"]);
				$updateComment->bindParam(":comment", $_POST["comment"]);
				$updateComment->execute();

				echo "Post added successfully.";

			}
		}
		//! Fix refresh after update ----------------------------------------------->
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';
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


		//  ..............upload.................

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