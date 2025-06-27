<?php
include 'includes/security.php';
include 'includes/header.php';
include 'includes/navbar.php';
include 'includes/functions.php';


?>

<div class="container-fluid py-4">
    <div class="row min-vh-80 h-100">
        <form method="POST" action="functions.php">
            <!-- NCP REQUESTS -->    
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Request Table (NCP)</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <?php include 'message.php'; ?>
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Property</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Description</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Uploaded File</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $query = "SELECT useruploads_ncp.*, useruploadfiles_ncp.* FROM useruploads_ncp INNER JOIN useruploadfiles_ncp ON useruploadfiles_ncp.ncpuploadid = useruploads_ncp.ncpuploadid WHERE useruploads_ncp.status IS NULL ORDER BY dateuploaded DESC";
                                        $query_run = mysqli_query($con, $query);

                                        if (mysqli_num_rows($query_run) > 0) {
                                            foreach ($query_run as $row) {
                                    ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm"><?= get_email_by_userid($con, $row['uploadedby']); ?></h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <h6 class="mb-0 text-sm text-dark"><?= get_propertyname_by_ncp_id($con, $row['ncpid']); ?></h6>
                                            </td>
                                            <td>
                                                <h6 class="mb-0 text-sm text-dark"><?= $row['description']; ?></h6>
                                            </td>
                                            <td>
                                                <a class="text-sm" target="_blank" href="<?= "../".$row['ncppath'].$row['ncpfile']; ?>"><?= $row['ncpfile']; ?></a>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <button name="ncprequest_approve" value="<?= $row['ncpuploadid'] ?>" class="btn btn-success btn-sm">Approved</button>
                                                <button name="ncprequest_disapprove" value="<?= $row['ncpuploadid'] ?>" class="btn btn-danger btn-sm">Disapproved</button>
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
                    </div>
                </div>
            <!-- NCP REQUESTS -->                    

            <!-- LSS REQUESTS -->                
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Request Table (LSS)</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <?php include 'message.php'; ?>
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Site</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Description</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Uploaded File</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $query_b = "SELECT useruploads_lss.*, useruploadfiles_lss.* FROM useruploads_lss INNER JOIN useruploadfiles_lss ON useruploadfiles_lss.lssuploadid = useruploads_lss.lssuploadid WHERE useruploads_lss.status IS NULL ORDER BY dateuploaded DESC";
                                        $query_run_b = mysqli_query($con, $query_b);

                                        if (mysqli_num_rows($query_run_b) > 0) {
                                            foreach ($query_run_b as $row_b) {
                                    ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm"><?= get_email_by_userid($con, $row_b['uploadedby']); ?></h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <h6 class="mb-0 text-sm text-dark"><?= get_sitename_by_lss_id($con, $row_b['lssid']); ?></h6>
                                            </td>
                                            <td>
                                                <h6 class="mb-0 text-sm text-dark"><?= $row_b['description']; ?></h6>
                                            </td>
                                            <td>
                                                <a class="text-sm target="_blank" href="<?= "../".$row_b['lsspath'].$row_b['lssfile']; ?>"><?= $row_b['lssfile']; ?></a>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <button name="lssrequest_approve" value="<?= $row_b['lssuploadid'] ?>" class="btn btn-success btn-sm">Approved</button>
                                                <button name="lssrequest_disapprove" value="<?= $row_b['lssuploadid'] ?>" class="btn btn-danger btn-sm">Disapproved</button>
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
                    </div>
                </div>
            <!-- LSS REQUESTS -->
        
        </form>
    </div>







    <?php

    include 'includes/footer.php';
    include 'includes/scripts.php';

    ?>