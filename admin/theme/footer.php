<!-- footer code here -->
<?php 
include("theme/config.php");

$footerQuery = "SELECT * FROM setting WHERE id = 1";
$footerResult = mysqli_query($conn, $footerQuery);
$footer_txt = mysqli_fetch_assoc($footerResult);

?>
<footer class="footer">
    <div class="container-fluid d-flex justify-content-center align-items-center">
        <div class="copyright">
        &copy; <?php echo date('Y'); ?> , made by <a href="<?php echo $footer_txt['url'] ?>" target='_blank' > <?php echo $footer_txt['footer']; ?> </a>
        </div>
    </div>
</footer>