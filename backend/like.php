<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post_id'])) {
    $user_id = $_SESSION['user_id'];
    $post_id = $_POST['post_id'];

    $check_like = "SELECT * FROM likes WHERE user_id = '$user_id' AND post_id = '$post_id'";
    $result = mysqli_query($conn, $check_like);

    if (mysqli_num_rows($result) > 0) {
        $query = "DELETE FROM likes WHERE user_id = '$user_id' AND post_id = '$post_id'";
    } else {
        $query = "INSERT INTO likes (user_id, post_id) VALUES ('$user_id', '$post_id')";
    }
    mysqli_query($conn, $query);

    $like_count_query = "SELECT COUNT(*) AS like_count FROM likes WHERE post_id = '$post_id'";
    $like_count_result = mysqli_query($conn, $like_count_query);
    $like_count = mysqli_fetch_assoc($like_count_result)['like_count'];

    echo json_encode(["like_count" => $like_count]);
}
?>

