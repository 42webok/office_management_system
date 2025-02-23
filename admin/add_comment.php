<?php 
include("theme/config.php");
session_start();

if (!isset($_SESSION['name'])) {
    header("location:index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST['post_id'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']); // Ensure proper sanitization
    $user_id = $_SESSION['login_id'];

    $sql = "INSERT INTO office_post_comments (post_id, user_id, comment_text) VALUES ('$post_id', '$user_id', '$comment')";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        echo "success";
        exit;
    } else {
        echo "error";
    }
}
?>
