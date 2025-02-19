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
$today = date("Y-m-d");
$sql = "SELECT * FROM attendance WHERE user_id = '$user_id' AND date = '$today'";
$result = mysqli_query($conn, $sql);
$attendance = mysqli_fetch_assoc($result);

    $checked_in = $attendance && !empty($attendance['check_in']);
    $checked_out = $attendance && !empty($attendance['check_out']);
    // echo "<pre>";
    // print_r($checked_out);
    // exit;

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
                <h4 class="page-title">Mark Attendance</h4>

                <div class="row p-3">
                    <div class="card w-100">
                        <div class="card-header d-flex justify-content-between align-items-center ">
                            <div class="card-title">Mark Attendance Today</div>
                        </div>
                        <div class="card-body">
                            <!-- Attandance code start  here  -->
                            <div class="text-center mt-4">
                                <?php if (!$checked_in): ?>
                                <form action="attendance_action.php" method="POST">
                                    <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                    <button type="submit" name="check_in" class="btn btn-success">Check In</button>
                                </form>
                                <?php elseif (!$checked_out): ?>
                                <form action="attendance_action.php" method="POST">
                                    <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                    <button type="submit" name="check_out" class="btn btn-danger">Check Out</button>
                                </form>
                                <?php else: ?>
                                <p class="text-success">✅ You have completed today's attendance.</p>
                                <?php endif; ?>
                            </div>
                            <!-- Attandance code end  here  -->
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