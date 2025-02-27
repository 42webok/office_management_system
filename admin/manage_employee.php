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
                <!-- <h4 class="page-title"></h4> -->

                <div class="row p-3">
                    <div class="card w-100">
                        <div class="card-header d-flex justify-content-between align-items-center ">
                            <div class="card-title">Manage Employee</div>
                            <a href="add_employee.php" class="text-decoration-none">
                                <div class="btn bg-info text-light">Add Employee</div>
                            </a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-head-bg-info table-bordered-bd-info mt-4">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col" class="text-center">Name</th>
                                        <th scope="col" class="text-center">Email</th>
                                        <th scope="col" class="text-center">Role</th>
                                        <th scope="col" class="text-center">Edit</th>
                                        <th scope="col" class="text-center">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                     include("theme/config.php");
                                     $sql = "SELECT * FROM users";
                                     $result = mysqli_query($conn, $sql);
                                     if(mysqli_num_rows($result) > 0){
                                        $count = 1;
                                     while($row = mysqli_fetch_assoc($result)){
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $count ?></td>
                                        <td class="text-center"><?php echo $row['name']; ?></td>
                                        <td class="text-center"><?php echo $row['email']; ?></td>
                                        <td class="text-center"><?php echo $row['role'] == 1 ? 'Admin' : 'Employee'; ?></td>
                                        <td class="text-center"><a href="edit_employee.php?emp_id=<?php echo $row['id']?>"><i class="la la-edit text-info"></i></a>
                                        </td>
                                        <td class="text-center"><a href="delete_employee.php?emp_id=<?php echo $row['id']?>"><i
                                                    class="la la-trash-o text-danger"></i></a></td>
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
        message: "Employee added successfully!"
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
        message: "Failed to add Employee. Please try again."
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
        message: "Employee update successfully !"
    }, {
        type: "success",
        delay: 3000,
        placement: {
            from: "top",
            align: "right"
        }
    });
}else if (status === 'update_failed') {
    $.notify({
        icon: "la la-info-circle",
        message: "Employee update failed !"
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
        message: "Delete Employee success !"
    }, {
        type: "success",
        delay: 3000,
        placement: {
            from: "top",
            align: "right"
        }
    });
}else if (status === 'delete_error') {
    $.notify({
        icon: "la la-info-circle",
        message: "Delete employee failed !"
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