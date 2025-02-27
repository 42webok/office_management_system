
<?php 

include("theme/config.php");
session_start();
if(!isset($_SESSION['name'])){
   header("location:index.php");
   exit;
}
if($_SESSION['role'] == 0){
    header("location:index.php");
    exit;
 }

if(isset($_GET['fid'])){
    $did = $_GET['fid'];
    $sql = "SELECT emp_files , employee_id FROM manage_task WHERE employee_id = '$did'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $files = $row['emp_files'];
    $file_paths = explode(',', $files);
    $zip = new ZipArchive();
    $zip_filename = 'task_files.zip';

    if($zip->open($zip_filename, ZipArchive::CREATE) !== TRUE){
        header("location: manage_tasks.php");
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
        header("location: manage_tasks.php");
    }
    
exit;
}

?>