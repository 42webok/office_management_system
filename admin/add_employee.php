<!-- including Header -->
<?php 
 include("theme/header.php");
 session_start();
 if(!isset($_SESSION['name'])){
    header("location:index.php");
    exit;
}
if($_SESSION['role'] == 0){
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
                <!-- <h4 class="page-title"></h4> -->

                <div class="row p-3">
                    <div class="card w-100">
                        <div class="card-header">
                            <div class="card-title">Add Employee</div>
                        </div>
                        <div class="card-body">
                            <form class="needs-validation" action="save_employee_data.php" id="myfrm" method="post"
                                novalidate>
                                <!-- Name Field -->
                                <div class="mb-4">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Name" id="name"
                                        name="name" required>
                                    <div class="invalid-feedback">
                                        Please enter your name.
                                    </div>
                                </div>
                                <!-- Email Field -->
                                <div class="mb-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" placeholder="Enter Email" id="email"
                                        name="email" required>
                                    <div class="invalid-feedback">
                                        Please enter a valid email address.
                                    </div>
                                </div>
                                <!-- Phone Field -->
                                <div class="mb-4">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="number" class="form-control" placeholder="Enter Phone Number"
                                        id="phone" name="phone" required>
                                    <div class="invalid-feedback">
                                        Please enter valid phone number.
                                    </div>
                                </div>
                                <!-- Password Field -->
                                <div class="mb-4">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" placeholder="Enter Password"
                                        id="password" name="password" required>
                                    <div class="invalid-feedback">
                                        Please enter password.
                                    </div>
                                </div>
                                <!-- Select Box -->
                                <div class="mb-4">
                                    <label for="options" class="form-label">Select Role</label>
                                    <div class="w-100">
                                        <select class="form-select w-100 form-control" id="options" name="options"
                                            required>
                                            <option value="" selected disabled>Choose Role</option>
                                            <option value="1">Admin</option>
                                            <option value="0">Normal Employee</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select an option.
                                        </div>
                                    </div>
                                </div>
                                <!-- Submit Button -->
                                <button type="submit" name="add_employee" class="btn btn-primary">Submit</button>
                            </form>
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




<script>

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
<?php 
	include("theme/script.php");	
?>

<script>
const urlParams = new URLSearchParams(window.location.search);
const status = urlParams.get('status');

if (status === 'error') {
    $.notify({
        icon: 'la la-user-secret',
        message: "Email already exist !"
    }, {
        type: "info",
        delay: 3000,
        placement: {
            from: "top",
            align: "center"
        }
    });
}

const url = new URL(window.location.href);
if (url.searchParams.has('status')) {
    url.searchParams.delete('status');
    window.history.replaceState({}, document.title, url.toString());
}
</script>