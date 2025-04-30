<?php
include 'includes/security.php';
include 'includes/header.php';
include 'includes/navbar.php';
include 'includes/functions.php';


?>

<div class="container-fluid py-4">
    <div class="row min-vh-80 h-100">
        <form method="GET" action="" autocomplete="off">
            <div class="input-group input-group-outline mx-auto w-50 pb-3">
                <input type="text" name="search" class="form-control" value="<?= isset($_GET['search']) && $_GET['search'] != '' ? $_GET['search'] : '' ?>" placeholder="Search by Property Name">
                <button type="submit" class="btn btn-primary m-0">Search</button>
            </div>
        </form>
        <form method="POST" action="functions.php">
            <!-- NCP REQUESTS -->
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Request Table (NCP DATA)</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <?php include 'message.php'; ?>
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Uploaded By</th>
                                        <th
                                            class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Property</th>
                                        <th
                                            class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Area Name</th>
                                        <th
                                            class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Date Uploaded</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                     $query = "SELECT ncp.ncpid, users.email, ncp.ncpname, areas.areaname, ncp.ncpofficialname, ncp.dateupload FROM ncp INNER JOIN areas ON ncp.areaid = areas.areaid INNER JOIN users ON ncp.uploadedbyuser = users.userid WHERE uploadstatus = 0";
                                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                                        $search = $_GET['search'];
                                        $search = filter_var($search, FILTER_SANITIZE_SPECIAL_CHARS);
                                        // $search = mysqli_real_escape_string($con, $_GET['search']);
                                        $query .= " AND ncpname LIKE '%$search%'";
                                    }
                                    $query .= " ORDER BY dateupload DESC";
                                    $query_run = mysqli_query($con, $query);
                                    $results_per_page = 10; // Number of results per page
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
                                                                <?= $row['email'] ?>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <h6 class="mb-0 text-xxs text-dark text-uppercase  text-wrap" style="width: 10rem;">
                                                        <?= $row['ncpname']; ?>
                                                    </h6>
                                                </td>
                                                <td>
                                                    <h6 class="mb-0 text-xxs text-dark text-uppercase text-wrap" style="width: 5rem;">
                                                        <?= $row['areaname']; ?>
                                                    </h6>
                                                </td>
                                                <td>
                                                    <h6 class="mb-0 text-xxs text-dark text-wrap" style="width: 5rem; text-transform:capitalize">
                                                        <?=date('M d, Y', strtotime($row['dateupload']))?>
                                                    </h6>
                                                </td>
                                               
                                                
                                             
                                                <td class="align-middle text-center text-sm align-items-center">
                                                    
                                                    <a href="functions.php?ncp_approve_id= <?php echo $row['ncpid']; ?>" class="btn btn-success btn-sm mb-0 text-xxs mb-0">Approved</a>

                                                    <a href="ncpviewdatarequest.php?ncpid=<?= $row['ncpid'] ?>" class="btn btn-info btn-sm mb-0 text-xxs bm-0">View</a>

                                                    <a name="" onclick="setNcpUploadId('<?= $row['ncpid'] ?>')" id="showModal" class="btn btn-danger btn-sm mb-0 text-xxs mb-0">Disapproved</a>

                                                    <!-- <button name="ncprequest_disapprove" value="<?= $row['ncpuploadid'] ?>"
                                                        class="btn btn-danger btn-sm mb-0 text-xxs mb-0">Disapproved</button> -->
                                                </td>

                                            </tr>
                                    <?php }
                                    } else {
                                        echo '<td colspan = "8" class= "text-center">No record found</td>';
                                    }
                                    ?>
                                </tbody>
                            </table>
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
                </div>
            </div>
            <!-- NCP REQUESTS MODAL-->
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
                        <input class="form-check-input m-0" type="radio" name="email_value" value="4" id="flexRadioDefault3" style="margin-left: 0!important;">
                        <label class="form-check-label m-0  text-wrap" for="flexRadioDefault4">
                            Other:
                        </label>
                        <textarea name="email_value_other" class="w-100"></textarea>
                    </div>
                </div>


                <div class="text-center">
                    <button name="send_ncp_data_disapprove_email" id="send_ncp_data_disapprove_email" type="submit" value="" class="btn btn-success btn-sm mb-0 text-xxs mb-0 w-25">Send</button>
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
        const activePage = document.querySelector("a[href='ncpdatarequest.php'")
        activePage.classList.add('active', 'bg-gradient-primary');
        const activeDropdown = document.querySelector('ncpManage');
        const ncpManage = document.querySelector('a[aria-controls="manageNCP"]');
        const lssMenu = document.getElementById('lssMenu');
        activePage.classList.add('active', 'bg-gradient-primary');

        ncpManage.style.backgroundColor = 'rgba(199, 199, 199, 0.2)';
        lssMenu.classList.add('d-none');



        const closeModal = document.getElementById("closeModal");
        const sendButton = document.getElementById('send_ncp_data_disapprove_email')
        const showModal = document.getElementById("showModal");

        const dialogInfo = document.getElementById("email_actions");
        dialogInfo.close();
        closeModal.addEventListener('click', () => {
            dialogInfo.close();
        })

        function setNcpUploadId(ncpid) {
            sendButton.value = ncpid
            dialogInfo.showModal();
        }
    </script>