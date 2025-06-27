<?php
session_start();
include 'includes/connection.php';
include 'includes/header.php';

?>
<div class="page-header align-items-start min-vh-100"
    style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
    <span class="mask bg-gradient-dark opacity-6"></span>
    <div class="container my-auto">
        <div class="row min-vh-80 h-100">
            <div class="col-lg-4 col-md-8 col-12 m-auto">
                <div class="card z-index-0 fadeIn3 fadeInBottom">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                            <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Sign in
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form role="form" class="text-start" method="POST" action="functions.php" autocomplete="off">
                            <?php if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
                                echo '<h5 class="text-danger text-center"> ' . $_SESSION['status'] . '</h5>';
                                unset($_SESSION['status']);
                            } ?>
                            <div class="input-group input-group-outline my-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="input-group input-group-outline mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="input-group input-group-outline mb-3">
                                <div class="d-flex text-center align-items-center gap-2">
                                    <i class="fas fa-eye" id="showpass"></i>
                                    <i class="fas fa-eye-slash d-none" id="hidepass"></i>
                                    <span class="text-xxs">Show Password</span>
                                </div>
                            </div>
                            <!-- <div class="form-check form-switch d-flex align-items-center mb-3">
                                <input class="form-check-input" type="checkbox" id="rememberMe" checked>
                                <label class="form-check-label mb-0 ms-3" for="rememberMe">Remember me</label>
                            </div> -->
                            <div class="text-center">
                                <button type="submit" name="sign_in"
                                    class="btn bg-gradient-primary w-100 my-4 mb-2">Sign in</button>
                            </div>
                            <!-- <p class="mt-4 text-sm text-center">
                                Don't have an account?
                                <a href="sign_up.php" class="text-primary text-gradient font-weight-bold">Sign up</a>
                            </p> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const showpass = document.getElementById('showpass');
    const hidepass = document.getElementById('hidepass');
    const password = document.getElementsByName('password')[0]; // Use [0] to select the first element with the name 'password'

    showpass.addEventListener('click', () => {
        password.type = password.type === 'password' ? 'text' : 'password';
        showpass.classList.toggle('d-none');
        hidepass.classList.toggle('d-none');
    });
    hidepass.addEventListener('click', () => {
        password.type = password.type === 'password' ? 'text' : 'password';
        showpass.classList.toggle('d-none');
        hidepass.classList.toggle('d-none');
    });
</script>





<?php

include 'includes/footer.php';
include 'includes/scripts.php';
?>