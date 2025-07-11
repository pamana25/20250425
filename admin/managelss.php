<?php
include 'includes/security.php';
include 'includes/header.php';
include 'includes/navbar.php';
include 'includes/functions.php';


?>

<div class="container-fluid py-4">
    <div class="row min-vh-80 h-100">
        <!-- <form  id="searchData">
            <div class="input-group input-group-outline mx-auto w-50 pb-3">
                <input type="text" name="search" value="<?= isset($_GET['search']) && $_GET['search'] != '' ? $_GET['search'] : '' ?>" class="form-control" placeholder="Search by property name or areaname">
                <input type="hidden" value="" name="formAction" id="formAction">
                <button type="submit" class="btn btn-primary m-0" id="searchBtn" name="searchBtn">Search</button>
            </div>
        </form> -->
            <!-- LSS DATA -->
        <form method="POST" action="functions.php" id="lssForm">

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
                            <div class="datatable-container">
                                <table class="table table-striped" id="datatable1">
                                    <thead>
                                        <!-- <button class="btn btn-white btn-sm position-absolute" style="margin-top: -.6rem;"><i class="fa-solid fa-arrow-up-wide-short text-primary"></i></button> -->
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                uploaded by    
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

                    $query = "SELECT lss.lssid, uploader.email AS uploader_email, 
                                        lss.lssname, updater.firstname AS updater_firstname, 
                                        updater.lastname AS updater_lastname, 
                                        DATE(lss.uploadstatusdate) as date_approved, areas.areaname 
                                        FROM lss 
                                        INNER JOIN users AS uploader ON lss.uploadedbyuser = uploader.userid 
                                        INNER JOIN users AS updater ON lss.uploadstatusby = updater.userid INNER JOIN areas ON lss.areaid = areas.areaid
                                        WHERE uploadstatus = 1 ";
                    $query_run = mysqli_query($con, $query);
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
                                        <!-- <?= date('M d, Y', strtotime($row['date_approved'])) ?> -->
                                        <?= $row['date_approved'] ?>
                                    </h6>
                                </td>
                                <td class="align-middle text-center text-sm align-items-center">
                                    <a href="update_lss.php?id=<?= $row['lssid']; ?>" class="btn btn-info btn-sm">View/Edit</a>

                                    <a href="#" onclick="setLssid('<?= $row['lssid'] ?>')" id="showModal" class="btn btn-danger btn-sm">Remove</a>
                                    
                                </td>
                            </tr>
                    <?php }
                    ?>
            </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</div>


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
            <input class="form-check-input m-0" type="radio" name="email_value" value="4" id="flexRadioDefault4" style="margin-left: 0!important;">
            <label class="form-check-label m-0  text-wrap" for="flexRadioDefault4">
                Other:
            </label>
            <textarea name="email_value_other" class="w-100"></textarea>
        </div>
    </div>


    <div class="text-center">
        <button type="submit" name="delete_lss_and_send_email"  id="delete_lss_and_send_email"  value="" class="btn btn-success btn-sm mb-0 text-xxs mb-0 w-25">Send</button>

      
        <a name="closeModal" id="closeModal" class="btn btn-danger btn-sm mb-0 text-xxs mb-0 w-25">Cancel</a>
    </div>
</dialog>

</form>
</div>







<?php

include 'includes/footer.php';
// include 'includes/scripts.php';
include('includes/jqueryscript.php');

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

</script>


