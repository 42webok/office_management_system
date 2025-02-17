<?php 
include("theme/config.php");
session_start();
if(!isset($_SESSION['name'])){
    header("location:index.php");
    exit;
}
if(isset($_POST['setting'])){
    $filename = $_FILES['logo']['name'];
    
    $tempname = $_FILES['logo']['tmp_name'];

    $timestamp = time();
    $newfilename = $timestamp . '.' . $filename;

    $image = "SELECT logo FROM setting WHERE id = 1";
    $results = mysqli_query($conn, $image);
    $rows = mysqli_fetch_assoc($results);
    if(empty($filename)){
        $newfilename = $rows['logo'];
    }

    $folder = "uploads/" . $newfilename;

    move_uploaded_file($tempname, $folder);
    
    $footer = mysqli_real_escape_string($conn , $_POST['footer']);
    $companey = mysqli_real_escape_string($conn , $_POST['companey']);
    $url = mysqli_real_escape_string($conn , $_POST['url']);
    $protected_name = mysqli_real_escape_string($conn , $newfilename);

    $sql = "UPDATE `setting` SET logo = '$protected_name' , footer = '$footer' , companey = '$companey' , url = '$url' WHERE id = 1";
    $result = mysqli_query($conn, $sql);
    
    if($result){
        header('Location: setting.php?status=success');
    }else{
        header('Location: setting.php?status=error');
    }

    exit;

}

?>