<!-- including Header -->
<?php 
 include("theme/header.php");
 include("theme/config.php");
 session_start();
 if(!isset($_SESSION['name'])){
    header("location:index.php");
    exit;
}
ob_start();
?>
<?php
ini_set('post_max_size', '200M');
ini_set('upload_max_filesize', '200M');
ini_set('max_execution_time', '300'); // Optional: To handle large uploads
ini_set('memory_limit', '256M');     // Optional: Increase memory if needed
?>

<div class="wrapper">
    <!-- navbar code  -->
    <?php 
    include("theme/navbar.php");
   ?>
    <!-- navbar code  -->

    <!-- sidebar code here -->
    <?php 
	 include("theme/sidebar.php");
	?>
    <!-- sidebar code here -->
    <!-- Main content code here -->
    <div class="main-panel">
        <div class="content">
            <div class="container-fluid">
                <h4 class="page-title">Edit Task</h4>
                <?php 
                if(isset($_GET['task_id'])){
                    $edit_select = "SELECT * FROM manage_task WHERE task_id = '".$_GET['task_id']."'";
                    $edit_query = mysqli_query($conn, $edit_select);
                    $edit_row = mysqli_fetch_assoc($edit_query);
                    $task_id = $edit_row['task_id'];
                    $task_title = $edit_row['title'];
                    $task_description = $edit_row['discription'];
                    $task_employee = $edit_row['employee_id'];
                    $task_admin = $edit_row['admin_id'];
                    $task_deadline = $edit_row['deadline'];

                    $task_files = $edit_row['files'];
                    $filearray = explode("," , $task_files);
                
              
                ?>

                <div class="row p-3">
                    <div class="card shadow-lg p-4 w-100">
                        <h5 class="mb-4 text-dark">Edit Task</h5>
                        <form action="" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                            <input type="hidden" name="task_id" value="<?php echo $task_id ?>">
                            <!-- Title Field -->
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" value="<?php echo $task_title ?>" id="title"
                                    name="title" placeholder="Enter title" required>
                                <div class="invalid-feedback">Please provide a title.</div>
                            </div>
                            <!-- Description Field -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4"
                                    placeholder="Enter description" required><?php echo $task_description ?></textarea>
                                <div class="invalid-feedback">Please provide a description.</div>
                            </div>
                            <!-- Select Employee -->
                            <div class="mb-3">
                                <div>
                                    <label for="employee" class="form-label">Select Employee</label>
                                </div>
                                <select class="form-select form-control" id="employee" name="employee" required>

                                    <?php 
                                    $selected = '';
                                    $employee = "SELECT * FROM users WHERE role='0'";
                                    $result_employee = mysqli_query($conn, $employee);      
                                    while($row_employee = mysqli_fetch_assoc($result_employee)){
                                        if($row_employee['id'] == $task_employee) {
                                            $selected = 'selected';
                                        }
                                        else{
                                            $selected = '';
                                        }
                                        echo '<option value="'.$row_employee['id'].'" class="'.$selected.'">'.$row_employee['name'].'</option>';
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">Please select an employee.</div>
                            </div>
                            <!-- Select Owner -->
                            <div class="mb-3">
                                <div>
                                    <label for="owner" class="form-label">Select Owner</label>
                                </div>
                                <select class="form-select form-control" id="owner" name="owner" required>
                                    <?php        
                                    $admin = "SELECT * FROM users WHERE role='1'";
                                    $result_admin = mysqli_query($conn, $admin);
                                    while($row_admin = mysqli_fetch_assoc($result_admin)){
                                        if($row_admin['id'] == $task_admin) {
                                            $selected = 'selected';
                                        }
                                        else{
                                            $selected = '';
                                        }
                                        echo '<option value="'.$row_admin['id'].'">'.$row_admin['name'].'</option>';
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">Please select an owner.</div>
                            </div>
                            <!-- Deadline Date -->
                            <div class="mb-3">
                                <label for="deadline" class="form-label">Deadline</label>
                                <input type="date" class="form-control" value="<?php echo $task_deadline; ?>"
                                    id="deadline" name="deadline" required>
                                <div class="invalid-feedback">Please select a deadline date.</div>
                            </div>
                            <!-- previous files -->
                            <div class="mb-3">
                                <label class="form-label">Previously Uploaded Files:</label>
                                <ul>
                                    <?php for ($i = 0; $i < count($filearray); $i++): ?>
                                    <li>
                                        <a href="<?= $filearray[$i] ?>" name="not_del_files" target="_blank"><?= $filearray[$i] ?></a>
                                        <input type="checkbox" name="delete_files[]" value="<?= $filearray[$i] ?>">
                                        <input type="hidden" name="not_deleted_files[]" value="<?= $filearray[$i] ?>">
                                        Delete
                                    </li>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                            <!-- File Upload -->
                            <div class="mb-3">
                                <label for="files" class="form-label">Choose Files</label>
                                <input type="file" class="form-control" id="files" name="files[]" multiple required>
                                <div class="invalid-feedback">Please upload at least one file.</div>
                            </div>
                            <!-- Submit Button -->
                            <div>
                                <button type="submit" name="add_task" class="btn btn-info">Submit</button>
                            </div>
                        </form>

                    </div>
                </div>
                <?php 
            }
            else{
                echo "NO Record Found !";
              }
            ?>
            </div>
        </div>

        <!-- footer code here -->
        <?php 
		  include("theme/footer.php");
		 ?>
        <!-- footer code here -->
    </div>
    <!-- Main content code here -->
</div>
</div>



<script>
// Bootstrap 5 form validation
(() => {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();
</script>



<?php 
	include("theme/script.php");	
?>




<?php 
if(isset($_POST['add_task'])){
       
    $filePath = '';

        if (!empty($_POST['delete_files'])) {
            for ($i = 0; $i < count($_POST['delete_files']); $i++) {
                $fileToDelete = $_POST['delete_files'][$i];
                // echo $fileToDelete . "<br>";
                $filePath = $fileToDelete;
                // echo $filePath . "<br>";
                if (file_exists($filePath)) {
                    unlink($filePath); 
                }
            }
        }
       $exist_file = [];
       $not_del = $_POST['not_deleted_files'];
        for($d = 0; $d < count($not_del); $d++){
            if($not_del[$d] != $filePath){
                array_push($exist_file , $not_del[$d]);
            }
        }
       
        // echo "<pre>";
        // print_r($exist_file);

        $combinedArray = [];

    $title = $_POST['title'];
    $description = $_POST['description'];
    $employee = $_POST['employee'];
    $owner = $_POST['owner'];
    $deadline = $_POST['deadline'];

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
    $combinedArray = array_merge_recursive($exist_file , $filePath);
    $filePathsString = implode(',' , $combinedArray);

    $query = "UPDATE manage_task SET title = '$title' , discription = '$description' , employee_id = '$employee' , admin_id = '$owner' , deadline = '$deadline' , files = '$filePathsString'";
    $result = mysqli_query($conn, $query);
    if($result){
        header("location: manage_tasks.php?status=update_success");
    }else{
        header("location: manage_tasks.php?status=update_failed");
    }



}
ob_end_flush(); 
?>