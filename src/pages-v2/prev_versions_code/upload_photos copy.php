<?php
include '../../backend/model/lcpModel.php';
include '../../backend/model/ncpModel.php';
include '../../backend/model/areaModel.php';
include('../includes/header.php');
$lcpMdel = new Lcp();
$ncpModel = new Ncp();
$areaModel = new Area();

?>
<!-- < ?php
$ncp = $ncpModel->getAllNcpData();
 foreach ($ncp as $area) {
echo '<option value="' . $area['areaid'] . '" class="text-capitalize">' . $area['ncpname'] . '</option>';
}
?> -->
<!-- < ?php
$areas = $areaModel->getAllAreas();
foreach ($areas as $area) {
echo '<option value="' . $area['areaid'] . '" class="text-capitalize">' . $area['areaname'] . '</option>';
}
?> -->
<style>

</style>
<main class="flex-grow container mx-auto py-8 px-4">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Contribute</h1>
        <button class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition duration-150 ease-in-out">
            <i class="fas fa-chevron-left"></i>
            Back
        </button>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <form class="space-y-6">
                <!-- Category Dropdown -->
                <div>
                    <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="" selected disabled>Select a Category</option>
                        <option value="ncp" class="ncp">National Cultural Properties</option>
                        <option value="lss" class="lss">Local Cultural Properties</option>

                    </select>
                </div>
                <div class="custom-select-container relative w-full">
                    <!-- Display the selected value -->
                    <div id="selectBox"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        Select Area
                    </div>

                    <!-- Search box inside the dropdown -->
                    <input type="text" id="searchBox"
                        class="hidden w-full border border-gray-300 rounded-md px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Search..." />

                    <!-- Dropdown options with group labels -->
                    <div id="optionsContainer"
                        class="absolute top-full left-0 w-full max-h-48 overflow-y-auto border border-gray-300 rounded-md bg-white shadow-md z-10 mt-1 hidden">

                        <!-- Group 1 -->
                        <?php
                        $areas = $areaModel->getAllAreas();
                        foreach ($areas as $area) {
                            echo   '<div id="areaidDiv" class="group-label px-3 py-2 font-bold bg-gray-100 text-gray-700 cursor-pointer" area-id="'.$area['areaid'].'" value="' . $area['areaid'] . '" class="text-capitalize"> ' . $area['areaname'] .' 
                           
                            </div>';
                            // <div id="forOption" class="option property px-3 py-2 cursor-pointer hover:bg-gray-200" data-property="property1">
                            // Alcantara - Property 1
                            // </div>
                            
                            //add here
                            // echo '<option value="' . $area['areaid'] . '" class="text-capitalize">' . $area['areaname'] . '</option>';
                        }
                        ?>
                        <div class="option property px-3 py-2 cursor-pointer hover:bg-gray-200" data-property="property1">Alcantara - Property 1</div>
                        <div class="option property px-3 py-2 cursor-pointer hover:bg-gray-200" data-property="property2">Alcantara - Property 2</div>

                        <!-- Group 2 -->
                        <div class="option group-label px-3 py-2 font-bold bg-gray-100 text-gray-700 cursor-pointer" data-group="Alcoy">Alcoy</div>
                        <div class="option property px-3 py-2 cursor-pointer hover:bg-gray-200" data-property="church">Parish Church of Saint Rose of Lima</div>
                        <div class="option property px-3 py-2 cursor-pointer hover:bg-gray-200" data-property="property2">Alcoy - Property 2</div>

                        <!-- Group 3 -->
                        <div class="option group-label px-3 py-2 font-bold bg-gray-100 text-gray-700 cursor-pointer" data-group="Alegria">Alegria</div>
                        <div class="option property px-3 py-2 cursor-pointer hover:bg-gray-200" data-property="property1">Alegria - Property 1</div>
                        <div class="option property px-3 py-2 cursor-pointer hover:bg-gray-200" data-property="property2">Alegria - Property 2</div>
                    </div>
                </div>
                <!-- File Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Choose File</label>
                    <div class="flex items-center justify-center w-full">
                        <label class="w-full flex items-center px-3 py-2 border border-gray-300 rounded-md cursor-pointer hover:bg-gray-50">
                            <span class="text-gray-500">No file chosen</span>
                            <input type="file" class="hidden">
                        </label>
                    </div>
                </div>

                <!-- Photo Ownership -->
                <div class="space-y-4">
                    <div class="flex items-center">
                        <input type="checkbox" id="ownership" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" onchange="toggleNameFields()">
                        <label for="ownership" class="ml-2 block text-sm text-gray-700">Do you own the photo?</label>
                    </div>

                    <!-- Name Fields (Initially Hidden) -->
                    <div id="nameFields" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" placeholder="First Name" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <input type="text" placeholder="Last Name" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Alias Option -->
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="useAlias" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" onchange="toggleAliasField()">
                            <label for="useAlias" class="ml-2 block text-sm text-gray-700">Use <i>alias</i> instead of your name?</label>
                        </div>

                        <!-- Alias Field (Initially Hidden) -->
                        <div id="aliasField" class="hidden">
                            <input type="text" placeholder="Enter your alt name" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="mt-2 text-sm text-red-500">
                                NOTE: You can only use one alternative name or alias for your existing user profile. You can change your alt name by going to your user profile. Using an alt name for this photo will not affect your previous contributions, however you can select this feature again for future uploads.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date:</label>
                    <input type="date" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Description -->
                <div>
                    <textarea placeholder="Description" rows="4" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>

                <!-- Upload Button -->
                <div class="flex justify-center">
                    <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-upload mr-2"></i>
                        UPLOAD
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
<script src="src/js/upload_photos.js"></script>
<?php include '../includes/footer.php'; ?>