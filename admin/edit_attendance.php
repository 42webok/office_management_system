<!-- including Header -->
<?php 
 include("theme/header.php");
 include("theme/config.php");
 session_start();
 if(!isset($_SESSION['name'])){
    header("location:index.php");
    exit;
}
$user_id = $_SESSION['login_id'];

$attendance_id = $_GET['id'];

// Fetch attendance details
$query = "SELECT * FROM attendance WHERE id = '$attendance_id'";
$result = mysqli_query($conn, $query);
$attendance = mysqli_fetch_assoc($result);

// Update record
if (isset($_POST['update'])) {
    $status = $_POST['status'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];

    $update = "UPDATE attendance SET status='$status', check_in='$check_in', check_out='$check_out' WHERE id='$attendance_id'";
    mysqli_query($conn, $update);
    
    header("Location: manage_attendance.php");
    exit();
}


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
                <h4 class="page-title">Edit Attendance</h4>

                <div class="row p-3">
                    <div class="card w-100">
                        <div class="card-header d-flex justify-content-between align-items-center ">
                            <div class="card-title">Edit Attendance</div>
                        </div>
                        <!-- Filter Form -->
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="Present"
                                            <?= $attendance['status'] == 'Present' ? 'selected' : '' ?>>Present</option>
                                        <option value="Absent"
                                            <?= $attendance['status'] == 'Absent' ? 'selected' : '' ?>>Absent</option>
                                        <option value="Late" <?= $attendance['status'] == 'Late' ? 'selected' : '' ?>>
                                            Late</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Check-in Time</label>
                                    <input type="time" name="check_in" class="form-control"
                                        value="<?= $attendance['check_in'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Check-out Time</label>
                                    <input type="time" name="check_out" class="form-control"
                                        value="<?= $attendance['check_out'] ?>">
                                </div>
                                <button type="submit" name="update" class="btn btn-primary w-100">Update
                                    Attendance</button>
                            </form>
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