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

$usersQuery = "SELECT * FROM users WHERE role= 0";
$usersResult = mysqli_query($conn, $usersQuery);

$whereclause = "1=1";
if(isset($_GET['date']) && !empty($_GET['date'])){
    $whereclause .= " AND date = '".$_GET['date']."'";
}

if(isset($_GET['user_id']) && !empty($_GET['user_id'])){
    $whereclause .= " AND user_id = '".$_GET['user_id']."'";
}
// echo $whereclause . '<br>';
$sql = "SELECT attendance.* , users.name , users.role
        FROM attendance 
        JOIN users ON attendance.user_id = users.id
        WHERE $whereclause 
        ORDER BY date DESC
        ";
$resultData = mysqli_query($conn, $sql);
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
                        </div>
                        <!-- Filter Form -->
                        <form class="row g-3 p-3 mb-4" method="GET">
                            <div class="col-md-5">
                                <label class="form-label">Select Date</label>
                                <input type="date" name="date" class="form-control">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Select Employee</label>
                                <select name="user_id" class="form-control">
                                    <option value="">All Employees</option>
                                    <?php while ($user = mysqli_fetch_assoc($usersResult)): ?>
                                    <option value="<?= $user['id'] ?>">
                                        <?= $user['name']?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-2 align-self-end">
                                <button type="submit" class="btn btn-info w-100">Filter</button>
                            </div>
                        </form>
                        <div class="card-body">
                            <table class="table table-bordered table-head-bg-info table-bordered-bd-info mt-4">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">Employee</th>
                                        <th scope="col" class="text-center">Date</th>
                                        <th scope="col" class="text-center">Check-in</th>
                                        <th scope="col" class="text-center">Check-out</th>
                                        <th scope="col" class="text-center">Status</th>
                                        <th scope="col" class="text-center">Edit</th>
                                        <th scope="col" class="text-center">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($resultData)): ?>
                                    <tr>
                                        <td><?= $row['name'] ?></td>
                                        <td><?= $row['date'] ?></td>
                                        <td><?= $row['check_in'] ?: '-' ?></td>
                                        <td><?= $row['check_out'] ?: '-' ?></td>
                                        <td><?= $row['status'] ?></td>
                                        <td>
                                            <a href="edit_attendance.php?id=<?= $row['id'] ?>"
                                                class="btn btn-info btn-sm">Edit</a>
                                        </td>
                                        <td>
                                            <a href="delete_attendance.php?id=<?= $row['id'] ?>"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure?')">Delete</a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
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