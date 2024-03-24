<?php
require_once("home.php");
// $selectcomment = $conn->prepare("SELECT comments.* , users.username FROM comments INNER JOIN users ON comments.commentBy = users.user_id WHERE comments.commentBy = :user_id ORDER BY comment_id DESC");
$selectcomment = $conn->prepare("SELECT * FROM comments where post_id =:post_id ");
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
                    <a href="deleteComment.php?del=<?php echo $row['comment_id']; ?>"><i
                            class="fa-solid fa-xmark delete"></i><span> delete</span></a>
                </div>

            </div>
        </div>
    </div>
    <?php
    if (isset ($_GET["del"])) {
        // $post_id = $_GET["post"];
        $Del_ID = $_GET["del"];

        $selectcomment = $conn->prepare("SELECT * FROM comments where comment_id= :comment_id");
        $selectcomment->bindParam(":comment_id", $Del_ID);
        $selectcomment->execute();
        $row = $selectcomment->fetch(PDO::FETCH_ASSOC);
        $post_id = $row['post_id'];
        $comment_img = $row['Image_upload'];


        //! Remove the image -------------------------------------------------->
        // $Img_Url = $_GET['url'];
        // unlink($Img_Url);
        //! Remove the image -------------------------------------------------->

        $deletecomment = $conn->prepare("DELETE FROM comments WHERE comment_id = :comment_id");
        $deletecomment->bindParam(":comment_id", $Del_ID);
        // $deletecomment->bindParam(":post_id", $post_id);
        // $selectPost->bindParam(":post_text",$post_text); 
        $deletecomment->execute();

        // echo $post_id;

        if ($deletecomment) {
            // header("location:comment.php");
            header("location:comment.php?id=$post_id");
            // header("Refresh:0");

            // echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';

            exit;
        } else {
            echo "Er is een fout opgetreden bij het verwijderen van de post.";
        }
    } ?>
<?php
}
?>