<?php
require ("../home.php");
if (isset ($_POST["btn_update_comment"])) {

    if ($_POST["comment_text"] != "") {
        $post_id = $_POST['post_id'];

        if (isset ($_FILES["image-update"]) && $_FILES["image-update"]["error"] == 0) {

            $target_up = "commentsImages/";
            $target_file = $target_up . basename($_FILES["image-update"]["name"]);

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
                echo "comment updated successfully with image.";
            } else {
                echo "comment, there was an error uploading your file.";
            }
        } else {
            $updateComment = $conn->prepare(query: "UPDATE comments SET comment= :comment WHERE comment_id= :comment_id");
            $updateComment->bindParam(":comment_id", $_POST["comment_id"]);
            $updateComment->bindParam(":comment", $_POST["comment_text"]);
            $updateComment->execute();

            echo "comment updated successfully.";
        }
    }
    $location = "../comment.php?id=$post_id";
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=' . $location . '">';
    // header("location:comment.php?id=$post_id");
}
?>