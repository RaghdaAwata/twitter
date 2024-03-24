<?php
require_once ("home.php");
$_GET['post_id'] = $post_id;
echo ($post_id);
echo ($post_id);
echo ($post_id);
?>

<body>
    <div class="iconBack">
        <a href="function.php">
            <img src="back.png" alt="back" width="30" height="30" />
        </a>
    </div>
    <div class="grid-container" id="blur">
        <div class="sidebar">
        </div>
        <div class="main">
            <p class="page_titel">comment</p>
            <div class="tweet_box tweet_add">
                <div class="tweet_left">
                    <img src="RAlogo.jpeg" alt="">
                </div>

                <div class="tweet_body">

                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                        <textarea name="comment_text" id="update" cols="100%" rows="3"
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
                            <p>
                                <?php echo $post_id ?>
                            </p>
                            <input value="<?php echo $post_id ?>" name="lolo" hidden>
                            <button class="btn btn-outline-primary" type="submit" name="btn_add_comment"><i
                                    class="fa-solid fa-paper-plane"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<?php
// die("test");
require_once ("home.php");
if (isset ($_POST["btn_add_comment"])) {
    echo ('hello');
    $post_id = $_POST["lolo"];
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

            $insertcomment = $conn->prepare("INSERT INTO comments (comment, Image_upload, post_id, commenttime) VALUES (:comment,:upload_image, :post_id, now())");
            // $insertPost->bindParam(":user_id", $user_id);
            $insertcomment->bindParam(":comment", $comment);
            $insertcomment->bindParam(":upload_image", $target_file);
            $insertcomment->bindParam(":post_id", $post_id);
            $insertcomment->execute();



            echo "Comment added successfully with image.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {

        // require_once ("home.php");

        $insertcomment = $conn->prepare("INSERT INTO comments (comment, post_id, commenttime) VALUES (:comment, :post_id, now())");
        $insertcomment->bindParam(":comment", $comment);
        $insertcomment->bindParam(":post_id", $post_id);
        $insertcomment->execute();

        echo "Comment added successfully.";

    }
    // echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';
    if ($insertcomment) {
        header("location:comment.php?id=$post_id");
        exit;
    } else {
        echo "Er is een fout opgetreden bij het verwijderen van de post.";
    }
}
?>