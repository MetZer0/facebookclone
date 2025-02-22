<?php
session_start();
include '../backend/db.php';

if (!isset($_GET['user_id'])) {
    header('Location: index.php');
    exit();
}

$profile_id = $_GET['user_id'];
$query = "SELECT * FROM users WHERE id = '$profile_id'";
$result = mysqli_query($conn, $query);
$profile_user = mysqli_fetch_assoc($result);

if (!$profile_user) {
    echo "<div class='container mt-5'><h4>User not found</h4></div>";
    exit();
}

include 'header.php';
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <h3 class="card-title"><?php echo htmlspecialchars($profile_user['username']); ?>'s Profile</h3>
                </div>
            </div>

            <h4 class="mb-4">Posts by <?php echo htmlspecialchars($profile_user['username']); ?></h4>
            <?php
            $query_posts = "SELECT posts.*, 
                            (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.id) AS like_count 
                            FROM posts 
                            WHERE posts.user_id = '$profile_id' 
                            ORDER BY posts.created_at DESC";
            $result_posts = mysqli_query($conn, $query_posts);
            while ($post = mysqli_fetch_assoc($result_posts)):
                $post_id = $post['id'];
            ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <p class="card-text"><?php echo htmlspecialchars($post['content']); ?></p>
                        <?php if ($post['image']): ?>
                            <img src="../uploads/<?php echo $post['image']; ?>" class="img-fluid" alt="Post Image">
                        <?php endif; ?>
                        <div class="mt-2">
                            <button class="btn btn-outline-warning like-btn" data-post-id="<?php echo $post_id; ?>">
                                👍 <span class="like-count"><?php echo $post['like_count']; ?></span>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="../frontend/js/script.js"></script>
