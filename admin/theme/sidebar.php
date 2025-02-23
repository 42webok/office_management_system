<!-- sidebar code here -->
<div class="sidebar">
    <div class="scrollbar-inner sidebar-wrapper">
        <?php 
                      $sql = "SELECT * FROM users WHERE id = ".$_SESSION['login_id'];
                      $result = mysqli_query($conn, $sql);
                      while( $row = mysqli_fetch_assoc($result)){
      
                      ?>
        <div class="user">
            <div class="photo">

                <?php 
                         if(empty($row['image'])){
                            echo '<img src="../assets/img/avatar7.png">';
                         }else{
                         ?>
                <img src="uploads/<?php echo $row['image']; ?>">
                <?php 
                         }
                             ?>
            </div>
            <div class="info">
                <a class="" data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                    <span>
                        <?php echo $row['name']; ?>
                        <span class="user-level"><?php echo $row['role']== 1 ? 'Admin' : 'Employee'; ?></span>
                        <span class="caret"></span>
                    </span>
                </a>
                <div class="clearfix"></div>

                <div class="collapse in" id="collapseExample" aria-expanded="true">
                    <ul class="nav">
                        <li>
                            <a href="employee_profile.php">
                                <span class="link-collapse">My Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="logout.php">
                                <span class="link-collapse">Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <?php 
             }
            ?>
        <ul class="nav">
            <li class="nav-item custom_nav active">
                <a href="dashboard.php">
                    <i class="la la-dashboard"></i>
                    <p>Dashboard</p>
                    <!-- <span class="badge badge-count">5</span> -->
                </a>
            </li>
            <li class="nav-item custom_nav">
                <a href="manage_employee.php">
                    <i class="la la-users"></i>
                    <p>Manage Employees</p>
                    <!-- <span class="badge badge-count">14</span> -->
                </a>
            </li>
            <li class="nav-item custom_nav">
                <a href="manage_tasks.php">
                    <i class="la la-tasks"></i>
                    <p>Manage Tasks</p>
                    <!-- <span class="badge badge-count">50</span> -->
                </a>
            </li>
            <li class="nav-item custom_nav">
                <a href="my_tasks.php">
                    <i class="la la-suitcase"></i>
                    <p>My Tasks</p>
                    <!-- <span class="badge badge-count">50</span> -->
                </a>
            </li>
            <li class="nav-item custom_nav">
                <a href="my_attandance.php">
                    <i class="la la-th"></i>
                    <p>Attendance</p>
                    <!-- <span class="badge badge-count">6</span> -->
                </a>
            </li>
            <li class="nav-item custom_nav">
                <a href="get_leave.php">
                    <i class="la la-bell"></i>
                    <p>Leave Management</p>
                    <!-- <span class="badge badge-success">3</span> -->
                </a>
            </li>
            <li class="nav-item custom_nav">
                <a href="read_post.php">
                    <i class="la la-bullhorn"></i>
                    <p>Office Updates</p>
                    <!-- <span class="badge badge-danger">25</span> -->
                </a>
            </li>
            <li class="nav-item update-pro ">
                <a href="add_post.php" class="text-decoration-none p-0">
                    <button class="btn btn-info" >
                        <i class="la la-hand-pointer-o"></i>
                        <p>Create Post</p>
                    </button>
                </a>
            </li>
        </ul>
    </div>
</div>