<!-- including config -->
<?php 
 include("theme/config.php");
 session_start();
 if(!isset($_SESSION['name'])){
    header("location:index.php");
    exit;
}
$user_id = $_SESSION['login_id'];

if(isset($_POST['submit_request'])){
    $user_id = $_POST['user_id'];
    $leave_type = mysqli_real_escape_string($conn , $_POST['leave_type']);
    $reason = mysqli_real_escape_string($conn , $_POST['reason']);
    $start_date = mysqli_real_escape_string($conn , $_POST['start_date']);
    $end_date = mysqli_real_escape_string($conn , $_POST['end_date']);

    $sql = "INSERT INTO leave_request(user_id , reason , leave_type , start_date , end_date) VALUES ($user_id , '$reason' , '$leave_type' , '$start_date' , '$end_date')";
    $result = mysqli_query($conn, $sql);
    if($result){
        header("location: get_leave.php?status=success");
    }else{
        header("location: get_leave.php?status=error");
    }
}






 ?>
