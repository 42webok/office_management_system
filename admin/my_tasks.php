<!-- including Header -->
<?php 
 include("theme/header.php");
 ob_start();
 session_start();
 if(!isset($_SESSION['name'])){
    header("location:index.php");
    exit;
}
$user_id = $_SESSION['login_id'];
 ?>
<?php
$status = isset($_GET['status']) ? $_GET['status'] : '';
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
                <h4 class="page-title">My Tasks</h4>

                <div class="row p-3">
                    <div class="card w-100">
                        <div class="card-header d-flex justify-content-between align-items-center ">
                            <div class="card-title">View Tasks</div>
                            <!-- <a href="" class="text-decoration-none">
                                <div class="btn bg-info text-light">Add Task</div>
                            </a> -->
                        </div>
                        <table class="table table-bordered table-head-bg-info table-bordered-bd-info mt-4">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">#</th>
                                    <th scope="col" class="text-center">Title</th>
                                    <th scope="col" class="text-center">Assign To</th>
                                    <th scope="col" class="text-center">Assign By</th>
                                    <th scope="col" class="text-center">Deadline</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Files</th>
                                    <th scope="col" class="text-center">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                     include("theme/config.php");
                                     $sql = "SELECT * FROM manage_task WHERE employee_id = '$user_id'";
                                     $result = mysqli_query($conn, $sql);
                                     if(mysqli_num_rows($result) > 0){
                                        $count = 1;
                                     while($row = mysqli_fetch_assoc($result)){
                                    ?>
                                <tr>
                                    <td class="text-center"><?php echo $count ?></td>
                                    <td class="text-center"><?php echo $row['title']; ?></td>
                                    <td class="text-center"><?php  
                                         $sql1 = "SELECT name FROM users WHERE id = '$row[employee_id]'";
                                         $result1 = mysqli_query($conn, $sql1);
                                         $row1 = mysqli_fetch_assoc($result1);
                                         echo $row1['name'];
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php  
                                         $sql2 = "SELECT name FROM users WHERE id = '$row[admin_id]'";
                                         $result2 = mysqli_query($conn, $sql2);
                                         $row2 = mysqli_fetch_assoc($result2);
                                         echo $row2['name'];
                                        ?>
                                    </td>
                                    <td class="text-center"><?php echo $row['deadline']; ?></td>
                                    <td class="text-center">
                                        <div type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#exampleModal"><?php echo $row['status']; ?></div>

                                        <!-- model code of change status  -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Change Status
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method='POST' action='update_status.php'>
                                                            <input type='hidden' name='task_id'
                                                                value='<?php echo $row['task_id'] ?>'>
                                                            <select name='status' class="form-control">
                                                                <option value='Pending'
                                                                    <?php echo($row['status'] == 'Pending' ? 'selected' : '') ?>>
                                                                    Pending</option>
                                                                <option value='In Progress'
                                                                    <?php echo ($row['status'] == 'In Progress' ? 'selected' : '') ?>>
                                                                    In Progress</option>
                                                                <option value='Completed'
                                                                    <?php echo($row['status'] == 'Completed' ? 'selected' : '') ?>>
                                                                    Completed</option>
                                                            </select>
                                                            <button type='submit' class="btn btn-info w-100 mt-3"
                                                                name='update_status'>Update</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="zip_download.php?did=<?php echo $row['employee_id']?>"><i
                                                class="la la-download text-info"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn btn-sm btn-success" type="button" data-toggle="modal"
                                            data-target="#exampleModal2">See Des..</div>

                                        <!-- model code of change status  -->
                                        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Task Description
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method='post' action='employee_file_update.php' enctype="multipart/form-data">
                                                            <p class="text-left"><?php echo $row['discription']?></p>
                                                            <input type="hidden" value="<?php echo $row['task_id'] ?>" name="tsk_id">
                                                            <input type="file" class="form-control mt-3" name="files[]" multiple required id="comp_data">
                                                            <button type="submit" class="btn btn-info w-100 mt-3" name="data_submit">Submit Files</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </td>
                                </tr>
                                <?php 
                                 $count++;
                                    }
                                }
                                else{
                                    echo "<tr class='text-center w-100 text-dark'>No record found !</tr>";
                                }
                                 ?>
                            </tbody>
                        </table>

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

<?php 
	include("theme/script.php");	
?>

<script>
const urlParams = new URLSearchParams(window.location.search);
const status = urlParams.get('status');

if (status === 'download_success') {
    $.notify({
        icon: 'la la-user-plus',
        message: "Files Download  successfully!"
    }, {
        type: "info",
        delay: 3000,
        placement: {
            from: "top",
            align: "right"
        }
    });
} else if (status === 'download_fail') {
    $.notify({
        icon: "la la-user-times",
        message: "Failed to Download. Please try again."
    }, {
        type: "danger",
        delay: 3000,
        placement: {
            from: "top",
            align: "right"
        }
    });
}else if (status === 'success') {
    $.notify({
        icon: "la la-user-times",
        message: "File Upload Successfull !"
    }, {
        type: "success",
        delay: 3000,
        placement: {
            from: "top",
            align: "right"
        }
    });
} else if (status === 'error') {
    $.notify({
        icon: "la la-user-times",
        message: "Failed to Upload. Please try again."
    }, {
        type: "danger",
        delay: 3000,
        placement: {
            from: "top",
            align: "right"
        }
    });
}

const url = new URL(window.location.href);
if (url.searchParams.has('status')) {
    url.searchParams.delete('status');
    window.history.replaceState({}, document.title, url.toString());
}
</script>




<?php 

if(isset($_POST['data_submit'])){
    $task_id = $_POST['tsk_id'];
    echo $task_id;
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
    echo $sql;
    exit;
    $result = mysqli_query($conn, $sql);
    if($result){
        header("location: my_tasks.php?status=success");
    }else{
        header("location: my_tasks.php?status=error");
    }
}


ob_end_flush();
?>



