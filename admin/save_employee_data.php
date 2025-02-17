<?php
include("theme/config.php");
session_start();
if(!isset($_SESSION['name'])){
   header("location:index.php");
   exit;
}

if(isset($_POST['add_employee'])){
     $name = mysqli_real_escape_string($conn , $_POST['name']);
     $email = mysqli_real_escape_string($conn , $_POST['email']);
     $phone = $_POST['phone'];
     $password = mysqli_real_escape_string($conn , md5($_POST['password']));
     $role = $_POST['options'];
      
     $check_email = "SELECT email FROM users WHERE email = '$email'";
     $result_check = mysqli_query($conn, $check_email);
      
     if(mysqli_num_rows($result_check) > 0){
        header("location: add_employee.php?status=error");
     }else{
     $sql = "INSERT INTO users(name , email , phone , password ,  role) VALUES ('$name' , '$email' , '$phone' , '$password' , '$role')";
     $result = mysqli_query($conn , $sql) or die("Error: " . mysqli_error($conn));
     if($result){
        header("location: manage_employee.php?status=success");
     }else{
        header("location: manage_employee.php?status=error");
     }
    }
}

?>