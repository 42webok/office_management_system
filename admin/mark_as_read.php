<?php 

include("theme/config.php");
session_start();

$user = $_SESSION['login_id'];
if (isset($_POST['id'])) {
    $notif_id = $_POST['id'];
    $sql = "UPDATE `notification` SET `is_read` = 1 WHERE `id` = '$notif_id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "Notification marked as read";
    }else{
        echo "Error";
    }
    
  
}



?>