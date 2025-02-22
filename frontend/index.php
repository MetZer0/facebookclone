<?php
session_start();
include '../backend/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'header.php';
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <form method="POST" action="../backend/post.php" enctype="multipart/form-data" class="mb-4">
                <textarea name="content" class="form-control mb-2" placeholder="What's on your mind?" required></textarea>
                <input type="file" name="image" class="form-control mb-2">
                <button type="submit" class="btn btn-warning">Post</button>
            </form>

            <?php
            $query = "SELECT posts.*, users.username FROM posts 
                      JOIN users ON posts.user_id = users.id 
                      ORDER BY posts.created_at DESC";
            $result = mysqli_query($conn, $query);
            while ($post = mysqli_fetch_assoc($result)):
                $post_id = $post['id'];
            ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="profile.php?user_id=<?php echo $post['user_id']; ?>">
                                <?php echo htmlspecialchars($post['username']); ?>
                            </a>
                        </h5>
                        <p class="card-text"><?php echo htmlspecialchars($post['content']); ?></p>
                        <p class="text-muted">Posted on: <?php echo date("F j, Y, g:i a", strtotime($post['created_at'])); ?></p>
                        <?php if ($post['image']): ?>
                            <img src="../uploads/<?php echo $post['image']; ?>" class="img-fluid post-image" data-image="../uploads/<?php echo $post['image']; ?>">
                        <?php endif; ?>

                        <div class="mt-2">
                            <button class="btn btn-outline-warning like-btn" data-post-id="<?php echo $post_id; ?>">👍 
                                <span class="like-count"><?php echo $post['like_count']; ?></span>
                            </button>
                        </div>

                        <!-- Comment Section -->
                        <div class="mt-3">
                            <h6>Comments</h6>
                            <?php
                            $comment_query = "SELECT comments.*, users.username FROM comments 
                                              JOIN users ON comments.user_id = users.id 
                                              WHERE comments.post_id = '$post_id' 
                                              ORDER BY comments.created_at ASC";
                            $comment_result = mysqli_query($conn, $comment_query);
                            while ($comment = mysqli_fetch_assoc($comment_result)):
                            ?>
                                <div class="border rounded p-2 mb-2">
                                    <strong><?php echo htmlspecialchars($comment['username']); ?>:</strong>
                                    $content = isset($_POST['content']) ? $_POST['content'] : '';
                                    <p class="text-muted small"><?php echo date("F j, Y, g:i a", strtotime($comment['created_at'])); ?></p>
                                </div>
                            <?php endwhile; ?>
                        </div>

                        <!-- Add Comment -->
                        <form method="POST" action="../backend/comment.php">
                            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                            <input type="text" name="content" class="form-control mt-2" placeholder="Write a comment..." required>
                            <button type="submit" class="btn btn-sm btn-outline-secondary mt-1">Comment</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<!-- Image Viewer -->
<div id="imageModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="fullImage">
</div>

<?php include 'footer.php'; ?>

<script src="../frontend/js/script.js"></script>
