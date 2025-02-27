<?php 
include("theme/config.php");
session_start();
if(!isset($_SESSION['name'])){
    header("location:index.php");
    exit;
}
if($_SESSION['role'] == 0){
    header("location:index.php");
    exit;
 }
ob_start();
?>
<!-- including Header -->
<?php 
 include("theme/header.php");
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
                <!-- <h4 class="page-title">Edit Employee</h4> -->
                <?php 
                 if(isset($_GET['emp_id'])){
                    $emp_id = $_GET['emp_id'];
                    $sql = "SELECT * FROM users WHERE id = '$emp_id'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $name = $row['name'];
                    $email = $row['email'];
                    $phone = $row['phone'];
                    $id = $row['id'];
                    $role = $row['role'];
                 }
                ?>

                <div class="row p-3">
                    <div class="card w-100">
                        <div class="card-header">
                            <div class="card-title">Edit Employee</div>
                        </div>
                        <div class="card-body">
                            <form class="needs-validation" action="" method="post" >
                                <input type="hidden" value="<?php echo $id ?>" name="update_id">
                                <!-- Name Field -->
                                <div class="mb-4">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" value="<?php echo $name ?>" placeholder="Enter Name" id="name"
                                        name="name" required>
                                   
                                </div>
                                <!-- Email Field -->
                                <div class="mb-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" value="<?php echo $email ?>" placeholder="Enter Email" id="email"
                                        name="email" required>
                                    
                                </div>
                                 <!-- Password Field -->
                                 <div class="mb-4">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="number" class="form-control" value="<?php echo $phone ?>" placeholder="Enter Phhone" id="phone"
                                        name="phone" required>
                                </div>
                                <!-- Select Box -->
                                <div class="mb-4">
                                    <label for="options" class="form-label">Select Role</label>
                                    <div class="w-100">
                                        <select class="form-select w-100 form-control" id="options" name="options"
                                            required>
                                            <option value="1" <?php echo $role == 1 ? "selected" : '' ?> >Admin</option>
                                            <option value="0" <?php echo $role == 0 ? "selected" : '' ?> >Normal Employee</option>
                                        </select>
                                        
                                    </div>
                                </div>
                                <!-- Submit Button -->
                                <button type="submit" name="edit_employee" class="btn btn-info">Update Employee</button>
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

<?php 
if(isset($_POST['edit_employee'])){
    $employee_id = $_POST['update_id'];
    $e_name = mysqli_real_escape_string($conn , $_POST['name']);
    $e_email = mysqli_real_escape_string($conn , $_POST['email']);
    $e_phone = $_POST['phone'];
    // $e_password = mysqli_real_escape_string($conn , md5($_POST['password']));
    $e_role = $_POST['options'];

    $e_query = "UPDATE users SET name = '$e_name' , email = '$e_email' , phone = $e_phone , role = '$e_role' WHERE id = '$employee_id'";
    $e_result = mysqli_query($conn, $e_query);
    if($e_result){
        header("location: manage_employee.php?status=update_success");
    }else{
        header("location: manage_employee.php?status=update_failed");
    }
  exit();
}

?>
<?php 
ob_end_flush(); 
?>