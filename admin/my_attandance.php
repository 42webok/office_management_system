<!-- including Header -->
<?php 
 include("theme/header.php");
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
                <h4 class="page-title">Manage Attendance</h4>

                <div class="row p-3">
                    <div class="card w-100">
                        <div class="card-header d-flex justify-content-between align-items-center ">
                            <div class="card-title">View Attendance History</div>
                            <a href="mark_attandance.php" class="text-decoration-none">
                                <div class="btn bg-info text-light">Mark Attendance</div>
                            </a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-head-bg-info table-bordered-bd-info mt-4">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">Date</th>
                                        <th scope="col" class="text-center">Check In</th>
                                        <th scope="col" class="text-center">Check Out</th>
                                        <th scope="col" class="text-center">Status</th>
                                    </tr>
                                </thead>
                                   <tbody>
                                    <?php 
                                     include("theme/config.php");
                                     $sql = "SELECT * FROM attendance WHERE user_id = '$user_id' ORDER BY date DESC";
                                     $result = mysqli_query($conn, $sql);
                                     if(mysqli_num_rows($result) > 0){
                                     while($row = mysqli_fetch_assoc($result)){
                                      
                                        echo "
                                        <tr>
                                        <td>{$row['date']}</td>
                                        <td>{$row['check_in']}</td>
                                        <td>{$row['check_out']}</td>
                                        <td>{$row['status']}</td>
                                        </tr>
                                       ";
                                     }
                                    }
                                    else{
                                        echo "<div class='text-center'>No Record Found</div>";
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

