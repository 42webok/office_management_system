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

                        <form action="leave_request_submit.php" class="p-3" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
                            <!-- Reason  -->
                            <div class="mb-3">
                                <label for="reason" class="form-label">Select Leave Type</label>
                                <select name="leave_type" class="form-control" id="leave_type" required>
                                    <option value="" disabled selected>Choose Leave Type</option>
                                    <option value="Sick">Sick</option>
                                    <option value="Paid">Paid</option>
                                    <option value="Casual">Casual</option>
                                </select>
                                <div class="invalid-feedback">Select leave type.</div>
                            </div>
                            <!-- Reason  -->
                            <div class="mb-3">
                                <label for="reason" class="form-label">Reason</label>
                                <textarea name="reason" class="form-control" id="reason" required></textarea>
                                <div class="invalid-feedback">Please enter reason.</div>
                            </div>
                            <!-- start Date -->
                            <div class="mb-3">
                                <label for="start" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                                <div class="invalid-feedback">Please select a start date.</div>
                            </div>
                            <!-- End Date -->
                            <div class="mb-3">
                                <label for="end" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                                <div class="invalid-feedback">Please select a end date.</div>
                            </div>

                            <input type="submit" value="Submit" class="btn btn-info" name="submit_request">

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