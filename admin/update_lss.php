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
                        <h6 class="text-white text-capitalize ps-3 mx-auto">UPDATE LSS DATA </h6>
                        <a href="managelss.php">
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
                            $query = "SELECT * FROM lss WHERE lssid='$lss_id'";
                            $query_run = mysqli_query($con, $query);

                            if (mysqli_num_rows($query_run) > 0) {
                                foreach ($query_run as $lss)
                                ?>
                                <div class="row justify-content-center align-items-center g-3 my-3">
                                    <input type="text" value="<?= $lss_id ?>" name="id" hidden>
                                    <!-- <div class="col"> -->
                                    <h6>ID</h6>
                                    <div class="input-group input-group-outline col">
                                        <input type="text" name="lssid" readonly class="form-control"
                                            style="cursor: not-allowed;" placeholder="NO DATA" value="<?= $lss['lssid'] ?>">
                                    </div>
                                    <!-- </div> -->
                                    <!-- <div class="col"> -->
                                    <h6>NAME</h6>
                                    <div class="input-group input-group-outline">
                                        <input type="text" name="lssname" class="form-control" placeholder="NO DATA"
                                            value="<?= $lss['lssname'] ?>">
                                    </div>
                                    <!-- </div> -->
                                </div>
                                <h6>OFFICIAL NAME</h6>
                                <div class="input-group input-group-outline my-3">
                                    <input type="text" name="lssofficialname" class="form-control" placeholder="NO DATA"
                                        value="<?= $lss['lssofficialname'] ?>">
                                </div>
                                <h6>FILIPINO NAME</h6>
                                <div class="input-group input-group-outline my-3">
                                    <input type="text" name="lssfilipinoname" class="form-control" placeholder="NO DATA"
                                        value="<?= $lss['lssfilipinoname'] ?>">
                                </div>
                                <h6>LOCAL NAME</h6>
                                <div class="input-group input-group-outline mb-3">
                                    <input type="text" name="lsslocalname" class="form-control" placeholder="NO DATA"
                                        value="<?= $lss['lsslocalname'] ?>">
                                </div>
                                <h6>CLASSIFICATION STATUS</h6>
                                <div class="input-group input-group-outline mb-3">
                                    <input type="text" name="lssclassificationstatus" class="form-control" placeholder="NO DATA"
                                        value="<?= $lss['lssclassificationstatus'] ?>">
                                </div>
                                <h6>TOWN OR CITY</h6>
                                <div class="input-group input-group-outline mb-3">
                                    <input type="text" name="lsstownorcity" class="form-control" placeholder="NO DATA"
                                        value="<?= $lss['lsstownorcity'] ?>">
                                </div>
                                <h6>YEAR DECLARED</h6>
                                <div class="input-group input-group-outline mb-3">
                                    <input type="text" name="lssyeardeclared" class="form-control" placeholder="NO DATA"
                                        value="<?= $lss['lssyeardeclared'] ?>">
                                </div>
                                <h6>OTHER DECLARATION</h6>
                                <div class="input-group input-group-outline mb-3">
                                    <input type="text" name="lssotherdeclarations" class="form-control" placeholder="NO DATA"
                                        value="<?= $lss['lssotherdeclarations'] ?>">
                                </div>
                                <h6>LEGISLATION</h6>
                                <div class="input-group input-group-outline mb-3">
                                    <input type="text" name="lsslegislation" class="form-control" placeholder="NO DATA"
                                        value="<?= $lss['lsslegislation'] ?>">
                                </div>
                                <h6>DESCRIPTION</h6>
                                <div class="form-group input-group input-group-outline mb-3">
                                    <textarea name="lssdescription" class="form-control" rows="5"
                                        placeholder="NO DATA"><?= $lss['lssdescription'] ?></textarea>
                                </div>
                                <h6 class="">SOURCE LINK
                                    <button type="button" name="add" data-bs-toggle="modal" data-bs-target="#addLcpSourceModal" value="<?= $lss['lssid'] ?>" class="btn btn-sm btn-success float-end btn_addSource" >add source</button>
                                
                                </h6>

                                <?php
                                
                                $sql = "SELECT * FROM lss_sourceurl WHERE lssid = '$lss_id'";
                                $sql_run = mysqli_query($con, $sql);

                                if(mysqli_num_rows($sql_run) > 0)
                                {
                                    if($lss['lsssource'] != '' || $lss['lsssourceB'])
                                    {
                                        echo '
                                        
                                        <div class="input-group input-group-outline mb-3">
                                        <input type="text" name="lsssourceA" class="form-control" placeholder="NO DATA"
                                            value="'.$lss['lsssource'].'">
                                        </div>
                                    
                                        <div class="input-group input-group-outline mb-3">
                                            <input type="text" name="lsssourceB" class="form-control" placeholder="NO DATA"
                                                value="'.$lss['lsssourceB'].'">
                                        </div>
                                    ';
                                    }

                                    while($fetch_row = mysqli_fetch_assoc($sql_run))
                                    {
                                        echo ' <div class="input-group input-group-outline mb-3">
                                        <input type ="hidden" name= "lsssource_id[]" value = "'. $fetch_row['id'] .'">
                                        <input type="text" name="lsssource[]" class="form-control" placeholder="NO DATA"
                                            value="'.$fetch_row['sourcelink'].'">
                                        </div>';
                                    }

                                  

                                }
                                else
                                {
                                    echo '
                                        
                                        <div class="input-group input-group-outline mb-3">
                                        <input type="text" name="lsssourceA" class="form-control" placeholder="NO DATA"
                                            value="'.$lss['lsssource'].'">
                                        </div>
                                    
                                        <div class="input-group input-group-outline mb-3">
                                            <input type="text" name="lsssourceB" class="form-control" placeholder="NO DATA"
                                                value="'.$lss['lsssourceB'].'">
                                        </div>
                                    ';
                                }

                               

                                ?>
                                <p class="text-dark mt-2 fw-bold text-sm">Note: <span class="text-muted fw-normal">In order to appear on the pamana map this three input below should be papulated</span></p>
                                <h6>LATITUDE</h6>
                                <div class="input-group input-group-outline mb-3">
                                    <input type="text" name="latitude" class="form-control" placeholder="NO DATA"
                                        value="<?= $lss['latitude'] ?>">
                                </div>

                                <h6>LONGITUDE</h6>
                                <div class="input-group input-group-outline mb-3">
                                    <input type="text" name="longitude" class="form-control" placeholder="NO DATA"
                                        value="<?= $lss['longitude'] ?>">
                                </div>

                                <h6>MAP CLASSIFICATION ICON</h6>
                                <div class="input-group input-group-outline mb-3">
                                    <select name="map_classification" id="map_classification" class="form-control" >
                                        <option value="">- Select -</option>
                                        <?php
                                            $enumSql = "SHOW COLUMNS FROM `lss` LIKE 'map_classification'";
                                            $enumQuery = mysqli_query($con, $enumSql);

                                            if ($enumQuery && mysqli_num_rows($enumQuery) > 0) {
                                                $fetchEnum = mysqli_fetch_assoc($enumQuery);
                                                $enumValues = str_replace(["enum(", ")", "'"], "", $fetchEnum['Type']); // Use 'Type' to access enum definition
                                                $options = explode(",", $enumValues);

                                                foreach ($options as $option): 
                                                    // Add spacing to the option label (display text)
                                                    $spacedOption = preg_replace('/([a-z])([A-Z])/', '$1 $2', $option);
                                                    ?>
                                                    <option value="<?= htmlspecialchars($option, ENT_QUOTES, 'UTF-8') ?>"
                                                        <?= isset($lss['map_classification']) && $lss['map_classification'] == $option ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($spacedOption, ENT_QUOTES, 'UTF-8') ?>
                                                    </option>
                                                <?php 
                                                endforeach;
                                            } else {
                                                echo "<option value=\"\">Error fetching enum values</option>";
                                            }
                                            ?>
                                    </select>
                                </div>
                               
                               
                                
                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-primary  w-100 my-4 mb-2"
                                        name="update_lss"><strong><i class="fa-regular fa-pen-to-square me-1 fs-5"></i>Update Data</strong>
                                    </button>
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
    <?php include('addsource_modal.php'); ?>

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
        const activePage = document.querySelector("a[href='managelss.php'")
        const activeDropdown =document.querySelector('lssManage');
        const lssManage = document.querySelector('a[aria-controls="manageLSS"]');
        const ncpMenu = document.getElementById('ncpMenu');
        activePage.classList.add('active', 'bg-gradient-primary');

        lssManage.style.backgroundColor = 'rgba(199, 199, 199, 0.2)';
        ncpMenu.classList.add('d-none');

        const addSource = document.querySelector('.btn_addSource');
        addSource.addEventListener("click", ()=>{
            const lssid = document.createElement("input");
            const display_id = document.querySelector('#display_lssid');
            lssid.name = "lssid"
            lssid.className = "form-control";
            lssid.type = "hidden";
            lssid.value = addSource.value;


            display_id.append(lssid);

        })

    </script>


    <?php

    include 'includes/footer.php';
    include 'includes/scripts.php';
    ?>