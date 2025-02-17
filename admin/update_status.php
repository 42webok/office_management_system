<!-- including Header -->
<?php 
 include("theme/config.php");
 session_start();
 if(!isset($_SESSION['name'])){
    header("location:index.php");
    exit;
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $task_id = $_POST['task_id'];
    $status = $_POST['status'];

    $sql = "UPDATE manage_task SET status = '$status' WHERE task_id = $task_id";

    if ($conn->query($sql)) {
        header("location: my_tasks.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
