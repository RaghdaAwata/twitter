<?php
$_GET['post_content'] = $post_text;
$_GET['post_date'] = $post_date;
$_GET['upload_image'] = $post_img;
$_GET['username'] = $user_name;
$_GET['post_id'] = $post_id;
$_GET['likesCount'] = $likes_count;
$_GET['comments_count'] = $comments_count;

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



        <div class="tweet_icons">
            <?php
            $selectLike = $conn->prepare(query: "SELECT * FROM likes WHERE user_id =:user_id AND post_id= :post_id");
            $selectLike->bindParam(":post_id", $post_id);
            $selectLike->bindParam(":user_id", $user_id);
            $selectLike->execute();


            if ($selectLike->rowCount()):
                $row = $selectLike->fetch(PDO::FETCH_ASSOC);
                ?>

                <span class="unlike fa-solid fa-heart" data-id="<?php echo $post_id; ?>"
                    data-user="<?php echo $user_id; ?>"></span>
                <span class="like fa-regular fa-heart hide" data-id="<?php echo $post_id; ?>"
                    data-user="<?php echo $user_id; ?>"></span>
            <?php else: ?>
                <!-- user has not yet liked post -->
                <span class="unlike fa-solid fa-heart hide" data-id="<?php echo $post_id; ?>"
                    data-user="<?php echo $user_id; ?>"></span>
                <span class="like fa-regular fa-heart" data-id="<?php echo $post_id; ?>"
                    data-user="<?php echo $user_id; ?>"></span>
            <?php endif ?>
            <span class="likes-count">
                <?php echo $likes_count; ?>
            </span>


            <a href="comment.php?id=<?php echo $row['post_id']; ?>"><i class="fa-regular fa-comment"></i></a>


            <span class="comments-count">
                <?php echo $comments_count ?>
            </span>
        </div>


    </div><br><br>
    <!-- Delete / Edit-->
    <div class="tweet_del">
        <div class="dropdown">
            <button class="dropbtn"><span class="fa fa-ellipsis-h"></span></button>
            <div class="dropdown-content">
                <a href="javascript:void(0);"
                    onclick="updatePost('<?php echo $post_text; ?>', '<?php echo $post_id; ?>', '<?php echo $post_img; ?>')"><i
                        class="fa-regular fa-pen-to-square edit"></i><span> edit</span></a>
                <a href="deleteTweet.php?del=<?php echo $row['post_id']; ?>"><i
                        class="fa-solid fa-xmark delete"></i><span>
                        delete</span></a>
            </div>

        </div>
    </div>
</div>

<!-- <script src="jquery.min.js"></script> -->
<script>
    $(document).ready(function (e) {
        // when the user clicks on like
        $('.like').unbind().click(function () {
            let post_id = $(this).data('id');
            let user_id = $(this).data('user');
            $post = $(this);
            $.ajax({
                url: 'updateLike.php',
                type: 'post',
                data: {
                    'liked': 1,
                    'post_id': post_id,
                    'user_id': user_id
                },
                success: function (response) {
                    $post.parent().find('span.likes-count').text(parseInt($post.parent().find('span.likes-count').text()) + 1);
                    $post.addClass('hide');
                    $post.siblings().removeClass('hide');
                }
            });
        });


        // when the user clicks on unlike
        $('.unlike').unbind().click(function () {
            let post_id = $(this).data('id');
            let user_id = $(this).data('user');
            $post = $(this);
            $.ajax({
                url: 'updateLike.php',
                type: 'post',
                data: {
                    'unliked': 1,
                    'post_id': post_id,
                    'user_id': user_id
                },
                success: function (response) {
                    $post.parent().find('span.likes-count').text(parseInt($post.parent().find('span.likes-count').text()) - 1);
                    $post.addClass('hide');
                    $post.siblings().removeClass('hide');
                }
            });
        });
    });
</script>