<!-- including Header -->
<?php 
include("theme/config.php");
 include("theme/header.php");
 session_start();
 if(!isset($_SESSION['name'])){
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
                <h4 class="page-title">Website Settings</h4>

                <div class="row p-3">
                    <div class="card w-100">
                        <div class="card-header">
                            <div class="card-title">Add Changes</div>
                        </div>
                        <div class="card-body">
                        <form class="needs-validation" action="setting_update.php" method="post" enctype="multipart/form-data">
                                <!-- Name Field -->
                                 <?php 
                                  $query = "SELECT * FROM setting wHERE id = 1";
                                  $result = mysqli_query($conn, $query);
                                  $row = mysqli_fetch_assoc($result);
                                  $image = $row['logo'];
                                  $footer = $row['footer'];
                                  $companey = $row['companey'];
                                  $url = $row['url'];
                                 ?>
                                <div class="mb-4 w-25">
                                    <label for="name" class="form-label">Choose Logo</label>
                                   <div class="files d-flex justify-content-center align-items-center"> 
                                    <input type="file" name="logo" id="logo_img">
                                    <h6>Choose New <span class="text-info">Logo <i class="la la-image fs-5 h5 m-0 p-0"></i></span> </h6>
                                   </div>
                                    <div class="show_logo" id="preview">
                                        <img src="uploads/<?php echo $image ?>" alt="previous logo"  class="pre_logo img-fluid">
                                    </div>
                                    <div class="text-danger" id="error"></div>
                                </div>
                                <!-- footer Field -->
                                <div class="mb-4">
                                    <label for="footer" class="form-label">Footer Information</label>
                                    <input type="text" class="form-control" placeholder="Enter Information" value='<?php echo $footer ?>' name="footer">

                                </div>
                                <!-- footer URL -->
                                <div class="mb-4">
                                    <label for="footer" class="form-label">Footer URL</label>
                                    <input type="url" class="form-control" placeholder="Enter URL" value='<?php echo $url ?>' name="url">

                                </div>
                                <!-- Companey Name -->
                                <div class="mb-4">
                                    <label for="companey" class="form-label">Companey Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Companey name" value='<?php echo $companey ?>' name="companey">

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




<script>

const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');

if (status === 'success') {
    $.notify({
        icon: 'la la-check-circle-o',
        message: "Data added successfully!"
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
        icon: "la la-exclamation",
        message: "Failed to add data. Please try again."
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