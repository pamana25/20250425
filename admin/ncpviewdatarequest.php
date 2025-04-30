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
                        <h6 class="text-white text-capitalize ps-3 mx-auto">VIEW NCP DATA REQUEST </h6>
                        <a href="ncpdatarequest.php">
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
                        if (isset($_GET['ncpid'])) {
                            $ncp_id = $_GET['ncpid'];
                            $query = "SELECT * FROM ncp WHERE ncpid='$ncp_id' AND uploadstatus = 0";
                            $query_run = mysqli_query($con, $query);

                            if (mysqli_num_rows($query_run) > 0) {
                                foreach ($query_run as $ncp)
                                ?>
                                <div class="row justify-content-center align-items-center g-3 my-3">
                                    <input type="text" value="<?= $ncp_id ?>" name="id" hidden>
                                    <!-- <div class="col"> -->
                                    <h6>ID</h6>
                                    <div class="input-group input-group-outline col">
                                        <input type="text" name="ncpid" readonly class="form-control"
                                            style="cursor: not-allowed;" placeholder="NO DATA" value="<?= $ncp['ncpid'] ?>">
                                    </div>
                                    <!-- </div> -->
                                    <!-- <div class="col"> -->
                                    <h6>NAME</h6>
                                    <div class="input-group input-group-outline">
                                        <input type="text" name="ncpname" class="form-control" placeholder="NO DATA"
                                            value="<?= $ncp['ncpname'] ?>" readonly>
                                    </div>
                                    <!-- </div> -->
                                </div>
                                <h6>OFFICIAL NAME</h6>
                                <div class="input-group input-group-outline my-3">
                                    <input type="text" name="ncpofficialname" class="form-control" placeholder="NO DATA"
                                        value="<?= $ncp['ncpofficialname'] ?>" readonly>
                                </div>
                                <h6>FILIPINO NAME</h6>
                                <div class="input-group input-group-outline my-3">
                                    <input type="text" name="ncpfilipinoname" class="form-control" placeholder="NO DATA"
                                        value="<?= $ncp['ncpfilipinoname'] ?>" readonly>
                                </div>
                                <h6>LOCAL NAME</h6>
                                <div class="input-group input-group-outline mb-3">
                                    <input type="text" name="ncplocalname" class="form-control" placeholder="NO DATA"
                                        value="<?= $ncp['ncplocalname'] ?>" readonly>
                                </div>
                                <h6>CLASSIFICATION STATUS</h6>
                                <div class="input-group input-group-outline mb-3">
                                    <input type="text" name="ncpclassificationstatus" class="form-control" placeholder="NO DATA"
                                        value="<?= $ncp['ncpclassificationstatus'] ?>" readonly>
                                </div>
                                <h6>TOWN OR CITY</h6>
                                <div class="input-group input-group-outline mb-3">
                                    <input type="text" name="ncptownorcity" class="form-control" placeholder="NO DATA"
                                        value="<?= $ncp['ncptownorcity'] ?>" readonly>
                                </div>
                                <h6>YEAR DECLARED</h6>
                                <div class="input-group input-group-outline mb-3">
                                    <input type="text" name="ncpyeardeclared" class="form-control" placeholder="NO DATA"
                                        value="<?= $ncp['ncpyeardeclared'] ?>" readonly>
                                </div>
                                <h6>OTHER DECLARATION</h6>
                                <div class="input-group input-group-outline mb-3">
                                    <input type="text" name="ncpotherdeclarations" class="form-control" placeholder="NO DATA"
                                        value="<?= $ncp['ncpotherdeclarations'] ?>" readonly>
                                </div>
                                <h6>DESCRIPTION</h6>
                                <div class="form-group input-group input-group-outline mb-3">
                                    <textarea name="ncpdescription" class="form-control" rows="5"
                                        placeholder="NO DATA" readonly><?= $ncp['ncpdescription'] ?></textarea>
                                </div>
                                <h6>SOURCE LINK</h6>

                                <?php
                                    $sql = "SELECT * FROM `ncp_sourceurl` WHERE ncpid = '$ncp_id'";

                                    $query_result = mysqli_query($con, $sql);
                                    while($fetch_row = mysqli_fetch_assoc($query_result))
                                    {
                                        echo ' <div class="input-group input-group-outline d-flex justify-content-between align-items-center mb-3">
                                       
                                        <input type="text" name="ncpsourceA" class="form-control" placeholder="NO DATA"
                                            value="'.$fetch_row['sourcelink'].'" readonly>
                                        </div>';
                                    }
                                ?>
                               
                                <div class="text-center">
                                    <a href="functions.php?ncp_approve_id= <?php echo $ncp['ncpid']; ?>"  class="btn bg-gradient-primary w-100 my-4 mb-2"><strong><i class="fa-solid fa-check me-1 fs-5"></i>APPROVE REQUEST</strong></a>
                                </div>
                                <!-- <div class="text-center">
                                    <a href="ncpdatarequest.php" class="btn bg-gradient-danger w-100 mb-2"
                                        >BACK</a>
                                </div> -->
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
        const activePage = document.querySelector("a[href='ncpdatarequest.php'")
        activePage.classList.add('active', 'bg-gradient-primary');
        const activeDropdown =document.querySelector('ncpManage');
        const ncpManage = document.querySelector('a[aria-controls="manageNCP"]');
        const lssMenu = document.getElementById('lssMenu');
        activePage.classList.add('active', 'bg-gradient-primary');

        ncpManage.style.backgroundColor = 'rgba(199, 199, 199, 0.2)';
        lssMenu.classList.add('d-none');
    </script>


    <?php

    include 'includes/footer.php';
    include 'includes/scripts.php';
    ?>