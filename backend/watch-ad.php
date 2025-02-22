<?php
session_start();
include 'db.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "UPDATE users SET ad_watched = 1 WHERE id = '$user_id'";
    mysqli_query($conn, $query);
    echo "Ad watched!";
}
?>
