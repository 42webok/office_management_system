<!-- including Header -->
<?php 
 include("theme/header.php");
 include("theme/config.php");
 include("notification.php");
 session_start();
 if(!isset($_SESSION['name'])){
    header("location:index.php");
    exit;
}
if($_SESSION['role'] == 0){
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
                <!-- <h4 class="page-title">Add Task</h4> -->

                <div class="row p-3">
                    <div class="card shadow-lg p-4 w-100">
                        <h5 class="mb-4 text-dark">Add Task</h5>
                        <form action="" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                            <!-- Title Field -->
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    placeholder="Enter title" required>
                                <div class="invalid-feedback">Please provide a title.</div>
                            </div>
                            <!-- Description Field -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4"
                                    placeholder="Enter description" required></textarea>
                                <div class="invalid-feedback">Please provide a description.</div>
                            </div>
                            <!-- Select Employee -->
                            <div class="mb-3">
                                <div>
                                    <label for="employee" class="form-label">Select Employee</label>
                                </div>
                                <select class="form-select form-control" id="employee" name="employee" required>
                                    <option value="">Choose an employee...</option>
                                    <?php        
                                    $employee = "SELECT * FROM users WHERE role='0'";
                                    $result_employee = mysqli_query($conn, $employee);
                                    while($row_employee = mysqli_fetch_assoc($result_employee)){
                                        echo '<option value="'.$row_employee['id'].'">'.$row_employee['name'].'</option>';
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
                                <option value="">Choose an owner...</option>
                                    <?php        
                                    $admin = "SELECT * FROM users WHERE role='1'";
                                    $result_admin = mysqli_query($conn, $admin);
                                    while($row_admin = mysqli_fetch_assoc($result_admin)){
                                        echo '<option value="'.$row_admin['id'].'">'.$row_admin['name'].'</option>';
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">Please select an owner.</div>
                            </div>
                            <!-- Deadline Date -->
                            <div class="mb-3">
                                <label for="deadline" class="form-label">Deadline</label>
                                <input type="date" class="form-control" id="deadline" name="deadline" required>
                                <div class="invalid-feedback">Please select a deadline date.</div>
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
    $title = mysqli_real_escape_string($conn , $_POST['title']);
    $description = mysqli_real_escape_string($conn , $_POST['description']);
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
    $filePathsString = implode(',' , $filePath);

    $query = "INSERT INTO manage_task(title , discription , employee_id , admin_id , deadline , files) VALUES ('$title' , '$description' , '$employee' , '$owner' , '$deadline' , '$filePathsString')";
    $result = mysqli_query($conn, $query);

    if($result){
        $last_id = mysqli_insert_id($conn);
        $fetch_query = "SELECT * FROM manage_task WHERE task_id = '$last_id'";
        $fetch_result = mysqli_query($conn, $fetch_query);
        $row = mysqli_fetch_assoc($fetch_result);
        $user_id = $row['employee_id'];
        $msg = "New Task Assigned !";

        addNotification($user_id , $msg);

        header("location: manage_tasks.php?status=success");
    }else{
        header("location: manage_tasks.php?status=failed");
    }



}
ob_end_flush(); 
?>