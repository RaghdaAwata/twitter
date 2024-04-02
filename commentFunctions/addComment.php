<?php
require ("../home.php");
if (isset ($_POST["btn_add_comment"])) {

    $comment = $_POST["comment_text"];
    $post_id = $_POST['post_id'];
    if (isset ($_FILES["image"]) && $_FILES["image"]["error"] == 0) {

        $target_dir = "commentsImages/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);

        $name = $_FILES["image"]["name"];
        $tmp = explode('.', $name);
        $file_extension = end($tmp);
        $milliseconds = floor(microtime(true) * 1000);
        $target_file = $target_dir . $milliseconds . $name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {

            $insertcomment = $conn->prepare("INSERT INTO comments (comment, Image_upload, post_id, commenttime) VALUES (:comment, :upload_image, :post_id, now())");
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
        $insertcomment = $conn->prepare("INSERT INTO comments (comment, post_id, commenttime) VALUES (:comment, :post_id, now())");
        $insertcomment->bindParam(":comment", $comment);
        $insertcomment->bindParam(":post_id", $post_id);
        $insertcomment->execute();
        echo "comment added successfully.";
    }
    $location = "../comment.php?id=$post_id";
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=' . $location . '">';
}
?>