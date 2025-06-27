<?php
include 'includes/security.php';
include 'includes/connection.php';
include 'includes/header.php';
include 'includes/navbar.php';

?>
<style type="text/css">
    a[href="tables.php"] {
        background-color: rgba(199, 199, 199, 0.2);
    }

    a[href="tables.php"] li {
        color: #FFF !important;
    }
</style>
<!-- contents  -->
<div class="container-fluid py-4">
    <div class="row min-vh-80 h-100">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">User table</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <?php include 'message.php'; ?>
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        role</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        email</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        password</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        status</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // $query = "SELECT users.*, user_login.* FROM users INNER JOIN user_login ON user_login.userid = users.userid WHERE users.usertype='user'";
                                // $query_run = mysqli_query($con, $query);
                                
                                // if (mysqli_num_rows($query_run) > 0) {
                                //     foreach ($query_run as $users) {
                                $results_per_page = 15; // Number of results per page
                                $query = "SELECT users.*, user_login.* FROM users INNER JOIN user_login ON user_login.userid = users.userid";
                                $query_run = mysqli_query($con, $query);
                                $total_results = mysqli_num_rows($query_run);
                                $total_pages = ceil($total_results / $results_per_page); // Total number of pages
                                
                                if (isset($_GET['page']) && is_numeric($_GET['page'])) {
                                    $current_page = $_GET['page'];
                                } else {
                                    $current_page = 1;
                                }

                                $offset = ($current_page - 1) * $results_per_page; // Offset for pagination
                                
                                $query .= " LIMIT $offset, $results_per_page";
                                $query_run = mysqli_query($con, $query);

                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $users) {
                                        ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <input type="text" value="<?= $users['userid'] ?>" name="id" hidden>
                                                    <div class="avatar avatar-sm me-3 border-radius-lg text-dark">
                                                        <i class="material-icons opacity-10">person</i>
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm" name="name">
                                                            <?= $users['firstname'] . " " . $users['lastname']; ?>
                                                        </h6>
                                                        <p class="text-xs text-secondary mb-0">
                                                            <?= $users['email']; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    <?= $users['usertype']; ?>
                                                </p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-info">
                                                    <?= $users['email']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <p class="text-xs text-center font-weight-bold mb-0">
                                                    <?= $users['password']; ?>
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-xs text-center font-weight-bold mb-0">
                                                    <?php if ($users['deleted'] == 0) {
                                                        echo "Active";
                                                    } else {
                                                        echo "Inactive";
                                                    } ?>
                                                </p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <!-- <a href="view_user.php?id=<?= $users['userid']; ?>" class="btn btn-info btn-sm">View</a> -->
                                                <a href="update_user.php?id=<?= $users['userid']; ?>"
                                                    class="btn btn-info btn-sm">View/Edit</a>
                                                <form action="functions.php" method="POST" class="d-inline">
                                                    <button type="submit" name="delete_user" value="<?= $users['userid']; ?>"
                                                        class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php }
                                } else {
                                    echo "<h5> No Record Found </h5>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <ul class="pagination justify-content-center my-4">
                    <?php
                    if ($total_pages > 1) {
                        if ($current_page > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page - 1) . '"><<</a></li>';
                        }

                        for ($i = 1; $i <= $total_pages; $i++) {
                            echo '<li class="page-item' . ($i == $current_page ? ' active' : '') . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                        }

                        if ($current_page < $total_pages) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page + 1) . '">>></a></li>';
                        }
                    }
                    ?>
                </ul>
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