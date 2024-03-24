<?php
require ("home.php");
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