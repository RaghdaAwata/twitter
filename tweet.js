
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