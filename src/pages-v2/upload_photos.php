<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../includes/header.php');
include '../../backend/model/areaModel.php';
include '../../backend/model/userModel.php';

if(!$isLogin){
    echo "<script>window.location.href='./login';</script>";
 }

$userid = $_SESSION["userid"];

$areaModel = new Area();;
$user = new User();

$getUserFirstName = $user->getUserInfoByUserid($userid);
$getUserLastName = $user->getUserInfoByUserid($userid);
$getAlias = $user->getUserInfoByUserid($userid);



?>

<style>

</style>
<main class="flex-grow container mx-auto py-8 px-4">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-primary-600">Contribute</h1>
        <button onclick="history.back()" class="bg-primary-600 hover:bg-primary-500 text-white flex items-center gap-2 px-4 py-2  border border-gray-300 rounded-md text-sm font-medium transition duration-150 ease-in-out transform transition duration-300 hover:scale-105">
            <i class="fas fa-chevron-left"></i>
            Back
        </button>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <form id="propertiesUpload" class="space-y-6" enctype="multipart/form-data">
                <!-- Category Dropdown -->
                <input type="hidden" name="uploadedby" value="<?= $userid ?>">
                <div>
                    <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-600 focus:border-blue-500" id="category" onchange="toggleCategory()" name="category">
                        <option value="" selected disabled>Select a Category</option>
                        <option value="ncp" class="ncp">National Cultural Properties</option>
                        <option value="lss" class="lss">Local Cultural Properties</option>

                    </select>
                </div>
                <div class="custom-select-container relative w-full hidden" id="selectAreaContainer">
                    <!-- Display the selected value -->
                    <span>Select Area</span>
                    <input id="selectBox"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary-600 focus:border-blue-500" name="selectArea">

                    </input>

                    <!-- Search box inside the dropdown -->
                    <input type="text" id="searchBox"
                        class="hidden w-full border border-gray-300 rounded-md px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-primary-600 focus:border-blue-500"
                        placeholder="Search..." />

                    <!-- Dropdown options with group labels -->
                    <div id="optionsContainer"
                        class="absolute top-full left-0 w-full max-h-48 overflow-y-auto border border-gray-300 rounded-md bg-white shadow-md z-10 mt-1 hidden">

                        <!-- Group 1 -->
                        <?php
                        $areas = $areaModel->getAllAreas();
                        foreach ($areas as $area) {
                            echo "<div id='areaidDiv' class='group-label font-bold bg-gray-100 text-gray-700 capitalize' area-id='{$area['areaid']}' value='{$area['areaid']}'> 
                                 <div class='bg-gray-100 px-3 py-2 cursor-default'>{$area['areaname']}</div>
                                 <div id='area-options'></div>
                            </div>";
                        }
                        ?>

                    </div>
                </div>
                <!-- File Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Choose File</label>
                    <div class="flex items-center justify-center w-full">
                        <label class="w-full flex items-center px-3 py-2 border border-gray-300 rounded-md cursor-pointer hover:bg-gray-50">
                            <!-- Optional: Add span to display chosen file name -->
                            <input
                                type="file"
                                class="hidden"
                                name="file"
                                id="inputFile"
                                onchange="document.getElementById('file-upload-label').textContent = this.files[0].name || 'No file chosen';">
                            <span class="text-gray-500" id="file-upload-label">No file chosen</span>
                        </label>
                    </div>
                </div>

                <!-- <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Choose File</label>
                    <div class="flex items-center justify-center w-full">
                        <label class="w-full flex items-center px-3 py-2 border border-gray-300 rounded-md cursor-pointer hover:bg-gray-50">
                            <span class="text-gray-500" id="inputfilelabel">No file chosen</span> 
                            <input type="file" class="" name="file" id="inputFile">
                        </label>
                    </div>
                </div> -->

                <!-- Photo Ownership -->
                <div class="space-y-4">
                    <div class="flex items-center">
                        <input type="checkbox" id="ownership" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" onchange="toggleNameFields()">
                        <label for="ownership" class="ml-2 block text-sm text-gray-700">Do you own the photo?</label>
                    </div>

                    <!-- Name Fields (Initially Hidden) -->
                    <div id="nameFields" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" placeholder="First Name" id="firstname" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-600 focus:border-blue-500" value="<?= $getUserFirstName['firstname'] ?>" name="firstname" readonly>
                        <input type="text" placeholder="Last Name" id="lastname" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-600 focus:border-blue-500" value="<?= $getUserLastName['lastname'] ?>" name="lastname" readonly>
                    </div>

                    <!-- Empty Name Fields (Initially Visible and Disabled) -->
                    <div id="emptynameFields" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" placeholder="First Name" id="emptyFirstname" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-600 focus:border-blue-500" name="firstname" disabled>
                        <input type="text" placeholder="Last Name" id="emptyLastname" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-600 focus:border-blue-500" name="lastname" disabled>
                    </div>
                    <!-- <div class="flex items-center">
                        <input type="checkbox" id="ownership" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" onchange="toggleNameFields()">
                        <label for="ownership" class="ml-2 block text-sm text-gray-700">Do you own the photo?</label>
                    </div>

                     Name Fields (Initially Hidden) 
                    <div id="nameFields" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" placeholder="First Name" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="<?= $getUserFirstName['firstname'] ?>" readonly name="firstname">
                        <input type="text" placeholder="Last Name" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="<?= $getUserLastName['lastname'] ?>" name="lastname"
                            readonly>
                    </div> -->

                    <!-- Alias Option -->
                    <div class="space-y-4">
                        <div class="flex items-center" id="foralias">
                            <input type="checkbox" id="useAlias" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" onchange="toggleAliasField()" name="alias">
                            <label for="useAlias" class="ml-2 block text-sm text-gray-700">Use <i>alias</i> instead of your name?</label>
                        </div>

                        <!-- Alias Field (Initially Hidden) -->
                        <div id="aliasField" class="hidden">
                            <input type="text" id="aliasName" placeholder="Enter your alt name" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-600 focus:border-blue-500" name="alt_name" value="<?= $getUserFirstName['alias'] ?>">
                            <p class="mt-2 text-sm text-red-500">
                                NOTE: You can only use one alternative name or alias for your existing user profile. You can change your alt name by going to your user profile. Using an alt name for this photo will not affect your previous contributions, however you can select this feature again for future uploads.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date:</label>
                    <input type="date" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-600 focus:border-blue-500" name="date_taken">
                </div>

                <!-- Source -->
                <div id="sourceUrl">
                    <!-- <label class="block text-sm font-medium text-gray-700 mb-1">Date:</label> -->
                    <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-600 focus:border-blue-500" name="source" placeholder="Source/Url">
                </div>


                <!-- Description -->
                <div>
                    <textarea placeholder="Description" rows="4" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-600 focus:border-blue-500" name="description"></textarea>
                </div>

                <!-- Upload Button -->
                <div class="flex justify-center">
                    <button type="submit" class="bg-primary-600 hover:bg-primary-500 text-white inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-600 transform transition duration-300 hover:scale-105">
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