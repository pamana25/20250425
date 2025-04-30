<?php
include 'includes/security.php';
include 'includes/header.php';
include 'includes/navbar.php';
include 'includes/functions.php';


?>

<div class="container-fluid py-4">
    <div class="row min-vh-80 h-100">
        <form method="GET" action="" id="searchData">
            <div class="input-group input-group-outline mx-auto w-50 pb-3">
                <input type="text" name="search" value="<?= isset($_GET['search']) && $_GET['search'] != '' ? $_GET['search'] : '' ?>" class="form-control" placeholder="Search by property name or areaname">
                <button type="submit" class="btn btn-primary m-0">Search</button>
            </div>
        </form>
        <form method="POST" action="functions.php">
            <!-- LSS DATA -->

            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Manage Data Table (LSS)</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <?php include 'message.php'; ?>
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <!-- <button class="btn btn-white btn-sm position-absolute" style="margin-top: -.6rem;"><i class="fa-solid fa-arrow-up-wide-short text-primary"></i></button> -->
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            uploaded by
                                            <?php
                                            if(isset($_GET['filter_uploaded_by'])){
                                                echo '<a href="managelss.php?filter_uploaded_by"><i class="fa-solid fa-arrow-up-wide-short text-primary"></i></a>';
                                            }else{
                                                echo '<a href="managelss.php?filter_uploaded_by"><i class="fa-solid fa-arrow-down-short-wide"></i></a>';
                                            }
                                            ?>

                                            <!-- <a href="managelss.php?<?= isset($_GET['search']) == '' ? 'filter_uploaded_by' :'search='.$_GET['search'].'&filter_uploaded_by' ?>"><i class="fa-solid fa-arrow-up-wide-short text-primary"></i></a> -->
                                             </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Property</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Area Name</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            approved by</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            date approved</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <?php

                                    $results_per_page = 10; // Number of results per page
                                    $query = "SELECT lss.lssid, uploader.email AS uploader_email, 
                                    lss.lssname, updater.firstname AS updater_firstname, 
                                    updater.lastname AS updater_lastname, 
                                    lss.uploadstatusdate, areas.areaname 
                                    FROM lss 
                                    INNER JOIN users AS uploader ON lss.uploadedbyuser = uploader.userid 
                                    INNER JOIN users AS updater ON lss.uploadstatusby = updater.userid INNER JOIN areas ON lss.areaid = areas.areaid
                                    WHERE uploadstatus = 1";
                                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                                        // $search = $_GET['search'];
                                        $search = mysqli_real_escape_string($con, $_GET['search']);
                                        $query .= " AND lssname LIKE '%$search%' OR areas.areaname LIKE '%$search%'";
                                    } else if (isset($_GET['filter_uploaded_by'])) {
                                        $query .= " ORDER BY uploader_email DESC";
                                    } else {
                                        $query .= " ORDER BY lss.uploadstatusdate DESC";
                                    }
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
                                        foreach ($query_run as $row) {
                                    ?>
                                            <tr>
                                                <td class="">
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-xxs text-wrap" style="width: 10rem;">
                                                                <?= $row['uploader_email'] ?>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <h6 class="mb-0 text-xxs text-dark text-wrap" style="width: 10rem; text-transform:capitalize">
                                                        <?= $row['lssname']; ?>
                                                    </h6>
                                                </td>
                                                <td>
                                                    <h6 class="mb-0 text-xxs text-dark text-wrap" style="width: 8rem; text-transform:capitalize">
                                                        <?= $row['areaname']; ?>
                                                    </h6>
                                                </td>

                                                <td>
                                                    <h6 class="mb-0 text-xxs text-dark text-wrap" style="width: 10rem; text-transform:capitalize">
                                                        <?= $row['updater_firstname'] . ' ' . $row['updater_lastname']; ?>
                                                    </h6>
                                                </td>
                                                <td>
                                                    <h6 class="mb-0 text-xxs text-dark text-wrap" style="width: 10rem; text-transform:capitalize">
                                                        <?= date('M d, Y', strtotime($row['uploadstatusdate'])) ?>
                                                    </h6>
                                                </td>
                                                <td class="align-middle text-center text-sm align-items-center">
                                                    <a href="update_lss.php?id=<?= $row['lssid']; ?>" class="btn btn-info btn-sm">View/Edit</a>

                                                    <a onclick="setLssid('<?= $row['lssid'] ?>')" id="showModal" class="btn btn-danger btn-sm">Remove</a>
                                                </td>
                                            </tr>
                                    <?php }
                                    } else {
                                        echo "<tr><td colspan='5'><h5 class='text-center'>No record found</h5></td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <ul class="pagination justify-content-center my-4">
                <?php
                $pagination_link = "";
                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $search = $_GET['search'];
                    $pagination_link = "?search=$search&page=";
                } else {
                    $pagination_link = "?page=";
                }

                // Set the maximum number of pages to display
                $max_pages = 8;

                if ($total_pages > 1) {
                    if ($current_page > 1) {
                        echo '<li class="page-item"><a class="page-link" href="' . $pagination_link . ($current_page - 1) . '"><<</a></li>';
                    }

                    // Calculate the range of pages to display
                    $start_page = max($current_page - floor($max_pages / 2), 1);
                    $end_page = min($start_page + $max_pages - 1, $total_pages);

                    for ($i = $start_page; $i <= $end_page; $i++) {
                        echo '<li class="page-item' . ($i == $current_page ? ' active' : '') . '"><a class="page-link" href="' . $pagination_link . $i . '">' . $i . '</a></li>';
                    }

                    if ($current_page < $total_pages) {
                        echo '<li class="page-item"><a class="page-link" href="' . $pagination_link . ($current_page + 1) . '">>></a></li>';
                    }
                }
                ?>
            </ul>
            <!-- LSS DATA -->
            <!-- LSS REQUESTS MODAL-->
            <dialog id="email_actions" class="w-50 h-50 zindex-modal p-5" style="z-index: 5; position: absolute; top: 50%; left:50%; transform: translate(-50%,-50%);">
                <div class="d-flex gap-2 flex-column w-100 p-3">
                    <h5 class="text-center text-uppercase">Actions to user uploader</h5>

                    <div class="form-check d-flex gap-3 align-items-center m-0 p-0">
                        <input class="form-check-input m-0" type="radio" name="email_value" value="2" id="flexRadioDefault2" style="margin-left: 0!important;">
                        <label class="form-check-label m-0  text-wrap" for="flexRadioDefault2">
                            The property uploaded does not match the Category and Property it is uploaded
                        </label>
                    </div>
                    <div class="form-check d-flex gap-3 align-items-center m-0 p-0">
                        <input class="form-check-input m-0" type="radio" name="email_value" value="3" id="flexRadioDefault3" style="margin-left: 0!important;">
                        <label class="form-check-label m-0  text-wrap" for="flexRadioDefault3">
                            There is insufficient or no information provided by user along with their content
                        </label>
                    </div>
                    <div class="form-check d-flex gap-3 align-items-center m-0 p-0">
                        <input class="form-check-input m-0" type="radio" name="email_value" value="Other" id="flexRadioDefault4" style="margin-left: 0!important;">
                        <label class="form-check-label m-0  text-wrap" for="flexRadioDefault4">
                            Other:
                        </label>
                        <textarea name="email_value_other" class="w-100"></textarea>
                    </div>
                </div>


                <div class="text-center">
                    <button name="delete_lss_and_send_email" id="delete_lss_and_send_email" type="submit" value="" class="btn btn-success btn-sm mb-0 text-xxs mb-0 w-25">Send</button>
                    <a name="closeModal" id="closeModal" class="btn btn-danger btn-sm mb-0 text-xxs mb-0 w-25">Cancel</a>
                </div>
            </dialog>

        </form>
    </div>







    <?php

    include 'includes/footer.php';
    include 'includes/scripts.php';

    ?>


    <script>
        const activePage = document.querySelector("a[href='managelss.php'")
        activePage.classList.add('active', 'bg-gradient-primary');
        const activeDropdown = document.querySelector('lssManage');
        const lssManage = document.querySelector('a[aria-controls="manageLSS"]');
        const ncpMenu = document.getElementById('ncpMenu');
        activePage.classList.add('active', 'bg-gradient-primary');

        lssManage.style.backgroundColor = 'rgba(199, 199, 199, 0.2)';
        ncpMenu.classList.add('d-none');

        const closeModal = document.getElementById("closeModal");
        const sendButton = document.getElementById('delete_lss_and_send_email')
        const showModal = document.getElementById("showModal");

        const dialogInfo = document.getElementById("email_actions");
        dialogInfo.close();
        closeModal.addEventListener('click', () => {
            dialogInfo.close();
        })

        function setLssid(lssid) {
            sendButton.value = lssid
            dialogInfo.showModal();
        }


        // fetch("./functions.php", {
        //         method: "POST",
        //         header: {
        //             "Content-Type": "application/x-www-form-urlencoded"
        //         },
                
        //     }).then(res => res.json())
        //     .then(data => console.log(data));
    </script>