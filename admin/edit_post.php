<!-- including Header -->
<?php 
 include("theme/header.php");
 include("theme/config.php");
 session_start();
 if(!isset($_SESSION['name'])){
    header("location:index.php");
    exit;
}

if(isset($_GET['post_id'])){
    $post_id = $_GET['post_id'];
    
}else{
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
                <h4 class="page-title">Update Post</h4>

                <div class="row p-3">
                    <div class="card shadow-lg p-4 w-100">
                        <h5 class="mb-4 text-dark">Update Post</h5>
                        <!-- post adding code start here  -->
                        <form action="" method="post" enctype="multipart/form-data">
                            <?php 
                            $sql = "SELECT * FROM office_posts WHERE id = '$post_id'";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);
                             
                            ?>
                            <input type="hidden" name="post_id" value="<?php echo $row['id'] ?>">
                            <!-- Post Content -->
                            <div class="mb-3">
                                <label for="content" class="form-label">Post Content</label>
                                <textarea name="content" class="form-control" id="content"
                                    required><?php echo $row['content']; ?></textarea>
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
                                <?php 
                                                $ext = pathinfo($row['media'], PATHINFO_EXTENSION);
                                                
                                                // Check if the extension is for an image
                                                if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif' || $ext == 'webp' || $ext == 'svg' || $ext == 'ico' || $ext == 'avif') {
                                                    echo '<img src="uploads/'.$row['media'].'" width="100" height="100">';
                                                }
                                                // Check if the extension is for a video
                                                else if ($ext == 'mp4' || $ext == 'avi' || $ext == 'mov' || $ext == 'mpeg' || $ext == 'm4v' || $ext == 'mpg') {
                                                    echo '<video controls width="140" height="140"><source src="uploads/'.$row['media'].'"  type="video/'.$ext.'"></video>';
                                                }
                                            ?>
                            </div>
                            <div class="text-danger mb-3" id="error"></div>
                            <!-- Post Owner -->
                            <div class="mb-3">
                                <label for="admin" class="form-label">Select Post Owner</label>
                                <select name="post_owner" id="post_owner" class="form-control" required>
                                    <?php 
                                  $admin = "SELECT * FROM users WHERE role= 1";
                                  $results = mysqli_query($conn, $admin);
                                  while($rows = mysqli_fetch_assoc($results)){
                                    ?>
                                    <option value="<?php echo $rows['id'];  echo $rows['id'] == $row['user_id'] ? 'selected' : ''; ?>"><?php echo $rows['name']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                                <div class="invalid-feedback">Please select post owner.</div>
                            </div>

                            <!-- submit post btn -->
                            <input type="submit" value="Update" name="update_post" class="btn btn-info">
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
if(isset($_POST['update_post'])){
    $content = mysqli_real_escape_string($conn , $_POST['content']);
    $post_owner = mysqli_real_escape_string($conn , $_POST['post_owner']);
    
    $post_id = $_POST['post_id'];

    $filename = $_FILES['post_file']['name'];
    
    $tempname = $_FILES['post_file']['tmp_name'];

    $timestamp = time();
    $newfilename = $timestamp . '.' . $filename;

    $folder = "uploads/" . $newfilename;

    move_uploaded_file($tempname, $folder);


    $post_update = "UPDATE office_posts SET content = '$content' , user_id = '$post_owner' , media = '$newfilename' WHERE id = '$post_id'";
    $result_data = mysqli_query($conn, $post_update);
    if($result_data){
        header("Location: manage_post.php?status=update_success");
        exit;
    }else{
        header("Location: manage_post.php?status=delete_error");
    }



}
ob_end_flush(); 
?>