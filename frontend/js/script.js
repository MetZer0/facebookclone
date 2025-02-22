//$(document).ready(function() {
    //$("#watch-ad").click(function() {
      //  $.post("../backend/watch-ad.php", function(data) {
       //     $("#ad-banner").hide();
       // });
   // });
//});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".like-btn").forEach(button => {
        button.addEventListener("click", function () {
            let postId = this.getAttribute("data-post-id");
            let likeCount = this.querySelector(".like-count");

            fetch("../backend/like.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "post_id=" + postId
            })
            .then(response => response.json())
            .then(data => {
                likeCount.textContent = data.like_count;
            });
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".like-btn").forEach(button => {
        button.addEventListener("click", function () {
            let postId = this.getAttribute("data-post-id");
            let likeCount = this.querySelector(".like-count");

            fetch("../backend/like.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "post_id=" + postId
            })
            .then(response => response.json())
            .then(data => {
                likeCount.textContent = data.like_count;
            });
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".like-btn").forEach(button => {
        button.addEventListener("click", function () {
            let postId = this.getAttribute("data-post-id");
            let likeCount = this.querySelector(".like-count");

            fetch("../backend/like.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "post_id=" + postId
            })
            .then(response => response.json())
            .then(data => {
                likeCount.textContent = data.like_count;
            });
        });
    });

    // Image Viewer
    let modal = document.getElementById("imageModal");
    let modalImg = document.getElementById("fullImage");
    document.querySelectorAll(".post-image").forEach(img => {
        img.addEventListener("click", function () {
            modal.style.display = "block";
            modalImg.src = this.dataset.image;
        });
    });

    document.querySelector(".close").addEventListener("click", function () {
        modal.style.display = "none";
    });
});
