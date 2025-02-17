<!-- including Header -->
<?php 
include("theme/config.php");
session_start();
if(!isset($_SESSION['name'])){
    header("location:index.php");
    exit;
}
ob_start();

?>
<!-- including Header -->
<?php 
 include("theme/header.php");
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
                <h4 class="page-title">Website Settings</h4>

                <div class="row p-3">
                    <div class="card w-100">
                        <div class="card-header">
                            <div class="card-title">Add Changes</div>
                        </div>
                        <div class="card-body">
                        <form class="needs-validation" action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
                                <!-- Name Field -->
                                 <?php 
                                  $query = "SELECT * FROM users WHERE id = " .$_SESSION['login_id'];
                                 
                                  $result = mysqli_query($conn, $query);
                                  $row = mysqli_fetch_assoc($result);
        
                                  $name = $row['name'];
                                  $email = $row['email'];
                                  $phone = $row['phone'];
                                  $image = $row['image'];
                                  $job = $row['job'];
                                  $address = $row['address'];

                                 ?>
                                <div class="mb-4">
                                    <label for="name" class="form-label">Choose Pic</label>
                                   <div class="files d-flex justify-content-center align-items-center w-25"> 
                                    <input type="file" name="image" id="logo_img">
                                    <h6>Choose New <span class="text-info">Image <i class="la la-image fs-5 h5 m-0 p-0"></i></span> </h6>
                                   </div>
                                    <div class="show_logo" id="preview">
                                        <?php 
                                         if(empty($image)){
                                        ?>
                                           <img src="../assets/img/avatar7.png" alt="previous logo"  class="pre_logo img-fluid">
                                        <?php
                                         }else{
                                          ?>
                                           <img src="uploads/<?php echo $image ?>" alt="previous logo"  class="pre_logo img-fluid">
                                        <?php
                                         }
                                        ?>
                                       
                                    </div>
                                    <div class="text-danger" id="error"></div>
                                </div>
                                <!-- Name Field -->
                                <div class="mb-4">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Name" value='<?php echo $name ?>' name="name" required>
                                    <div class="invalid-feedback">
                                        Please enter name.
                                    </div>
                                </div>
                                <!-- Email Field -->
                                <div class="mb-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" placeholder="Enter Email" value='<?php echo $email ?>' name="email" required>
                                    <div class="invalid-feedback">
                                        Please enter email.
                                    </div>
                                </div>
                                <!-- phone Field -->
                                <div class="mb-4">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="number" class="form-control" placeholder="Enter Phone" value='<?php echo $phone ?>' name="phone" required>
                                    <div class="invalid-feedback">
                                        Please enter phone number.
                                    </div>
                                </div>
                                <!-- phone Field -->
                                <div class="mb-4">
                                    <label for="job" class="form-label">Job</label>
                                    <?php 
                                    $chek_job = '';
                                     if(empty($job)){
                                        $chek_job = "No Data ";
                                     }else{
                                        $chek_job = $job;
                                     }
                                    ?>
                                    <input type="text" class="form-control" placeholder="Enter Job Title" value='<?php echo $chek_job ?>' name="job" required>
                                    <div class="invalid-feedback">
                                        Please enter job title.
                                    </div>
                                </div>
                                <!-- Address Field -->
                                <div class="mb-4">
                                <?php 
                                    $chek_address = '';
                                     if(empty($job)){
                                        $chek_address = "No Data ";
                                     }else{
                                        $chek_address = $address;
                                     }
                                    ?>
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" placeholder="Enter Address" value='<?php echo $chek_address ?>' name="address" required>
                                    <div class="invalid-feedback">
                                        Please enter address.
                                    </div>
                                </div>
                               
                                <!-- Submit Button -->
                                <button type="submit" name="setting" class="btn btn-info">Save Changes</button>
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
<script>

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
<script>
    const fileInput = document.getElementById("logo_img");
    const preview = document.getElementById("preview");
    const error = document.getElementById("error");

    fileInput.addEventListener("change", function () {
        const file = fileInput.files[0]; // Get the selected file

        // Reset preview and error
        // preview.innerHTML = '<p class="text-danger">No image selected</p>';
        error.textContent = "";

        if (file) {
            // Check if the file size exceeds 5MB
            const maxSize = 5 * 1024 * 1024; // 5MB in bytes
            if (file.size > maxSize) {
                error.textContent = "Error: Image size must not exceed 5MB.";
                return;
            }

            // Check if the selected file is an image
            if (!file.type.startsWith("image/")) {
                error.textContent = "Error: Only image files are allowed.";
                return;
            }

            // Display the image in the preview div
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.innerHTML = `<img src="${e.target.result}" alt="Selected Image" class="pre_logo img-fluid" />`;
            };
            reader.readAsDataURL(file);
            // console.log(file);
        }
    });
</script>

<?php 

if(isset($_POST['setting'])){
    $filename = $_FILES['image']['name'];
    
    $tempname = $_FILES['image']['tmp_name'];

    $timestamp = time();
    $newfilename = $timestamp . '.' . $filename;

    $folder = "uploads/" . $newfilename;

    move_uploaded_file($tempname, $folder);
    
    $up_name = mysqli_real_escape_string($conn , $_POST['name']);
    $up_email = mysqli_real_escape_string($conn , $_POST['email']);
    $up_phone = mysqli_real_escape_string($conn , $_POST['phone']);
    $up_address = mysqli_real_escape_string($conn , $_POST['address']);
    $up_job = mysqli_real_escape_string($conn , $_POST['job']);
    $up_image = mysqli_real_escape_string($conn , $newfilename);

    $ext = strtolower(pathinfo($up_image, PATHINFO_EXTENSION)); 

    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!in_array($ext, $allowed_extensions)) {
        $ext = ""; 
        $up_image = '';
    }


    $up_query = "UPDATE users SET name = '$up_name' , email = '$up_email' , phone = '$up_phone' , address = '$up_address' , job = '$up_job' , image = '$up_image' WHERE id = ".$_SESSION['login_id'];
    $up_result = mysqli_query($conn, $up_query);
    if ($up_result) {
        header('location: employee_profile.php?status=success');
    }else{
        header('location: employee_profile.php?status=error');
    }
    exit();

}
ob_end_flush(); 
?>



