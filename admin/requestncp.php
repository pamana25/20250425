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
                <input type="text" name="search" value="<?= isset($_GET['search']) && $_GET['search'] !='' ? $_GET['search'] : '' ?>" class="form-control" placeholder="Search by Property Name">
                <button type="submit" class="btn btn-primary m-0">Search</button>
            </div>
        </form>
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
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Uploader</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Property</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Description</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            SourceName</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            DateTaken</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Source</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Uploaded File</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT useruploads_ncp.*, useruploadfiles_ncp.*, ncp.* 
                                    FROM useruploads_ncp 
                                    INNER JOIN useruploadfiles_ncp ON useruploadfiles_ncp.ncpuploadid = useruploads_ncp.ncpuploadid 
                                    INNER JOIN ncp on useruploads_ncp.ncpid = ncp.ncpid
                                    WHERE (useruploads_ncp.status='0' OR useruploads_ncp.status IS NULL)";
                                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                                        $search = $_GET['search'];
                                        $search = filter_var($search, FILTER_SANITIZE_SPECIAL_CHARS);
                                        $query .= " AND ncpname LIKE '%$search%'";
                                    }
                                    $query .= " ORDER BY dateuploaded DESC";
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
                                                                <?= get_email_by_userid($con, $row['uploadedby']); ?>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <h6 class="mb-0 text-xxs text-dark text-wrap" style="width: 10rem;">
                                                        <?= $row['ncpname']; ?>
                                                    </h6>
                                                </td>
                                                <td>
                                                    <h6 class="mb-0 text-xxs text-dark text-wrap" style="width: 20rem;">
                                                        <?= $row['description']; ?>
                                                    </h6>
                                                </td>
                                                <td>
                                                    <h6 class="mb-0 text-xxs text-dark text-wrap" style="width: 5rem;">
                                                        <?= $row['source_name']; ?>
                                                    </h6>
                                                </td>
                                                <td>
                                                    <h6 class="mb-0 text-xxs text-dark text-wrap" style="width: 8rem;">

                                                        <?= $row['date_taken'] != '' ? date('M d, Y', strtotime($row['date_taken'])) : '<b class="text-danger">N/A</b>' ?>
                                                        
                                                    </h6>
                                                </td>
                                                <td>
                                                    <h6 class="mb-0 text-xxs text-dark text-wrap" style="width: 20rem;">

                                                       <?= $row['source'] != '' ? '<a href="'.$row['source'].'" target="_blank" class="text-primary">'.$row['source'].'</a>' : 'Owned'; ?>
                                                        
                                                    </h6>
                                                </td>
                                                <td>
                                                    <h6 class="mb-0 text-xxs text-dark text-wrap" style="width: 5rem">
                                                        <a class="text-xxs text-wrap" target="_blank" href="<?= "../" . $row['ncppath'] . $row['ncpfile']; ?>">
                                                            <?= $row['ncpfile']; ?>
                                                        </a>
                                                    </h6>
                                                </td>
                                                <td class="align-middle text-center text-sm align-items-center">
                                                    <button name="ncprequest_approve" value="<?= $row['ncpuploadid'] ?>" class="btn btn-success btn-sm mb-0 text-xxs mb-0">Approved</button>

                                                    <a name="" onclick="setNcpUploadId('<?= $row['ncpuploadid'] ?>')" id="showModal" class="btn btn-danger btn-sm mb-0 text-xxs mb-0">Disapproved</a>

                                                    <!-- <button name="ncprequest_disapprove" value="<?= $row['ncpuploadid'] ?>"
                                                        class="btn btn-danger btn-sm mb-0 text-xxs mb-0">Disapproved</button> -->
                                                </td>

                                            </tr>
                                    <?php }
                                    } else {
                                        echo '
                                            <tr>
                                                <td colspan ="8" class="text-center"><span>No record found</span></td>
                                            </tr>
                                        ';
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
            <!-- NCP REQUESTS -->
            <dialog id="email_actions" class="w-50 h-50 zindex-modal p-5" style="z-index: 5; position: absolute; top: 50%; left:50%; transform: translate(-50%,-50%);">
                <div class="d-flex gap-2 flex-column w-100 p-3">
                    <h5 class="text-center text-uppercase">Actions to user uploader</h5>
                    <div class="form-check d-flex gap-3 align-items-center p-0">
                        <input class="form-check-input m-0" type="radio" name="email_value" value="1" id="flexRadioDefault1" style="margin-left: 0!important;">
                        <label class="form-check-label m-0  text-wrap" for="flexRadioDefault1">
                            The image uploaded is a corrupted file
                        </label>
                    </div>
                    <div class="form-check d-flex gap-3 align-items-center m-0 p-0">
                        <input class="form-check-input m-0" type="radio" name="email_value" value="2" id="flexRadioDefault2" style="margin-left: 0!important;">
                        <label class="form-check-label m-0  text-wrap" for="flexRadioDefault2">
                            The image uploaded does not match the Category and Property it is uploaded
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
                    <button name="send_ncp_dissaprove_email" id="send_ncp_dissaprove_email" type="submit" value="" class="btn btn-success btn-sm mb-0 text-xxs mb-0 w-25">Send</button>
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
        const activePage = document.querySelector("a[href='requestncp.php'")
        activePage.classList.add('active', 'bg-gradient-primary');
        const activeDropdown = document.querySelector('ncpManage');
        const ncpManage = document.querySelector('a[aria-controls="manageNCP"]');
        const lssMenu = document.getElementById('lssMenu');
        activePage.classList.add('active', 'bg-gradient-primary');

        ncpManage.style.backgroundColor = 'rgba(199, 199, 199, 0.2)';
        lssMenu.classList.add('d-none');



        const closeModal = document.getElementById("closeModal");
        const sendButton = document.getElementById('send_ncp_dissaprove_email')
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