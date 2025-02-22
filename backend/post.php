<?php
session_start();
include 'db.php';

if (isset($_POST['content'])) {
    $content = $_POST['content'];
    $image = $_FILES['image']['name'];
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($image);
    
    move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

    $user_id = $_SESSION['user_id'];
    $query = "INSERT INTO posts (user_id, content, image) VALUES ('$user_id', '$content', '$image')";
    if (mysqli_query($conn, $query)) {
        header('Location: ../frontend/index.php');
    }
}
?>
