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
                <h4 class="page-title">Manage Posts</h4>

                <div class="row p-3">
                    <div class="card w-100">
                        <div class="card-header d-flex justify-content-between align-items-center ">
                            <div class="card-title">View Post</div>
                            <a href="add_post.php" class="text-decoration-none">
                                <div class="btn bg-info text-light">Add Post</div>
                            </a>
                        </div>
                        <table class="table table-bordered table-head-bg-info table-bordered-bd-info mt-4">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">#</th>
                                    <th scope="col" class="text-center">Owner</th>
                                    <th scope="col" class="text-center">Content</th>
                                    <th scope="col" class="text-center">Media</th>
                                    <th scope="col" class="text-center">Created At</th>
                                    <th scope="col" class="text-center">Comments</th>
                                    <th scope="col" class="text-center">Edit</th>
                                    <th scope="col" class="text-center">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                     $sql = "SELECT * FROM office_posts";
                                     $result = mysqli_query($conn, $sql);
                                     if(mysqli_num_rows($result) > 0){
                                        $count = 1;
                                     while($row = mysqli_fetch_assoc($result)){
                                    ?>
                                <tr>
                                    <td class="text-center"><?php echo $count ?></td>
                                    <td class="text-center"><?php  
                                         $sql1 = "SELECT name FROM users WHERE id = '$row[user_id]'";
                                         $result1 = mysqli_query($conn, $sql1);
                                         $row1 = mysqli_fetch_assoc($result1);
                                         echo $row1['name'];
                                        ?>
                                    </td>
                                    <td class="text-center"><?php echo $row['content']; ?></td>
                                    <td class="text-center">
                                        <?php 
                                                $ext = pathinfo($row['media'], PATHINFO_EXTENSION);
                                                
                                                // Check if the extension is for an image
                                                if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif' || $ext == 'webp' || $ext == 'svg' || $ext == 'ico' || $ext == 'avif') {
                                                    echo '<img src="uploads/'.$row['media'].'" width="50" height="50">';
                                                }
                                                // Check if the extension is for a video
                                                else if ($ext == 'mp4' || $ext == 'avi' || $ext == 'mov' || $ext == 'mpeg' || $ext == 'm4v' || $ext == 'mpg') {
                                                    echo '<video width="50" height="50"><source src="uploads/'.$row['media'].'" type="video/'.$ext.'"></video>';
                                                }
                                            ?>
                                    </td>

                                    <td class="text-center"><?php echo $row['created_at']; ?></td>
                                    <td class="text-center">no comment</td>

                                    <td class="text-center"><a href="edit_post.php?post_id=<?php echo $row['id']?>"><i
                                                class="la la-edit text-info"></i></a>
                                    </td>
                                    <td class="text-center"><a href="delete_post.php?post_id=<?php echo $row['id']?>"><i
                                                class="la la-trash-o text-danger"></i></a>
                                    </td>
                                </tr>
                                <?php 
                                 $count++;
                                    }
                                }
                                else{
                                    echo "<tr class='text-center w-100 text-dark'>No record found !</tr>";
                                }
                                 ?>
                            </tbody>
                        </table>

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
const urlParams = new URLSearchParams(window.location.search);
const status = urlParams.get('status');

if (status === 'success') {
    $.notify({
        icon: 'la la-user-plus',
        message: "Post added successfully!"
    }, {
        type: "info",
        delay: 3000,
        placement: {
            from: "top",
            align: "right"
        }
    });
} else if (status === 'fail') {
    $.notify({
        icon: "la la-user-times",
        message: "Failed to add Post. Please try again."
    }, {
        type: "danger",
        delay: 3000,
        placement: {
            from: "top",
            align: "right"
        }
    });
} else if (status === 'update_success') {
    $.notify({
        icon: "la la-smile-o",
        message: "post update successfully !"
    }, {
        type: "success",
        delay: 3000,
        placement: {
            from: "top",
            align: "right"
        }
    });
} else if (status === 'update_failed') {
    $.notify({
        icon: "la la-info-circle",
        message: "post update failed !"
    }, {
        type: "danger",
        delay: 3000,
        placement: {
            from: "top",
            align: "right"
        }
    });
} else if (status === 'delete_success') {
    $.notify({
        icon: "la la-smile-o",
        message: "Delete task success !"
    }, {
        type: "success",
        delay: 3000,
        placement: {
            from: "top",
            align: "right"
        }
    });
} else if (status === 'delete_error') {
    $.notify({
        icon: "la la-info-circle",
        message: "Delete task failed !"
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