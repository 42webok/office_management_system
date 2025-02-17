
<?php 
 include("theme/config.php");
 session_start();
 if(!isset($_SESSION['name'])){
    header("location:index.php");
    exit;
}
?>


<?php 

if(isset($_POST['data_submit'])){
    // echo $_POST['data_submit'];
    $task_id = $_POST['tsk_id'];
    // echo $task_id;
    $files = $_FILES['files']['name'];
    $files_temp = $_FILES['files']['tmp_name'];
    $filePath = [];
    if (!empty($files)) {
        for ($i = 0; $i < count($files); $i++) {
            if (!empty($files[$i])) { 
                $file = $files[$i];
                $file_temp = $files_temp[$i];
    
                $newFileName = "uploads/" . time() . "_" . $file;
    
                if (move_uploaded_file($file_temp, $newFileName)) {
                    $filePath[] = $newFileName;
                } else {
                    $filePath[] = "Error uploading file: " . $file;
                }
            } else {
                $filePath[] = "No file selected";
            }
        }
    } else {
        $filePath[] = "No files uploaded.";
    }
    $filePathsString = implode(',' , $filePath);

    $sql = "UPDATE manage_task SET emp_files = '$filePathsString' WHERE task_id = '$task_id'";
    // echo $sql;
    // exit;
    $result = mysqli_query($conn, $sql);
    if($result){
        header("location: my_tasks.php?status=success");
    }else{
        header("location: my_tasks.php?status=error");
    }
}


?>
