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
                <input type="text" name="search" value="<?= isset($_GET['search']) && $_GET['search'] != '' ? $_GET['search'] : '' ?>" class="form-control" placeholder="Search by Property Name">
                <button type="submit" class="btn btn-primary m-0">Search</button>
            </div>
        </form>
        <form method="POST" action="functions.php">
            <!-- LSS DATA -->

            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Manage Uploaded LSS</h6>
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
                                            Thumbnail</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            File Name</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Date Uploaded</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $results_per_page = 10; // Number of results per page

                                    $query = "SELECT useruploads_lss.*, lss.*, useruploadfiles_lss.*
                                    FROM useruploads_lss
                                    INNER JOIN lss ON useruploads_lss.lssid = lss.lssid
                                    INNER JOIN useruploadfiles_lss ON useruploads_lss.lssuploadid = useruploadfiles_lss.lssuploadid WHERE (useruploads_lss.status='1' OR useruploads_lss.status='2')";
                                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                                        // $search = $_GET['search'];
                                        $search = mysqli_real_escape_string($con,$_GET['search']);
                                        $query .= " AND lssname LIKE '%$search%'";
                                    }
                                    $query .= " ORDER BY dateuploaded DESC";
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
                                            <tr class="">
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
                                                    <h6 class="mb-0 text-xxs text-dark text-wrap" style="width: 15rem;">
                                                        <?= $row['lssname'] ?>
                                                    </h6>
                                                </td>
                                                <td>
                                                    <h6 class="mb-0 text-xxs text-dark text-wrap" style="width: 5rem;">
                                                    <img src="<?= "../" . $row['lsspath'] . $row['lssfile']; ?>" alt="" style="width:75px; height:75px;">
                                                    </h6>
                                                </td>
                                                <td>
                                                    <h6 class="mb-0 text-xxs text-dark text-wrap" style="width: 15rem;">
                                                        <a target="_blank" href="../useruploads/lss/<?= $row['lssfile'] ?>">
                                                            <?= $row['lssfile'] ?>
                                                        </a>
                                                    </h6>
                                                </td>
                                                <td>
                                                    <h6 class="mb-0 text-xxs text-dark text-wrap" style="width: 7rem;">
                                                        <?= $row['dateuploaded'] ?>
                                                    </h6>
                                                </td>

                                                <td class="align-middle text-center text-sm align-items-center">
                                                    <a href="manage_uploaded_lss.php?id=<?= $row['lssuploadid']; ?>" class="btn btn-info btn-sm mb-0">View/Edit</a>
                                                    <form action="functions.php" method="POST" class="d-inline" data-id="delete">
                                                        <button type="button" class="btn btn-danger btn-sm m-0" onclick="openDialog(<?= $row['lssuploadid'] ?>)">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                    <?php }
                                    } else {
                                        echo '<tr>
                                            <td colspan="6" class= "text-center" ><span class="text-center">No record found</span></td>
                                        </tr>';
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

        </form>
        <dialog id="deletePrompt" class="dialog">
            <div class="dialog-content p-4">
                <h4>Confirmation</h4>
                <p>Are you sure you want to delete?</p>
                <div class="dialog-actions">
                    <input type="hidden" name="page" value="<?php echo $pagination_link . $current_page ?>">
                    <input type="hidden" name="lssuploadid" id="lssuploadid" value="">
                    <button type="submit" name="delete_uploaded_lss" id="delete_uploaded_lss" class="btn btn-danger btn-sm m-0">Delete</button>
                    <p id="cancel-delete" class="btn btn-secondary btn-sm m-0">Cancel</p>
                </div>
            </div>
        </dialog>
    </div>







    <?php

    include 'includes/footer.php';
    include 'includes/scripts.php';

    ?>


    <script>
        const activePage = document.querySelector("a[href='view_uploaded_lss.php'")
        activePage.classList.add('active', 'bg-gradient-primary');
        const dialog = document.getElementById('deletePrompt');
        const lssuploadidInput = document.getElementById('lssuploadid');
        const dialogSumbit = document.getElementById('delete_uploaded_lss');
        const dialogCancel = document.getElementById('cancel-delete');

        function openDialog(id) {
            lssuploadidInput.value = id;
            dialog.showModal();
        }

        dialogCancel.addEventListener('click', () => {
            dialog.close();
        })
        dialogSumbit.addEventListener('click', () => {
            submit();
        })

        const activeDropdown = document.querySelector('lssManage');
        const lssManage = document.querySelector('a[aria-controls="manageLSS"]');
        const ncpMenu = document.getElementById('ncpMenu');
        activePage.classList.add('active', 'bg-gradient-primary');

        lssManage.style.backgroundColor = 'rgba(199, 199, 199, 0.2)';
        ncpMenu.classList.add('d-none');
    </script>