<!-- including Header -->
<?php 
 include("theme/config.php");
 session_start();
 if(!isset($_SESSION['name'])){
    header("location:index.php");
    exit;
}


$user_id = $_SESSION['login_id'];
$today = date("Y-m-d");
$sql = "SELECT * FROM attendance WHERE user_id = '$user_id' AND date = '$today'";
$result = mysqli_query($conn, $sql);

$attendance  = mysqli_fetch_assoc($result);

if(isset($_POST['check_in']) && !$attendance){
    date_default_timezone_set("Asia/Karachi");
    $check_in_time = date("h:i:s");
    $insert = "INSERT INTO attendance (user_id, status, date, check_in) VALUES ('$user_id', 'Present', '$today', '$check_in_time')";
    $result = mysqli_query($conn, $insert);
    header("Location: mark_attandance.php");
    exit();
}
if(isset($_POST['check_out']) && $attendance && empty($attendance['check_out'])){
    date_default_timezone_set("Asia/Karachi");
    $check_out_time = date("h:i:s");
    $update = "UPDATE attendance SET check_out = '$check_out_time' WHERE id = '{$attendance['id']}'";
    $result = mysqli_query($conn, $update);
    header("Location: mark_attandance.php");
    exit();
}
header("Location: mark_attandance.php");

?>
