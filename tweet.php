<?php
// session_start();
require_once ("home.php");


// $selectPost = $conn->prepare("SELECT posts.* , users.username FROM posts INNER JOIN users ON posts.user_id = users.user_id ORDER BY post_id DESC");

$selectPost = $conn->prepare("SELECT posts.* , users.username FROM posts INNER JOIN users ON posts.user_id = users.user_id WHERE posts.user_id = :user_id ORDER BY post_id DESC");
$selectPost->bindParam(":user_id", $user_id);
$selectPost->execute();




while ($row = $selectPost->fetch(PDO::FETCH_ASSOC)) {
    $post_text = $row['post_content'];
    $post_date = $row['post_date'];
    $post_img = $row['upload_image'];
    $user_name = $row['username'];
    $post_id = $row['post_id'];
    
    $selectLikes = $conn->prepare("SELECT * FROM likes WHERE post_id = :post_id");
    $selectLikes->bindParam(":post_id", $post_id);
    $selectLikes->execute();
    $likes_count = $selectLikes->rowCount();
    
    require ("tweetStructure.php");



}



?>

<body>

    <script>
        function updatePost(postText, postId, postImg) {
            console.log(postId, postText)
            const blur = document.getElementById("blur");
            blur.classList.add('active');
            document.getElementById("updatepost-id").value = postId;
            document.getElementById("updatepost-text").innerText = postText;

            let img = document.createElement('img');
            img.classList.add('s-img')
            img.src = postImg;
            document.getElementById('image-update-preview').innerHTML = ''; // Clear previous preview
            document.getElementById('image-update-preview').appendChild(img);


            document.getElementById('popup-window').classList.add('popup-show');
            document.getElementById('popup-window').classList.remove('popup-close');

            $('#updatepost-text').emojioneArea({ pickerPosition: 'bottom' });

        }




    </script>
</body>