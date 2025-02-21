<!-- including Header -->
<?php
$status = isset($_GET['status']) ? $_GET['status'] : '';
?>
<?php 
 include("theme/header.php");
 include("theme/config.php");
 session_start();
 if(!isset($_SESSION['name'])){
    header("location:index.php");
    exit;
}
$user_id = $_SESSION['login_id'];
$count = 1;

$sql = "SELECT * FROM leave_request WHERE user_id = '$user_id'";
$resultData = mysqli_query($conn, $sql);

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
                <h4 class="page-title">Manage Attendance</h4>

                <div class="row p-3">
                    <div class="card w-100">
                        <div class="card-header d-flex justify-content-between align-items-center ">
                            <div class="card-title">View Attendance History</div>
                            <a href="leave_request.php" class="text-decoration-none">
                                <div class="btn bg-info text-light">Leave Request</div>
                            </a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-head-bg-info table-bordered-bd-info mt-4">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col" class="text-center">Reason</th>
                                        <th scope="col" class="text-center">Leave Type</th>
                                        <th scope="col" class="text-center">Start Date</th>
                                        <th scope="col" class="text-center">End Date</th>
                                        <th scope="col" class="text-center">Status</th>
                                        <th scope="col" class="text-center">Edit</th>
                                        <th scope="col" class="text-center">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php while ($row = mysqli_fetch_assoc($resultData)): ?>
                                    <tr>
                                        <td class="text-center"><?= $count++; ?></td>
                                        <td class="text-center"><?= $row['reason']; ?></td>
                                        <td class="text-center">
                                            <div class='btn btn-sm btn-info'><?php echo $row['leave_type']; ?></div>
                                        </td>
                                        <td class="text-center"><?= $row['start_date']; ?></td>
                                        <td class="text-center"><?= $row['end_date'];  ?></td>
                                        <?php 
                                         if($row['status'] == "Pending"){
                                            $class = "btn btn-sm btn-outline-info";
                                         }else if($row['status'] == "Approved") {
                                            $class = "btn btn-sm btn-outline-success";
                                         }else if($row['status'] == "Rejected"){
                                            $class = "btn btn-sm btn-outline-danger";
                                         }
                                          ?>
                                        <td class="text-center">
                                            <div class="<?php echo $class ?>"><?php echo $row['status']; ?></div>
                                        </td>
                                        <td class="text-center">
                                            <a href="edit_leave.php?id=<?= $row['id']; ?>"
                                                class="btn btn-info btn-sm">Edit</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="delete_leave.php?id=<?= $row['id']; ?>"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure?');">Delete</a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
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
        message: "Leave Request Added !"
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
        message: "Failed to add Request. Please try again."
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
        icon: "la la-check",
        message: "Request update successfull ."
    }, {
        type: "info",
        delay: 3000,
        placement: {
            from: "top",
            align: "right"
        }
    });
} else if (status === 'update_failed') {
    $.notify({
        icon: "la la-check",
        message: "Request update fail."
    }, {
        type: "danger",
        delay: 3000,
        placement: {
            from: "top",
            align: "right"
        }
    });
} else if (status === 'delete_failed') {
    $.notify({
        icon: "la la-user-times",
        message: "Failed to Delete Request. Please try again."
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
        icon: "la la-check",
        message: "Leave request deleted successfully."
    }, {
        type: "success",
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