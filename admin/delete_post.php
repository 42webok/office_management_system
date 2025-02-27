<!-- including Header -->
<?php 
 include("theme/config.php");
 session_start();
 if(!isset($_SESSION['name'])){
    header("location:index.php");
    exit;
}
if($_SESSION['role'] == 0){
    header("location:index.php");
    exit;
 }

if(isset($_GET['post_id'])){
    $post_id = $_GET['post_id'];
    $delete_post = "DELETE FROM office_posts WHERE id = '$post_id'";
    $delete_post_result = mysqli_query($conn, $delete_post);
    if($delete_post_result){
        header("Location: manage_post.php?status=delete_success");
        exit;
    }else{
        header("Location: manage_post.php?status=update_success");
    }
    
}else{
    header("location:index.php");
    exit;
}
?>