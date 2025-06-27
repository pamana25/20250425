<?php
include '../../backend/model/areaModel.php';
include '../includes/header.php';
$areaModel= new Area();
?>

<div class="relative flex-grow mb-12 py-12">
    <!-- <img src="assets/img/background-images/bg-login.jpg" alt="Background Image" class="fixed inset-0 w-full h-full object-cover -z-10"> -->
    <div class="relative justify-center">

        <div class="relative flex-grow flex items-center justify-center">

            <div class="w-11/12 sm:w-4/5 md:w-3/4 lg:w-2/3 xl:w-1/2 text-primary-600 rounded mx-auto max-w-5xl">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold text-primary-600">ADD NEW PROPERTY</h1>
                    <button onclick="history.back()" class="bg-primary-600 hover:bg-primary-500 text-white flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-md text-sm font-medium transform transition duration-300 hover:scale-105">
                        <i class="fas fa-chevron-left"></i>
                        Back
                    </button>
                </div>
                <form id="formsubmit" enctype="multipart/form-data" autocomplete="off" novalidate>

                    <div class="my-3 mx-auto p-4 w-full max-w-5xl border rounded-lg bg-white">
                        <!-- 
                        <div class="my-4 bg-[#164c70] p-3 rounded text-center text-white">
                            <h6 class="uppercase">ADD NEW PROPERTY</h6>
                        </div> -->
                        <div class="flex flex-col items-center mx-3 mt-3" id="append-div">
                            <div class="w-full ">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <div class="input-group">
                                            <select name="category" class="bg-white text-black border border-black rounded p-2 mr-1 w-full" aria-label="Default select example" required autofocus id="selectproperties" required>
                                                <option value="">--Select Category--</option>
                                                <option value="ncp">National Cultural Properties</option>
                                                <option value="lss">Local Cultural Properties</option>
                                            </select>
                                            <button class="btn bg-white text-blue-500 border-none rounded p-2" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Tooltip content here">
                                                <strong><i class="bi bi-question-circle"></i></strong>
                                            </button>
                                        </div>
                                    </div>
                                    <div>
                                        <select id="areaid" name="areaid" class="bg-white text-black border border-black rounded p-2 mr-1 w-full" aria-label="Default select example" required autofocus >
                                            <option value="">--Select City/Town--</option>
                                            <?php
                                            $areas = $areaModel->getAllAreas();
                                            foreach ($areas as $area) {
                                                echo '<option value="' . $area['areaid'] . '" class="capitalize">' . $area['areaname'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="w-full mt-2 mb-2">
                                <input type="text" name="official_name" id="official_name" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-700 text-primary-600" data-placeholder="Official name*" placeholder="Official name" required>
                            </div>

                            <div class="w-full mt-2 mb-2">
                                <!-- <label class="mb-2 text-primary-600">LOCAL NAME <span class="text-muted">(Optional)</span></label> -->
                                <input type="text" name="local_name" id="local_name" data-placeholder="Local name" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-700 text-primary-600">
                            </div>

                            <div class="w-full mt-2 mb-2">
                                <!-- <label class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-700 text-primary-600">LOCATION <span class="text-danger">*</span></label> -->
                                <textarea name="location" id="location" rows="3" data-placeholder="Location*" class="block p-2.5 w-full text-sm text-gray-900  rounded-lg border border-gray-300  focus:ring-2 focus:ring-primary-700 focus:border-primary-700 " required></textarea>
                            </div>

                            <div class="w-full mt-2 mb-2">
                                <!-- <label class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-700 text-primary-600">CLASSIFICATION STATUS <span class="text-danger">*</span></label> -->
                                <textarea name="classification_status" id="classification_status" rows="3" class="block p-2.5 w-full text-sm text-gray-900  rounded-lg border border-gray-300 focus:ring-primary-700 focus:border-primary-700 0" data-placeholder="Classification status*" required></textarea>
                            </div>

                            <div class="w-full mt-2 mb-2">
                                <!-- <label class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-700 text-primary-600">YEAR OF DECLARATION</label> -->
                                <input type="text" name="year_declaration" data-placeholder="Year declaration" id="year_declaration" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-700 text-primary-600">
                            </div>

                            <div class="w-full mt-2 mb-2">
                                <!-- <label class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-700 text-primary-600">OTHER DECLARATION <span class="text-muted">(if applicable)</span></label> -->
                                <input type="text" name="other_declaration" data-placeholder="Other declaration" id="other_declaration" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-700 text-primary-600">
                            </div>

                            <div class="w-full mt-2 mb-2">
                                <!-- <label class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-700 text-primary-600">DESCRIPTION <span class="text-muted">(Optional)</span></label> -->
                                <textarea name="description" id="description" rows="5" data-placeholder="Description" class="block p-2.5 w-full text-sm text-gray-900  rounded-lg border border-gray-300 focus:ring-primary-700 focus:border-primary-700 "></textarea>
                            </div>

                            <div class="w-full mt-2 mb-2">
                                <!-- <label class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-700 text-primary-600">SOURCE (URL)<span class="text-danger">*</span></label> -->
                                <input type="text" name="source_url[]" id="source_url" data-placeholder="Source URL*" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-700 text-primary-600" required>
                            </div>

                            <div id="wrapper-inputs"></div>
                        </div>

                        <div class="w-full mt-4 text-center">
                            <button type="submit" id="upload_properties_btn" class="bg-primary-600 hover:bg-primary-500 text-white border border-primary-600 rounded p-2 mb-4 w-full md:w-48 flex items-center justify-center space-x-2 mx-auto transform transition duration-300 hover:scale-105">
                                <strong class="flex items-center">
                                    <svg class="h-6 w-6 text-white mr-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                        <polyline points="7 9 12 4 17 9" />
                                        <line x1="12" y1="4" x2="12" y2="16" />
                                    </svg>
                                    <span>UPLOAD</span>
                                </strong>
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<script src="src/js/upload_properties.js"></script>
<?php include '../includes/footer.php'; ?>