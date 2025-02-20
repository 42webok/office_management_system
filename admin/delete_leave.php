
<?php 
 include("theme/config.php");
 session_start();
 if(!isset($_SESSION['name'])){
    header("location:index.php");
    exit;
}
$user_id = $_SESSION['login_id'];

if(isset($_GET['id'])){
    $sql = "DELETE FROM leave_request WHERE id = '".$_GET['id']."'";
    $resultData = mysqli_query($conn, $sql);
    if($resultData){
        header("location: get_leave.php?status=delete_success");
        // exit;
    }else{
        header("location: get_leave.php?status=delete_failed");
    }
}

 ?>
