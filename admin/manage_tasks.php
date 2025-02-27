<!-- including Header -->
<?php 
 include("theme/header.php");
 session_start();
 if(!isset($_SESSION['name'])){
    header("location:index.php");
    exit;
}
if($_SESSION['role'] == 0){
    header("location:index.php");
    exit;
 }
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
                <h4 class="page-title">Manage Tasks</h4>

                <div class="row p-3">
                    <div class="card w-100">
                        <div class="card-header d-flex justify-content-between align-items-center ">
                            <div class="card-title">View Tasks</div>
                            <a href="add_task.php" class="text-decoration-none">
                                <div class="btn bg-info text-light">Add Task</div>
                            </a>
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
                                    <th scope="col" class="text-center">Edit</th>
                                    <th scope="col" class="text-center">Delete</th>
                                    <th scope="col" class="text-center">Complete Files</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                     include("theme/config.php");
                                     $sql = "SELECT * FROM manage_task";
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
                                    <td class="text-center"><?php echo $row['status']; ?></td>
                                    <td class="text-center"><?php  
                                        $image = $row['files'];
                                        $filearray = explode(',' , $image);
                                        $cou = 1;
                                        for($i = 0; $i<count($filearray); $i++){
                                            $cou = $cou + $i;
                                        }
                                        echo $cou;
                                        ?></td>

                                    <td class="text-center"><a
                                            href="edit_task.php?task_id=<?php echo $row['task_id']?>"><i
                                                class="la la-edit text-info"></i></a>
                                    </td>
                                    <td class="text-center"><a
                                            href="delete_task.php?task_id=<?php echo $row['task_id']?>"><i
                                                class="la la-trash-o text-danger"></i></a></td>
                                    <td class="text-center">
                                     
                                        <?php 
                                        if($row['emp_files'] == 'NULL' || empty($row['emp_files'])){
                                            echo "No File";
                                        }else{
                                            ?>
                                            <a href="zip_admin_download.php?fid=<?php echo $row['employee_id']?>"><i
                                                class="la la-download text-info"></i></a>
                                        <?php         
                                        }
                                        ?>
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

if (status === 'success') {
    $.notify({
        icon: 'la la-user-plus',
        message: "Task added successfully!"
    }, {
        type: "info",
        delay: 3000,
        placement: {
            from: "top",
            align: "right"
        }
    });
} else if (status === 'error') {
    $.notify({
        icon: "la la-user-times",
        message: "Failed to add task. Please try again."
    }, {
        type: "danger",
        delay: 3000,
        placement: {
            from: "top",
            align: "right"
        }
    });
} else if (status === 'update_success') {
    $.notify({
        icon: "la la-smile-o",
        message: "Task update successfully !"
    }, {
        type: "success",
        delay: 3000,
        placement: {
            from: "top",
            align: "right"
        }
    });
} else if (status === 'update_failed') {
    $.notify({
        icon: "la la-info-circle",
        message: "Task update failed !"
    }, {
        type: "danger",
        delay: 3000,
        placement: {
            from: "top",
            align: "right"
        }
    });
} else if (status === 'delete_success') {
    $.notify({
        icon: "la la-smile-o",
        message: "Delete task success !"
    }, {
        type: "success",
        delay: 3000,
        placement: {
            from: "top",
            align: "right"
        }
    });
} else if (status === 'delete_error') {
    $.notify({
        icon: "la la-info-circle",
        message: "Delete task failed !"
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