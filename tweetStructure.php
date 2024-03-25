<?php
$_GET['post_content'] = $post_text;
$_GET['post_date'] = $post_date;
$_GET['upload_image'] = $post_img;
$_GET['username'] = $user_name;


?>
<div class="tweet_box">
    <div class="tweet_left"><img src="RAlogo.jpeg"></div>

    <div class="tweet_body">
        <div class="tweet_header">
            <p class="tweet_name">
                <?php echo $user_name; ?>
            </p>
            <p class="tweet_username"> @code</p>
            <p class="tweet_date">
                <?php echo $post_date = date('H d'), strtotime($post_date); ?>
            </p>
        </div>

        <p class="tweet_text">
            <?php echo $post_text; ?>
        </p>
        <?php
        if ($post_img) {
            ?>
            <img class="post-img" id="uploadpost-img" src='<?php echo $post_img ?>'>
            <?php
        }
        ?>

        <!-- <div class="tweet_icons">

            <a href="" class="like-btn"><i class="fa-regular fa-heart"></i></a>
            <span class="like-count">0</span>
            <a href="comment.php?id=<?php echo $row['post_id']; ?>"><i class="fa-regular fa-comment"></i></a>
        </div> -->

        <div class="tweet_icons">
            <form class="like-form" method="post" action="">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            <button type="submit" class="like-btn" name="like_btn"><i class="fa-regular fa-heart"></i></button>
                <span class="like-count">0</span>
                <a href="comment.php?id=<?php echo $row['post_id']; ?>"><i class="fa-regular fa-comment"></i></a>
            </form>
        </div>

    </div><br><br>

    <!-- Delete / Edit-->
    <div class="tweet_del">
        <div class="dropdown">
            <button class="dropbtn"><span class="fa fa-ellipsis-h"></span></button>
            <div class="dropdown-content">
                <a href="javascript:void(0);"
                    onclick="updatePost('<?php echo $row['post_content']; ?>', '<?php echo $row['post_id']; ?>', '<?php echo $row['upload_image']; ?>')"><i
                        class="fa-regular fa-pen-to-square edit"></i><span> edit</span></a>
                <a href="deleteTweet.php?del=<?php echo $row['post_id']; ?>"><i
                        class="fa-solid fa-xmark delete"></i><span> delete</span></a>
            </div>

        </div>
    </div>
</div>
<?php
if (isset ($_POST['like_btn'])) {
    // Retrieve the comment ID from the form
    $post_id = $_POST['post_id'];
    // Perform your SQL update to increment the like count for the specified comment ID
    // For demonstration purposes, let's assume you have a 'comments' table with a 'likes' column
    $sql = "UPDATE posts SET likesCount = likesCount + 1 WHERE post_id = :post_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':post_id', $post_id);
    $stmt->execute();

    // Redirect back to the page where the comment is displayed after updating the like count
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>
<script>
    // JavaScript code to handle liking comments
    document.addEventListener("DOMContentLoaded", function () {
        // Event listener for like button click
        var likeForms = document.querySelectorAll(".like-form");
        likeForms.forEach(function (form) {
            form.addEventListener("submit", function (event) {
                event.preventDefault(); // Prevent the default form submission

                // Get the comment ID and like count elements
                var commentId = form.querySelector("[name='post_id']").value;
                var likeCountElement = form.querySelector(".like-count");

                // Simulate liking action (increment like count)
                var currentLikes = parseInt(likeCountElement.textContent);
                likeCountElement.textContent = currentLikes + 1;

                // Submit the form to the server
                form.submit();
            });
        });
    });
</script>