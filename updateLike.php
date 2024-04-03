<?php
require ("home.php");
if (isset($_POST['liked'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];
    $insertLike = $conn->prepare(query: "INSERT INTO likes (user_id, post_id) VALUES (:user_id, :post_id)");
    $insertLike->bindParam(":post_id", $post_id);
    $insertLike->bindParam(":user_id", $user_id);
    $insertLike->execute();
}
if (isset($_POST['unliked'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];

    $deleteLike = $conn->prepare(query: "DELETE FROM likes WHERE user_id=:user_id AND post_id=:post_id");
    $deleteLike->bindParam(":post_id", $post_id);
    $deleteLike->bindParam(":user_id", $user_id);
    $deleteLike->execute();
}
?>