<?php 
include("theme/header.php");
include("theme/config.php");
session_start();
if(isset($_SESSION['name'])){
    header("location:dashboard.php");
}
?>
<div class="form w-100 d-flex justify-content-center align-items-center"  id="index_login">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mx-auto">
                <div class="card p-4">
                    <h2 class="mb-4">Login</h2>
                    <form action="login_check.php" method="post">
                        <div class="input_box mb-4">
                            <input type="email" id="validationCustom01" name="email" placeholder="Email"
                                class="form-control" required>
                            <div class="invalid-feedback">
                                Please enter valid e-mail
                            </div>
                        </div>
                        <div class="input_box mb-4">
                            <input type="password" id="password" name="password" placeholder="Password"
                                class="form-control" required>
                            <div class="invalid-feedback">
                                Enter a valid password
                            </div>
                        </div>
                        <button type="submit" name="login" class="btn btn-info w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php 
include("theme/script.php");
?>

<script>

const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');

if (status === 'login_failed') {
    $.notify({
        icon: 'la la-hand-o-right',
        message: "Fail To Login !"
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