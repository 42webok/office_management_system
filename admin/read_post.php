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
                <h4 class="page-title">Manage Posts</h4>

                <div class="row p-3">
                    <div class="card w-100">
                        <div class="card-header d-flex justify-content-between align-items-center ">
                            <div class="card-title">View Post</div>
                        </div>

                        <?php 
                                     $sql = "SELECT * FROM office_posts ORDER BY id DESC";
                                     $result = mysqli_query($conn, $sql);
                                     if(mysqli_num_rows($result) > 0){
                                     while($row = mysqli_fetch_assoc($result)){
                                        // echo "<pre>";
                                        // print_r($row);
                                        // exit;
                         ?>
                        <!-- Post row code start here  -->
                        <div class="container mt-3 custom_container">
                            <div class="row">
                                <div class="col-md-6 d-block mx-auto">
                                    <div class="office_post card p-3 mb-3">
                                        <?php 
                                        $user = "SELECT * FROM users WHERE id = '$row[user_id]'";
                                        $user_result = mysqli_query($conn , $user);
                                        $data = mysqli_fetch_assoc($user_result);
                                        ?>
                                        <div class="header">
                                            <img class="author-img" src="uploads/<?php echo $data['image']; ?>" />
                                            <p class="authors d-flex flex-column">
                                                <b>
                                                    <?php echo $data['name']; ?>
                                                </b>
                                                <span class="post_time time-ago"
                                                    data-time="<?php echo $row['created_at']; ?>">

                                                </span>
                                            </p>
                                        </div>
                                        <?php 
                                                $ext = pathinfo($row['media'], PATHINFO_EXTENSION);
                                                
                                                // Check if the extension is for an image
                                                if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif' || $ext == 'webp' || $ext == 'svg' || $ext == 'ico' || $ext == 'avif') {
                                                    echo '<img class="img-fluid" src="uploads/'.$row['media'].'" >';
                                                }
                                                // Check if the extension is for a video
                                                else if ($ext == 'mp4' || $ext == 'avi' || $ext == 'mov' || $ext == 'mpeg' || $ext == 'm4v' || $ext == 'mpg') {
                                                    echo '<video controls class="img-fluid"><source src="uploads/'.$row['media'].'" type="video/'.$ext.'"></video>';
                                                }
                                            ?>

                                        <div
                                            class="interactions d-flex align-items-center justify-content-between mb-3">
                                            <svg class="comment" aria-label="Comment" class="x1lliihq x1n2onr6 x5n08af"
                                                fill="currentColor" height="24" role="img" viewBox="0 0 24 24"
                                                width="24">
                                                <path d="M20.656 17.008a9.993 9.993 0 1 0-3.59 3.615L22 22Z" fill="none"
                                                    stroke="currentColor" stroke-linejoin="round" stroke-width="2">
                                                </path>
                                            </svg>
                                            <div class="btn btn-sm btn-info text-light" type="button"
                                                data-toggle="modal"
                                                data-target="#exampleModal<?php echo $row['id']; ?>">
                                                Add Comment
                                            </div>

                                            <!-- Model code for adding comment -->
                                            <div class="modal fade" id="exampleModal<?php echo $row['id']; ?>"
                                                tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel<?php echo $row['id']; ?>"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="exampleModalLabel<?php echo $row['id']; ?>">Add
                                                                Comment</h5>
                                                            <button type="button"   class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method='POST' action='' class="insert_comment">
                                                                <input type='hidden' name='post_id'
                                                                    value='<?php echo $row['id'] ?>'>
                                                                <textarea name="comment" id="comments"
                                                                    placeholder="Add a comment" class="form-control"
                                                                    required></textarea>
                                                                <button type='submit' class="btn btn-info w-100 mt-3"
                                                                    name='insert_comment'>Add Comment</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>    

                                            <!-- ----------- -->
                                        </div>
                                        <div>
                                            <p class="description"><?php 
                                             echo $row['content'];
                                            ?></p>
                                        </div>

                                    </div>
                                </div>
                            </div>



                            <!-- Post row code end here  -->
                        </div>


                        <?php 
                                
                                    }
                                }
                                else{
                                    echo "<div class='text-center w-100 text-dark'>No Post found !</div>";
                                }
                        ?>




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
    $("document").ready(function() {
    $(document).on('submit', '.insert_comment', function(e) {
        e.preventDefault();
        let frm_data = $(this).serialize(); // Serialize the form data

        $.ajax({
            type: "POST",
            url: "add_comment.php",
            data: frm_data,
            success: function(data) {
                $('.close').click();  // Close the modal or any other element
                $('#comments').html('');  // Clear the comment list or relevant container

                // Clear the text area after successful comment submission
                $('textarea').val(''); // This will clear the textarea

                // Notify success
                $.notify({
                    icon: 'la la-user-plus',
                    message: "Comment added successfully!"
                }, {
                    type: "info",
                    delay: 3000,
                    placement: {
                        from: "top",
                        align: "right"
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error(error); // Log the error for debugging
                $.notify({
                    icon: 'la la-exclamation-triangle',
                    message: "There was an error processing your request."
                }, {
                    type: "danger",
                    delay: 3000,
                    placement: {
                        from: "top",
                        align: "right"
                    }
                });
            }
        });
    });
});

    
    
    </script>