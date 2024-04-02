<?php
require ("home.php");
if (isset($_POST['liked'])) {
    echo "hi";
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];
    echo $user_id;
    echo $post_id;

    $insertLike = $conn->prepare(query: "INSERT INTO likes (user_id, post_id) VALUES (:user_id, :post_id)");
    $insertLike->bindParam(":post_id", $post_id);
    $insertLike->bindParam(":user_id", $user_id);
    $insertLike->execute();

}
if (isset($_POST['unliked'])) {

    $like_id = $_POST['like_id'];

    $deleteLike = $conn->prepare(query: "DELETE FROM likes WHERE like_id=:like_id");
    $deleteLike->bindParam(":like_id", $like_id);
    $deleteLike->execute();

}
?>