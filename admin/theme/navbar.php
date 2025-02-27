<!-- Navbar code here -->
<?php 
include("theme/config.php");

$logo = "SELECT * FROM setting WHERE id = 1";
$logoResult = mysqli_query($conn, $logo);
$logo_img = mysqli_fetch_assoc($logoResult);
$mylogo = $logo_img['logo'];

?>
<div class="main-header">
    <div class="logo-header">
        <!-- <a href="index.html" class="logo"> -->
           <img src="uploads/<?php echo $mylogo ?>" alt="Logo" class="img-fluid mt-1 logo-img">
        <!-- </a> -->
        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
            data-target="collapse" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <button class="topbar-toggler more"><i class="la la-ellipsis-v"></i></button>
    </div>
    <nav class="navbar navbar-header navbar-expand-lg">
        <div class="container-fluid">

            <form class="navbar-left navbar-form nav-search mr-md-3" action="">
                <div class="input-group">
                    <input type="text" placeholder="Search ..." class="form-control">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="la la-search search-icon"></i>
                        </span>
                    </div>
                </div>
            </form>
            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                <li class="nav-item dropdown hidden-caret">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="la la-envelope"></i>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item dropdown hidden-caret">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       
                        <i class="la la-bell"></i>
                        <span class="notification" id="notify_batch">0</span>
                    </a>
                    <ul class="dropdown-menu notif-box" aria-labelledby="navbarDropdown">
                        <li>
                            <div class="dropdown-title">You have <span id="new_notify">0</span> new notification</div>
                        </li>
                        <li id="notify_list_data">
                            
                        </li>
                        <!-- <li>
                            <a class="see-all" href="javascript:void(0);"> <strong>See all notifications</strong> <i
                                    class="la la-angle-right"></i> </a>
                        </li> -->
                    </ul>
                </li>
                <li class="nav-item dropdown">
                <?php 
                      $sql = "SELECT * FROM users WHERE id = ".$_SESSION['login_id'];
                      $result = mysqli_query($conn, $sql);
                      while( $row = mysqli_fetch_assoc($result)){
      
                      ?>
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                    <?php 
                         if(empty($row['image'])){
                            echo '<img src="../assets/img/avatar7.png" alt="user-img" width="36" height="36px"
                            class="img-circle"><span>' . $row['name'] . '</span></span>';
                         }else{
                         ?>
                          <img src="uploads/<?php echo $row['image']; ?>" alt="user-img" height="36px" width="36"
                          class="img-circle"><span><?php echo $row['name'] ?></span></span>
                         <?php 
                         }
                             ?>
                        </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                            <div class="user-box">
                            <?php 
                                             if(empty($row['image'])){
                                             echo '<div class="u-img"><img src="../assets/img/avatar7.png" alt="user"></div>';
                                             }else{
                                            ?>
                                            <div class="u-img"><img src="uploads/<?php echo $row['image']; ?>" alt="user"></div>
                                            <?php 
                                             }
                             ?>
                               
                                <div class="u-text">
                                    <h4><?php echo $row['name'] ?></h4>
                                    <p class="text-muted"><?php echo $row['email'] ?></p>
                                </div>
                            </div>
                            <?php 
                      }
                            ?>
                        </li>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="employee_profile.php"><i class="ti-user"></i> My Profile</a>
                        <!-- <div class="dropdown-divider"></div> -->
                       <?php 
                       
                         if($_SESSION['role'] == 1){
                            ?>
                             <a class="dropdown-item" href="setting.php"><i class="ti-settings"></i>Setting</a>
                            <?php 
                         }
                       ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php"><i class="fa fa-power-off"></i> Logout</a>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
            </ul>
        </div>
    </nav>
</div>
