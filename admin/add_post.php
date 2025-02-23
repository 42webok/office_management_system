<!-- including Header -->
<?php 
 include("theme/header.php");
 include("theme/config.php");
 session_start();
 if(!isset($_SESSION['name'])){
    header("location:index.php");
    exit;
}
ob_start();
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
                <h4 class="page-title">Add Post</h4>

                <div class="row p-3">
                    <div class="card shadow-lg p-4 w-100">
                        <h5 class="mb-4 text-dark">Create Post</h5>
                        <!-- post adding code start here  -->
                        <form action="" method="post" enctype="multipart/form-data">
                            <!-- Post Content -->
                            <div class="mb-3">
                                <label for="content" class="form-label">Post Content</label>
                                <textarea name="content" class="form-control" id="content" required></textarea>
                                <div class="invalid-feedback">Please provide a Content.</div>
                            </div>
                            <!-- Post image || Video -->
                            <div class="mb-1">
                                <label for="file" class="form-label">Post Image/Video</label>
                                <input type="file" name="post_file" id="post_file" accept="image/*,video/*"
                                    class="form-control" required>
                                <div class="invalid-feedback">Please provide Image/Video.</div>
                            </div>
                            <div class="show_logo mb-3" id="preview">

                            </div>
                            <div class="text-danger mb-3" id="error"></div>
                            <!-- Post Owner -->
                            <div class="mb-3">
                                <label for="admin" class="form-label">Select Post Owner</label>
                                <select name="post_owner" id="post_owner" class="form-control" required>
                                    <option value="" disabled selected>Choose Post Owner</option>
                                    <?php 
                                  $admin = "SELECT * FROM users WHERE role= 1";
                                  $result = mysqli_query($conn, $admin);
                                  while($row = mysqli_fetch_assoc($result)){
                                    ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                                <div class="invalid-feedback">Please select post owner.</div>
                            </div>

                            <!-- submit post btn -->
                            <input type="submit" value="Submit" name="create_post" class="btn btn-info">
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

<!-- image && bvideo  validation  -->
<script>
const fileInput = document.getElementById("post_file");
const preview = document.getElementById("preview");
const error = document.getElementById("error");

fileInput.addEventListener("change", function() {
    const file = fileInput.files[0]; // Get the selected file

    // Reset preview and error
    error.textContent = "";

    if (file) {
        // Check if the file size exceeds 5MB
        const maxSize = 5 * 1024 * 1024; // 5MB in bytes
        if (file.size > maxSize) {
            error.textContent = "Error: File size must not exceed 5MB.";
            return;
        }

        // Check if the selected file is an image or video
        if (!file.type.startsWith("image/") && !file.type.startsWith("video/")) {
            error.textContent = "Error: Only image and video files are allowed.";
            return;
        }

        // Display the image or video in the preview div
        const reader = new FileReader();
        reader.onload = function(e) {
            if (file.type.startsWith("image/")) {
                preview.innerHTML =
                    `<img src="${e.target.result}" alt="Selected Image" class="pre_logo img-fluid" />`;
            } else if (file.type.startsWith("video/")) {
                preview.innerHTML =
                    `<video src="${e.target.result}" controls class="pre_logo w-25 img-fluid"></video>`;
            }
        };
        reader.readAsDataURL(file);
    }
});
</script>












<?php 
	include("theme/script.php");	
?>

<?php 
include("theme/config.php");	
if(isset($_POST['create_post'])){
    $content = mysqli_real_escape_string($conn , $_POST['content']);
    $post_owner = mysqli_real_escape_string($conn , $_POST['post_owner']);
    
    $filename = $_FILES['post_file']['name'];
    
    $tempname = $_FILES['post_file']['tmp_name'];

    $timestamp = time();
    $newfilename = $timestamp . '.' . $filename;

    $folder = "uploads/" . $newfilename;

    move_uploaded_file($tempname, $folder);


    $post_insert = "INSERT INTO office_posts (user_id , content	 , media) VALUES ($post_owner , '$content' , '$newfilename')";
    $results = mysqli_query($conn, $post_insert);
    if($results){
        header("Location: manage_post.php?status=success");
        exit;
    }else{
        header("Location: manage_post.php?status=fail");
    }



}
ob_end_flush(); 
?>