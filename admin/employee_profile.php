<!-- including Header -->
<?php 
 include("theme/header.php");
 include("theme/config.php");
 session_start();
 if(!isset($_SESSION['name'])){
    header("location:index.php");
    exit;
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
                <h4 class="page-title">My Profile</h4>

                <div class="container-fluid mt-5">
                    <div class="main-body-custom">


                        <div class="row gutters-sm px-0">
                            <?php 
                             $sql = "SELECT * FROM users WHERE id = ".$_SESSION['login_id'];
                             $result = mysqli_query($conn, $sql);
                            while( $row = mysqli_fetch_assoc($result)){

                           
                             
                            ?>

                            <div class="col-md-8">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Full Name</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?php echo $row['name']; ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Email</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                            <?php echo $row['email']; ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Phone Number</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                            <?php echo $row['phone']; ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Role</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                            <?php echo $row['role'] == 1 ? 'Admin' : 'Employee'; ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Address</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                            <?php echo $row['address']; ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <a class="btn btn-info w-100" 
                                                    href="employee_profile_edit.php">Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-column align-items-center text-center">
                                            <?php 
                                             if(empty($row['image'])){
                                             echo '<img src="../assets/img/avatar7.png" alt="Admin"
                                                class="rounded-circle" width="150" >';
                                             }else{
                                            ?>
                                            <img src="uploads/<?php echo $row['image']; ?>" id="profile_pic"  alt="Admin"
                                                class="rounded-circle" width="150">
                                            <?php 
                                             }
                                            ?>
                                            <div class="mt-3">
                                                <h4> <?php echo $row['name']; ?></h4>
                                                <p class="text-secondary mb-1"> <?php echo $row['job']; ?></p>
                                                <?php 
                                                 $set = "SELECT companey FROM setting WHERE id = 1";
                                                 $result_set = mysqli_query($conn, $set);
                                                 $row_set = mysqli_fetch_assoc($result_set);
                                                ?>
                                                <p class="text-muted font-size-sm"><b><?php echo $row_set['companey']; ?></b></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <?php 
                          }
                        ?>

                    </div>


                </div>
                <!-- /////////////////////////////// -->
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
        icon: 'la la-edit',
        message: "Profile updated successfully !"
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
        icon: 'la la-exclamation-circle',
        message: "Profile not updated !"
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