<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../frontend/login.php');
    exit();
}

include 'db.php';
$user_id = $_SESSION['user_id'];

$receiver_id = $_POST['receiver_id'];
$message = mysqli_real_escape_string($conn, $_POST['message']);

$query = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ('$user_id', '$receiver_id', '$message')";
if (mysqli_query($conn, $query)) {
    echo "Message sent successfully!";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
