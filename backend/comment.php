<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['post_id']) || !isset($_POST['content'])) {
    header('Location: ../frontend/index.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$post_id = $_POST['post_id'];
$content = mysqli_real_escape_string($conn, $_POST['content']);

$query = "INSERT INTO comments (post_id, user_id, content) VALUES ('$post_id', '$user_id', '$content')";
mysqli_query($conn, $query);

header("Location: ../frontend/index.php");
exit();
?>
