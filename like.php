<?php
require_once ("home.php");
session_start();

// Assuming $conn is your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset ($_POST["comment_id"])) {
        $comment_id = $_POST["comment_id"];
        $user_id = $_SESSION["user_id"]; // Assuming you have a user session

        // Insert a record into the likes table
        $insert_like = $conn->prepare("INSERT INTO likes (user_id,comment_id) VALUES (:user_id,:comment_id)");
        $insert_like->bindParam(":user_id", $user_id);
        $insert_like->bindParam(":comment_id", $comment_id);
        $insert_like->execute();

        // Optionally, you can handle error checking and response here
        // For example, you can return a success or error message to the client
        if ($insert_like) {
            echo json_encode(["success" => true, "message" => "Comment liked successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to like comment."]);
        }
        exit; // Stop further execution
    }
}
?>