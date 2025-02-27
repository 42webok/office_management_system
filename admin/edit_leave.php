<!-- including Header -->
<?php 
 include("theme/header.php");
 include("theme/config.php");
 session_start();
 if(!isset($_SESSION['name'])){
    header("location:index.php");
    exit;
}
if($_SESSION['role'] == 0){
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = "SELECT * FROM leave_request WHERE  id = '$id'";
        $result = mysqli_query($conn, $sql);
        $rows = mysqli_fetch_assoc($result);
        if($rows['user_id'] != $_SESSION['login_id']){
            header("location: index.php");
        }
    }
}

// if(!isset($_GET['id'])){
//     header("location: index.php");
//     exit;
// }

$select = "SELECT * FROM leave_request WHERE id =".$_GET['id'];
$result = mysqli_query($conn, $select);
$leave = mysqli_fetch_assoc($result);


if(isset($_POST['update_request'])){
    $leave_id = $_POST['leave_id'];
    $leave_type = $_POST['leave_type'];
    $reason = $_POST['reason'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $update = "UPDATE leave_request SET reason = '$reason' , leave_type = '$leave_type' , start_date = '$start_date' , end_date = '$end_date' WHERE id = '$leave_id'";
    $update_result = mysqli_query($conn, $update);
    // echo $update;
    // exit;
    if($update_result){
        header("location: get_leave.php?status=update_success");
        // exit;
    }else{
        header("location: get_leave.php?status=update_failed");
    }
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
                <!-- <h4 class="page-title">Leave Request</h4> -->

                <div class="row p-3">
                    <div class="card w-100">
                        <div class="card-header d-flex justify-content-between align-items-center ">
                            <div class="card-title">Leave Request</div>
                        </div>

                        <form action="" class="p-3" method="POST">
                            <input type="hidden" name="leave_id" value="<?php echo $leave['id']  ?>">
                            <!-- Reason  -->
                            <div class="mb-3">
                                <label for="reason" class="form-label">Select Leave Type</label>
                                <select name="leave_type" class="form-control" id="leave_type" required>
                                    <option value="Sick" <?php $leave['leave_type'] == 'Sick' ? 'selected' : '' ?>>Sick
                                    </option>
                                    <option value="Paid" <?php $leave['leave_type'] == 'Paid' ? 'selected' : '' ?>>Paid
                                    </option>
                                    <option value="Casual" <?php $leave['leave_type'] == 'Casual' ? 'selected' : '' ?>>
                                        Casual</option>
                                </select>
                                <div class="invalid-feedback">Select leave type.</div>
                            </div>
                            <!-- Reason  -->
                            <div class="mb-3">
                                <label for="reason" class="form-label">Reason</label>
                                <textarea name="reason" class="form-control" id="reason"
                                    required><?php echo $leave['reason'] ?></textarea>
                                <div class="invalid-feedback">Please enter reason.</div>
                            </div>
                            <!-- start Date -->
                            <div class="mb-3">
                                <label for="start" class="form-label">Start Date</label>
                                <input type="date" class="form-control" value="<?php echo $leave['start_date'] ?>"
                                    id="start_date" name="start_date" required>
                                <div class="invalid-feedback">Please select a start date.</div>
                            </div>
                            <!-- End Date -->
                            <div class="mb-3">
                                <label for="end" class="form-label">End Date</label>
                                <input type="date" class="form-control" value="<?php echo $leave['end_date'] ?>"
                                    id="end_date" name="end_date" required>
                                <div class="invalid-feedback">Please select a end date.</div>
                            </div>

                            <input type="submit" value="Update" class="btn btn-info" name="update_request">

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

<?php 
	include("theme/script.php");	
?>
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



?>