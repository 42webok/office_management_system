<?php 

include("theme/config.php");
session_start();

$user = $_SESSION['login_id'];

if(isset($user)){
    $sql = "SELECT * FROM `notification` WHERE user_id = '$user' AND is_read = 0";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    if($count > 0){
        $arr = [];
    while($row = mysqli_fetch_assoc($result)){
        $arr[] = $row;
    }
    echo json_encode($arr);
    }else{
        echo json_encode(array(
            "status" => "false"
        ));
    }
  
}



?>