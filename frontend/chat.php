<?php
session_start();
include '../backend/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$sender_id = mysqli_real_escape_string($conn, $_SESSION['user_id']);
$receiver_id = isset($_GET['receiver_id']) ? mysqli_real_escape_string($conn, $_GET['receiver_id']) : null;

$chat_users_query = "SELECT DISTINCT users.id, users.username, users.profile_pic 
                     FROM users 
                     JOIN chats ON users.id = chats.sender_id OR users.id = chats.receiver_id
                     WHERE users.id != '$sender_id'";
$chat_users_result = mysqli_query($conn, $chat_users_query);

$receiver_name = "Select a chat";
$receiver_pic = "../uploads/default.png";
$chat_messages = "";

if ($receiver_id) {
    $user_query = "SELECT username, profile_pic FROM users WHERE id = '$receiver_id'";
    $user_result = mysqli_query($conn, $user_query);
    $receiver_data = mysqli_fetch_assoc($user_result);
    $receiver_name = $receiver_data['username'] ?? 'Unknown User';
    $receiver_pic = !empty($receiver_data['profile_pic']) ? "../uploads/" . $receiver_data['profile_pic'] : "../uploads/default.png";

    $messages_query = "SELECT * FROM chats WHERE 
                       (sender_id = '$sender_id' AND receiver_id = '$receiver_id') 
                       OR 
                       (sender_id = '$receiver_id' AND receiver_id = '$sender_id') 
                       ORDER BY created_at ASC";
    $messages_result = mysqli_query($conn, $messages_query);

    while ($chat = mysqli_fetch_assoc($messages_result)) {
        $is_sender = $chat['sender_id'] == $sender_id;
        $chat_messages .= "
            <div class='d-flex " . ($is_sender ? "justify-content-end" : "justify-content-start") . "'>
                <div class='p-2 rounded " . ($is_sender ? "bg-primary text-white" : "bg-light text-dark") . "' style='max-width: 75%;'>
                    <strong>" . ($is_sender ? "You" : $receiver_name) . ":</strong> " . $chat['message'] . "
                </div>
            </div><br>";
    }
}

include 'header.php';
?>

<div class="container my-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card bg-dark text-white">
                <div class="card-header text-center">Chats</div>
                <div class="list-group list-group-flush">
                    <?php while ($user = mysqli_fetch_assoc($chat_users_result)): ?>
                        <a href="?receiver_id=<?php echo $user['id']; ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                            <img src="<?php echo !empty($user['profile_pic']) ? "../uploads/" . $user['profile_pic'] : "../uploads/default.png"; ?>" 
                                 class="rounded-circle me-2" width="40" height="40">
                            <?php echo $user['username']; ?>
                        </a>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>

        <!-- Chat Box -->
        <div class="col-md-9">
            <div class="card shadow-lg bg-dark text-white">
                <div class="card-header d-flex align-items-center bg-secondary">
                    <img src="<?php echo $receiver_pic; ?>" class="rounded-circle me-2" width="40" height="40">
                    <h5 class="card-title m-0"><?php echo $receiver_name; ?></h5>
                </div>
                <div class="card-body chat-container" style="height: 400px; overflow-y: auto; padding: 15px; background-color: #343a40;">
                    <?php echo $chat_messages ?: "<p class='text-center text-muted'>No messages yet.</p>"; ?>
                </div>
                <?php if ($receiver_id): ?>
                    <div class="card-footer bg-secondary">
                        <form method="POST" class="d-flex">
                            <textarea name="message" class="form-control me-2" placeholder="Type your message..." required></textarea>
                            <button type="submit" class="btn btn-warning">Send</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
                    