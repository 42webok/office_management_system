<!-- including Header -->
<?php 
 include("theme/config.php");
  
 session_start();

 if(!isset($_SESSION['name'])){
    header("location:index.php");
    exit;
}

 if(isset($_GET['task_id'])){
    $sql = "DELETE FROM `manage_task` WHERE `task_id` = '".$_GET['task_id']."'";
    $result = mysqli_query($conn, $sql);
    if($result){
        header("location: manage_tasks.php?status=delete_success");   
    }else{
        header("location: manage_tasks.php?status=delete_error");   
    }
 }
 ?>