<!-- including Header -->
<?php 
 include("theme/config.php");
?>


<?php 
 
function addNotification($user_id, $message) {
    global $conn;
    $sql = "INSERT INTO `notification` (user_id, message) VALUES ('$user_id', '$message')";
    $result = mysqli_query($conn , $sql);
}
?>