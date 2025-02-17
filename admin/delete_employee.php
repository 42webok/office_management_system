<?php 

include("theme/config.php");

$sql = "DELETE FROM `users` WHERE `id` = '".$_GET['emp_id']."'";
$result = mysqli_query($conn , $sql);
if($result){
    header("location: manage_employee.php?status=delete_success");
}else{
    header("location: manage_employee.php?status=delete_error");
}


?>