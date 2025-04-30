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
                    <div
                        class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between">
                        <h6 class="text-white text-capitalize ps-3 mx-auto">UPDATE USER LSS DATA </h6>
                        <a href="view_uploaded_lss.php">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <!-- icon name login only -->
                                <i class="material-icons opacity-10 fs-3">login</i>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="overlay"></div>
                    <div id="popupContainer" class="modal">
                        <div id="popupContent" class="modal-dialog">
                            <dialog id="dialog" class="modal-content">
                                <?php include 'message.php' ?><button id="closePopup"
                                    class="btn btn-info">Close</button>
                            </dialog>
                        </div>
                    </div>

                    <form role="form" method="POST" class="text-start" action="functions.php" autocomplete="off">
                        <?php
                        // GET USER DATA
                        if (isset($_GET['id'])) {
                            $lss_id = $_GET['id'];
                            $query = "SELECT useruploadfiles_lss.*,useruploads_lss.* FROM useruploads_lss INNER JOIN useruploadfiles_lss ON useruploads_lss.lssuploadid = useruploadfiles_lss.lssuploadid WHERE useruploads_lss.lssuploadid='$lss_id'";
                            $query_run = mysqli_query($con, $query);

                            if (mysqli_num_rows($query_run) > 0) {
                                foreach ($query_run as $lss)
                                ?>
                                <div class="row justify-content-center align-items-center g-3 my-3">
                                    <input type="text" value="<?= $lss_id ?>" name="id" hidden>
                                    <!-- <div class="col"> -->
                                    <h6>ID</h6>
                                    <div class="input-group input-group-outline col">
                                        <input type="text" name="lssuploadid" readonly class="form-control"
                                            style="cursor: not-allowed;" placeholder="NO DATA" value="<?= $lss['lssuploadid'] ?>">
                                    </div>
                                    <h6>LSSID</h6>
                                    <div class="input-group input-group-outline col">
                                        <input type="text" name="lssid" readonly class="form-control"
                                            style="cursor: not-allowed;" placeholder="NO DATA" value="<?= $lss['lssid'] ?>">
                                    </div>
                                    <!-- </div> -->
                                    <!-- <div class="col"> -->
                                    <h6>DESCRIPTION</h6>
                                    <div class="form-group input-group input-group-outline mb-3">
                                        <textarea name="description" class="form-control" rows="5"
                                            placeholder="NO DATA"><?= $lss['description'] ?></textarea>
                                    </div>
                                    <h6>SOURCENAME</h6>
                                    <div class="form-group input-group input-group-outline mb-3">
                                        <input type="text" name="source_name" class="form-control" value="<?= $lss['source_name']; ?>">
                                    </div>
                                    <h6>PUBLISHED DATE <span class="text-muted">(DD/MM/YYYY)</span></h6>
                                    <div class="form-group input-group input-group-outline mb-3">
                                        <input type="date" name="date_taken" id="date_taken" class="form-control" value="<?= $lss['date_taken'] != '' ? date('Y-m-d', strtotime($lss['date_taken'])) : '' ?>">
                                    </div>
                                    <h6>SOURCELINK</h6>
                                    <div class="form-group input-group input-group-outline mb-3">
                                       
                                        <input type="text" name="source_link" class="form-control" value="<?= $lss['source'] ?>">
                                         
                                    </div>
                                    <!-- </div> -->
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2"
                                        name="update_uploaded_lss"><strong><i class="fa-regular fa-pen-to-square me-1 fs-5"></i>Update Data</strong></button>
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


    <script>
        const openDiag = document.getElementById('dialog');
        const closeButton = document.getElementById('closePopup');
        const popupContainer = document.getElementById('popupContainer');
        const overlay = document.getElementById('overlay');

        if (openDiag.querySelector('div')) {
            openDiag.style.display = 'block';
            popupContainer.style.display = 'block';
            overlay.style.display = 'block';
        } else {
            openDiag.style.display = 'none';
        }

        closeButton.addEventListener('click', function () {
            openDiag.style.display = 'none';
            popupContainer.style.display = 'none';
            overlay.style.display = 'none';
        });
        const activePage = document.querySelector("a[href='view_uploaded_lss.php'")
        const activeDropdown =document.querySelector('lssManage');
        const lssManage = document.querySelector('a[aria-controls="manageLSS"]');
        const ncpMenu = document.getElementById('ncpMenu');
        activePage.classList.add('active', 'bg-gradient-primary');

        lssManage.style.backgroundColor = 'rgba(199, 199, 199, 0.2)';
        ncpMenu.classList.add('d-none');


        const datePicker = document.getElementById("date_taken");
        datePicker.addEventListener('click', ()=>{
            datePicker.showPicker();
        })
    </script>


    <?php

    include 'includes/footer.php';
    include 'includes/scripts.php';
    ?>