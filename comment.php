<?php
require_once ("home.php");

session_start();
$post_id = $_GET['id'];

if (isset ($_GET['id'])) {
    $post_id = $_GET['id'];


    // $comment_id = $_SESSION['comment_id'];

    $selectPost = $conn->prepare("SELECT posts.*, users.username FROM posts INNER JOIN users WHERE post_id = :post_id");

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
    $post_id = $_POST['post_id'];
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

            $insertcomment = $conn->prepare("INSERT INTO comments (comment,Image_upload, post_id, commenttime) VALUES (:comment, :upload_image, :post_id, now())");
            // $insertPost->bindParam(":user_id", $user_id);
            $insertcomment->bindParam(":comment", $comment);
            $insertcomment->bindParam(":upload_image", $target_file);
            $insertcomment->bindParam(":post_id", $post_id);
            $insertcomment->execute();



            echo "Post added successfully with image.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {

        // require_once ("home.php");

        $insertcomment = $conn->prepare("INSERT INTO comments (comment, post_id, commenttime) VALUES (:comment, :post_id, now())");
        $insertcomment->bindParam(":comment", $comment);
        $insertcomment->bindParam(":post_id", $post_id);
        $insertcomment->execute();

        echo "comment added successfully.";

    }
    // echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';
    header("location:comment.php?id=$post_id");
}
?>

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

                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
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
                        <input hidden class="img-input" name="post_id" value="<?php echo $post_id ?>">
                        <button class="btn btn-outline-primary" type="submit" name="btn_add_comment"><i
                                class="fa-solid fa-paper-plane"></i></button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
// $selectcomment = $conn->prepare("SELECT comments.* , users.username FROM comments INNER JOIN users ON comments.commentBy = users.user_id WHERE comments.commentBy = :user_id ORDER BY comment_id DESC");
$selectcomment = $conn->prepare("SELECT * FROM comments where post_id= :post_id");
$selectcomment->bindParam(":post_id", $post_id);
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
                    <a href="comment.php?del=<?php echo $row['comment_id']; ?>"><i
                            class="fa-solid fa-xmark delete"></i><span> delete</span></a>
                </div>

            </div>
        </div>
    </div>
<?php
    if (isset ($_GET["del"])) {
        $Del_ID = $_GET["del"];
        $selectcomment = $conn->prepare("SELECT * FROM comments where comment_id= :comment_id");
        $selectcomment->bindParam(":comment_id", $Del_ID);
        $selectcomment->execute();
        $row = $selectcomment->fetch(PDO::FETCH_ASSOC);
        $post_id = $row['post_id'];
        $comment_img = $row['Image_upload'];


        $deletecomment = $conn->prepare("DELETE FROM comments WHERE comment_id = :comment_id");
        $deletecomment->bindParam(":comment_id", $Del_ID);
        // $selectPost->bindParam(":post_text",$post_text); 
        $deletecomment->execute();
        
        //! Remove the image -------------------------------------------------->
        unlink($comment_img);
        //! Remove the image -------------------------------------------------->

        // header("location:comment.php?id=$post_id");
        $location = "comment.php?id=$post_id";
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=' . $location . '">';
    }
?>
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
                    <input type="hidden" id='updatecomment-id' name='comment_id'></input>
                    <input type="hidden" value="<?php echo $post_id ?>" name='post_id'></input>
                    <textarea name="comment_text" id="updatecomment-text" cols="100%" rows="3"
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

    if ($_POST["comment_text"] != "") {
        // $comment = $_POST['comment_text'];
        // $comment_id = $_POST['comment_id'];
        $post_id = $_POST['post_id'];
        echo ($post_id);

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
                $updateComment->bindParam(":comment", $_POST["comment_text"]);
                $updateComment->bindParam(":Image_upload", $target_file);
                $updateComment->execute();
                // require_once ("home.php");


                echo "comment added successfully with image.";
            } else {
                echo "comment, there was an error uploading your file.";
            }
        } else {

            // require_once ("home.php");

            $updateComment = $conn->prepare(query: "UPDATE comments SET comment= :comment WHERE comment_id= :comment_id");
            $updateComment->bindParam(":comment_id", $_POST["comment_id"]);
            $updateComment->bindParam(":comment", $_POST["comment_text"]);
            $updateComment->execute();

            echo "Post added successfully.";

        }
    }
    $location = "comment.php?id=$post_id";
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=' . $location . '">';
    // header("location:comment.php?id=$post_id");
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
<script type="text/javascript">
    $('#update').emojioneArea({ pickerPosition: 'bottom' });

</script>
<script>
    function updateComment(comment, commentId, commentImg) {
        // console.log(postId, postText)
        const blur = document.getElementById("blur");
        blur.classList.add('active');
        document.getElementById("updatecomment-id").value = commentId;
        document.getElementById("updatecomment-text").innerText = comment;

        let img = document.createElement('img');
        img.classList.add('s-img')
        img.src = commentImg;
        document.getElementById('image-update-preview').innerHTML = ''; // Clear previous preview
        document.getElementById('image-update-preview').appendChild(img);


        document.getElementById('popup-window').classList.add('popup-show');
        document.getElementById('popup-window').classList.remove('popup-close');

        $('#updatecomment-text').emojioneArea({ pickerPosition: 'bottom' });

    }




</script>