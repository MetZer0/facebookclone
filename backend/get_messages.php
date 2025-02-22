<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../frontend/login.php');
    exit();
}

include 'db.php';
$user_id = $_SESSION['user_id'];

$receiver_id = $_GET['receiver_id'];

$query = "SELECT messages.*, users.username FROM messages 
          JOIN users ON messages.sender_id = users.id
          WHERE (sender_id = '$user_id' AND receiver_id = '$receiver_id') 
          OR (sender_id = '$receiver_id' AND receiver_id = '$user_id')
          ORDER BY messages.created_at ASC";

$result = mysqli_query($conn, $query);
$messages = [];
while ($row = mysqli_fetch_assoc($result)) {
    $messages[] = $row;
}

echo json_encode($messages);
?>
