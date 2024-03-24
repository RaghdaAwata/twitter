<?php 
    $_GET['post_content']= $post_text;
    $_GET['post_date']= $post_date;
    $_GET['upload_image']=$post_img ;
    $_GET['username']= $user_name; 


?>
<div class="tweet_box">
        <div class="tweet_left"><img src="RAlogo.jpeg"></div>

        <div class="tweet_body">
            <div class="tweet_header">
                <p class="tweet_name"> <?php echo $user_name;  ?></p>
                <p class="tweet_username"> @code</p>
                <p class="tweet_date">
                    <?php echo $post_date = date('H d'), strtotime($post_date); ?>
                </p>
            </div>

            <p class="tweet_text">
                <?php echo $post_text; ?>
            </p>
            <?php
            if($post_img) {
                ?>
                <img class="post-img" id="uploadpost-img" src='<?php echo $post_img ?>'>
            <?php   
        }
        ?>

            <div class="tweet_icons">

                <a href=""><i class="fa-regular fa-heart"></i></a>
                <a href="comment.php?id=<?php echo $row['post_id']; ?>"><i class="fa-regular fa-comment"></i></a>
            </div>
           
        </div><br><br>
        
        <!-- Delete / Edit-->
        <div class="tweet_del">
            <div class="dropdown">
                <button class="dropbtn"><span class="fa fa-ellipsis-h"></span></button>
                <div class="dropdown-content">
                    <a href="javascript:void(0);"
                        onclick="updatePost('<?php echo $row['post_content']; ?>', '<?php echo $row['post_id']; ?>', '<?php echo $row['upload_image']; ?>')"><i class="fa-regular fa-pen-to-square edit"></i><span> edit</span></a>
                    <a href="deleteTweet.php?del=<?php echo $row['post_id']; ?>"><i class="fa-solid fa-xmark delete"></i><span> delete</span></a>
                </div>
       
            </div>
        </div>
    </div>
