<?php
include 'includes/security.php';
include 'includes/connection.php';
include 'includes/header.php';
include 'includes/navbar.php';

?>


<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between">
                        <h6 class="text-white text-capitalize ps-3">Update User Information</h6>
                        <a href="tables.php">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <!-- icon name login only -->
                                <i class="material-icons opacity-10 fs-3">login</i>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php include 'message.php' ?>
                    <form role="form" method="POST" class="text-start" action="functions.php" autocomplete="off">
                        <?php
                        // GET USER DATA
                        if (isset($_GET['id'])) {
                            $user_id = $_GET['id'];
                            $query = "SELECT users.*, user_login.* FROM users INNER JOIN user_login ON user_login.userid = users.userid WHERE users.userid='$user_id'";
                            $query_run = mysqli_query($con, $query);

                            if (mysqli_num_rows($query_run) > 0) {
                                foreach ($query_run as $users)
                        ?>
                                <div class="row justify-content-center align-items-center g-3 my-3">
                                    <input type="text" value="<?= $user_id ?>" name="id" hidden>
                                    <div class="col">
                                        <h6>First Name</h6>
                                        <div class="input-group input-group-outline col">
                                            <input type="text" name="firstname" class="form-control" placeholder="First Name" value="<?= $users['firstname'] ?>">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6>Last Name</h6>
                                        <div class="input-group input-group-outline">
                                            <input type="text" name="lastname" class="form-control" placeholder="Last Name" value="<?= $users['lastname'] ?>">
                                        </div>
                                    </div>
                                </div>
                                <h6>Username</h6>
                                <div class="input-group input-group-outline my-3">
                                    <input type="text" name="username" class="form-control" placeholder="Username" value="<?= $users['username'] ?>">
                                </div>
                                <h6>Email</h6>
                                <div class="input-group input-group-outline my-3">
                                    <input type="email" name="email" class="form-control" placeholder="Email" value="<?= $users['email'] ?>">
                                </div>
                                <h6>Password</h6>
                                <div class="input-group input-group-outline mb-3">
                                    <input type="password" disabled name="password" class="form-control" placeholder="Password" value="<?= $users['password'] ?>">
                                </div>
                                <h6>ROLE</h6>
                                <select class="input-group p-2 input-group-outline mb-3" name="usertype" required>
                                    <option selected value="<?= $users['usertype'] ?>">-- SELECT OPTION --</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2" name="update_user">Update User</button>
                                </div>
                        <?php
                            } else {
                                echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                <strong>Hey! There is no user record.
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
                            }
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>








    <?php

    include 'includes/footer.php';
    include 'includes/scripts.php';
    ?>

<script>
        const activePage =document.querySelector("a[href='tables.php'")
        activePage.classList.add('active','bg-gradient-primary');
        const lssMenu = document.getElementById('lssMenu');
    const ncpMenu = document.getElementById('ncpMenu');
    ncpMenu.classList.add('d-none');
    lssMenu.classList.add('d-none');
    </script>