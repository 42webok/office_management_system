<?php 

include("theme/config.php");
session_start();
if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($conn , $_POST['email']);
    $password = mysqli_real_escape_string($conn , md5($_POST['password']));

    $sql = "SELECT * FROM users WHERE email = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);
    
    $row = mysqli_fetch_assoc($result);
    $_SESSION['login_id'] = $row['id'];
    $_SESSION['name'] = $row['name'];
    $_SESSION['role'] = $row['role'];


    if(mysqli_num_rows($result) > 0) {
        header("location: dashboard.php?status=login_success");
    }else{
        header("location: index.php?status=login_failed");
    }
}

?>