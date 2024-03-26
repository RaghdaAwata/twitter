<?php
require ("../home.php");
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
    $deletecomment->execute();
    //! Remove the image -------------------------------------------------->
    unlink($comment_img);
    //! Remove the image -------------------------------------------------->
    if ($deletecomment) {
        // header("location:comment.php");
        header("location:../comment.php?id=$post_id");
        exit;
    } else {
        echo "Er is een fout opgetreden bij het verwijderen van de post.";
    }
} ?>