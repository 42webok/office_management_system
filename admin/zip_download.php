
<?php 

include("theme/config.php");
session_start();
if(!isset($_SESSION['name'])){
   header("location:index.php");
   exit;
}

if(isset($_GET['did'])){
    $did = $_GET['did'];
    $sql = "SELECT files , employee_id FROM manage_task WHERE employee_id = '$did'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $files = $row['files'];
    $file_paths = explode(',', $files);
    $zip = new ZipArchive();
    $zip_filename = 'task_files.zip';

    if($zip->open($zip_filename, ZipArchive::CREATE) !== TRUE){
        header("location: my_task.php?status=download_fail");
        exit;
    }
    else{
        foreach ($file_paths as $file_path) {
            $full_path = $file_path; 
            if(file_exists($full_path)){
                $zip->addFile($full_path, basename($file_path)); 
            }
        }
        $zip->close();
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $zip_filename . '"');
        readfile($zip_filename);
        unlink($zip_filename);
        header("location: my_task.php?status=download_success");
    }
    
exit;
}

?>