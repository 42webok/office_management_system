<!-- including Header -->
<?php 
 include("theme/config.php");
 session_start();
 if(!isset($_SESSION['name'])){
    header("location:index.php");
    exit;
}

if (isset($_GET['id'])) {
    $attendance_id = $_GET['id'];
    $query = "DELETE FROM attendance WHERE id = '$attendance_id'";
    mysqli_query($conn, $query);
}

header("Location: manage_attendance.php");
exit;


?>