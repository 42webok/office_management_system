<!-- Status change php here -->
<?php  
 include("theme/config.php");
 session_start();
 if(!isset($_SESSION['name'])){
    header("location:index.php");
    exit;
}


 if(isset($_POST['update_status'])){
    $status_id = $_POST['status_id'];
    $status_up = $_POST['status_up'];

    $sql_update  = "UPDATE leave_request SET status = '$status_up' WHERE id = '$status_id'";
    $result_update = mysqli_query($conn, $sql_update);
    if($result_update){
        header("Location: leaveApproveReject.php");
        exit;
    }
 }
 
 
 ?>