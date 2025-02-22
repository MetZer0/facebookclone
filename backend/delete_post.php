<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../frontend/login.php');
    exit();
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];

    // ตรวจสอบว่าโพสต์ที่เราจะลบนั้นเป็นของผู้ใช้ที่ล็อกอินอยู่หรือไม่
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM posts WHERE id = '$post_id' AND user_id = '$user_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // ลบโพสต์จากฐานข้อมูล
        $delete_query = "DELETE FROM posts WHERE id = '$post_id'";
        if (mysqli_query($conn, $delete_query)) {
            // ลบสำเร็จ
            header('Location: ../frontend/profile.php');
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Post not found or you don't have permission to delete it.";
    }
}
?>

