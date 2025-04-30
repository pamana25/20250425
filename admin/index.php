<?php
include 'includes/security.php';
include 'includes/connection.php';
include 'includes/header.php';
include 'includes/navbar.php';
include 'includes/functions.php';


// //count all users -- function to count all users is in the functions.php -- FVT
// $query = "SELECT userid FROM users WHERE usertype='user' ORDER BY userid";
// $query_run = mysqli_query($con, $query);
// $row = mysqli_num_rows($query_run);



//page views
$page_id = 1;
$visitor_ip = $_SERVER['REMOTE_ADDR']; // stores IP address of visitor in variable
add_view($con, $visitor_ip, $page_id);
$total_website_views = total_views($con); // Returns total website views

?>

<!-- content  -->
<div class="container-fluid py-4">
    <div class="row min-vh-80 h-100">
        
        <!-- <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">weekend</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Website Views</p>
                        <h4 class="mb-0"><?= $total_website_views ?></h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+55% </span>than last week</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Today's Users</p>
                        <h4 class="mb-0">3</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0"><span class="text-success text-sm font-weight-bolder"> 5% </span>than last month</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">New Users</p>
                        <h4 class="mb-0">2</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">-2%</span> than yesterday</p>
                </div>
            </div>
        </div> -->
        
        <!-- ALL USERS COUNT -->
        <div class="col-xl-4 col-sm-6">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Users</p>
                            <h4 class="mb-0"><?= count_all_users($con); ?></h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                        <p class="mb-0"><span class="text-success text-sm font-weight-bolder">Total no. of Registrants</span></p>
                    </div>
                </div>
            </div>
        <!-- ALL USERS COUNT -->  

        <!-- ALL TO BE REVIEWED COUNT -->
            <div class="col-xl-4 col-sm-6">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Requests</p>
                            <h4 class="mb-0"><?= count_all_tobereviewed_files_npc($con) + count_all_tobereviewed_files_lss($con); ?></h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                        <p class="mb-0"><span class="text-success text-sm font-weight-bolder">Total no. of To Be Reviewed Uploads</span></p>
                    </div>
                </div>
            </div>
        <!-- ALL TO BE REVIEWED COUNT -->  

        <!-- ALL APPROVED FILES COUNT -->
            <div class="col-xl-4 col-sm-6">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Gallery</p>
                            <h4 class="mb-0"><?= count_all_approved_files_npc($con) + count_all_approved_files_lss($con); ?></h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                        <p class="mb-0"><span class="text-success text-sm font-weight-bolder">Total no. of Approved Uploads</span></p>
                    </div>
                </div>
            </div>
        <!-- ALL APPROVED FILES COUNT -->    

        <!-- <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">downloading</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">File Count</p>
                        <h4 class="mb-0"><?= $row ?></h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3 d-flex align-items-center">
                    <form action="functions.php" method="post" class="mb-0 text-center mx-auto">
                        <button type="submit" name="file_export" class="badge-green btn bg-gradient-success text-white text-sm font-weight-bolder mb-0"> EXPORT </button>
                    </form>
                </div>
            </div>
        </div> -->
    </div>
</div>








<?php

include 'includes/footer.php';
include 'includes/scripts.php';
?>

<script>
        const activePage =document.querySelector("a[href='index.php'")
        activePage.classList.add('active','bg-gradient-primary');
        const lssMenu = document.getElementById('lssMenu');
    const ncpMenu = document.getElementById('ncpMenu');
    ncpMenu.classList.add('d-none');
    lssMenu.classList.add('d-none');
    </script>