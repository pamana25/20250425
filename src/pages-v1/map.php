<?php 
include '../includes/header.php';


$type = isset($_GET['type']) ? $_GET['type'] : '';

$isNational = ($type === 'national');
$isLocal = ($type === 'local');
$requestUri = $_SERVER['REQUEST_URI'];
$active = 'bg-primary-600 text-white rounded py-1 px-4 hover:text-gray-300 transform transition duration-300 hover:scale-105';

?>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<body>
    <main class="relative">
        <div id="map" class="w-full h-[calc(100vh-64.8px)]"></div>
        <div id="load" class="absolute top-0 inset-0 bg-white h-full w-full z-[9999] flex flex-col justify-center items-center">
            <div id="loader" class="w-10 h-10 border-2 border-t-transparent border-blue-500 border-solid rounded-full animate-spin spinner"></div>
            <label>Loading...</label>
        </div>
        <div class="bg-white border rounded-lg shadow-sm">
            <div class="text-center">
                <button class="flex items-center justify-center w-auto whitespace-nowrap text-sm 2 mb-5 absolute top-2 left-4 z-10 bg-primary-600 text-white px-3 py-2 rounded-md shadow-md hover:bg-primary-white transition-colors duration-200 text-sm z-[9999] transform transition hover:scale-105" type="button" data-drawer-target="drawer" data-drawer-show="drawer" aria-controls="drawer">
                    <svg class="w-4 h-4 mr-2 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path d="M352 256c0 22.2-1.2 43.6-3.3 64l-185.3 0c-2.2-20.4-3.3-41.8-3.3-64s1.2-43.6 3.3-64l185.3 0c2.2 20.4 3.3 41.8 3.3 64zm28.8-64l123.1 0c5.3 20.5 8.1 41.9 8.1 64s-2.8 43.5-8.1 64l-123.1 0c2.1-20.6 3.2-42 3.2-64s-1.1-43.4-3.2-64zm112.6-32l-116.7 0c-10-63.9-29.8-117.4-55.3-151.6c78.3 20.7 142 77.5 171.9 151.6zm-149.1 0l-176.6 0c6.1-36.4 15.5-68.6 27-94.7c10.5-23.6 22.2-40.7 33.5-51.5C239.4 3.2 248.7 0 256 0s16.6 3.2 27.8 13.8c11.3 10.8 23 27.9 33.5 51.5c11.6 26 20.9 58.2 27 94.7zm-209 0L18.6 160C48.6 85.9 112.2 29.1 190.6 8.4C165.1 42.6 145.3 96.1 135.3 160zM8.1 192l123.1 0c-2.1 20.6-3.2 42-3.2 64s1.1 43.4 3.2 64L8.1 320C2.8 299.5 0 278.1 0 256s2.8-43.5 8.1-64zM194.7 446.6c-11.6-26-20.9-58.2-27-94.6l176.6 0c-6.1 36.4-15.5 68.6-27 94.6c-10.5 23.6-22.2 40.7-33.5 51.5C272.6 508.8 263.3 512 256 512s-16.6-3.2-27.8-13.8c-11.3-10.8-23-27.9-33.5-51.5zM135.3 352c10 63.9 29.8 117.4 55.3 151.6C112.2 482.9 48.6 426.1 18.6 352l116.7 0zm358.1 0c-30 74.1-93.6 130.9-171.9 151.6c25.5-34.2 45.2-87.7 55.3-151.6l116.7 0z" />
                    </svg>
                    Legend
                </button>
            </div>

            <div id="drawer" class="absolute top-0 left-0 z-40 h-[calc(100vh-64.8px)] p-4 overflow-y-auto transition-transform -translate-x-full bg-white w-96 z-[9999]" tabindex="-1" aria-labelledby="drawer-label">
                <h5 id="drawer-label" class="inline-flex items-center text-base font-semibold text-gray-500 dark:text-gray-400 ">
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path d="M352 256c0 22.2-1.2 43.6-3.3 64l-185.3 0c-2.2-20.4-3.3-41.8-3.3-64s1.2-43.6 3.3-64l185.3 0c2.2 20.4 3.3 41.8 3.3 64zm28.8-64l123.1 0c5.3 20.5 8.1 41.9 8.1 64s-2.8 43.5-8.1 64l-123.1 0c2.1-20.6 3.2-42 3.2-64s-1.1-43.4-3.2-64zm112.6-32l-116.7 0c-10-63.9-29.8-117.4-55.3-151.6c78.3 20.7 142 77.5 171.9 151.6zm-149.1 0l-176.6 0c6.1-36.4 15.5-68.6 27-94.7c10.5-23.6 22.2-40.7 33.5-51.5C239.4 3.2 248.7 0 256 0s16.6 3.2 27.8 13.8c11.3 10.8 23 27.9 33.5 51.5c11.6 26 20.9 58.2 27 94.7zm-209 0L18.6 160C48.6 85.9 112.2 29.1 190.6 8.4C165.1 42.6 145.3 96.1 135.3 160zM8.1 192l123.1 0c-2.1 20.6-3.2 42-3.2 64s1.1 43.4 3.2 64L8.1 320C2.8 299.5 0 278.1 0 256s2.8-43.5 8.1-64zM194.7 446.6c-11.6-26-20.9-58.2-27-94.6l176.6 0c-6.1 36.4-15.5 68.6-27 94.6c-10.5 23.6-22.2 40.7-33.5 51.5C272.6 508.8 263.3 512 256 512s-16.6-3.2-27.8-13.8c-11.3-10.8-23-27.9-33.5-51.5zM135.3 352c10 63.9 29.8 117.4 55.3 151.6C112.2 482.9 48.6 426.1 18.6 352l116.7 0zm358.1 0c-30 74.1-93.6 130.9-171.9 151.6c25.5-34.2 45.2-87.7 55.3-151.6l116.7 0z" />
                    </svg>
                    Legend
                </h5>
                <button type="button" data-drawer-hide="drawer" aria-controls="drawer" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-6 h-6 absolute top-2 end-2.5 flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close menu</span>
                </button>

                <p class="mb-6 text-sm text-gray-500 dark:text-gray-400"></p>
                <div class="grid grid-cols-2 gap-4">


                    <div id="sidebar" class="absolute z-[9999] flex">
                        <div class="flex flex-col justify-between">
                            <div class="space-y-2 relative h-full w-full bg-white pb-auto mb-2">
                                <div class="flex items-center">
                                    <input type="checkbox" id="nationalCulturalCheckbox" <?php echo $isNational ? 'checked' : ''; ?> onclick="toggleNationalProperties()" class="mr-2">
                                    <label for="nationalCulturalCheckbox" class="flex items-center text-sm p-2 rounded transition-colors transform translate duration-400 hover:scale-105 cursor-pointer select-none">
                                        &nbsp;<span class="hover:overline">National Cultural Properties</span></label>
                                </div>

                                <ul id="nationalCulturalList" class="space-y-2 p-2 w-auto">
                                    <li class="w-full flex items-center relative group">
                                        <input id="NationalCulturalTreasures" type="checkbox" class="mr-2">
                                        <label onclick="showDialog('dialog1')" class="flex items-center text-sm p-2 rounded transition-colors transform translate duration-400 hover:scale-105 cursor-pointer select-none"><img class="w-6 h-6" src="assets/icons/NationalCulturalTreasure.svg" alt="">
                                            &nbsp;&nbsp;<span class="hover:overline">National Cultural Treasures</span></label>
                                    </li>
                                    <li class="flex items-center relative group">
                                        <input id="NationalHistoricalShrines" type="checkbox" class="mr-2">
                                        <label onclick="showDialog('dialog3')" class="dialog-hover flex items-center text-sm p-2 rounded transition-colorstransform translate duration-400 hover:scale-105 cursor-pointer select-none"><img class="w-6 h-6" src="assets/icons/NationalHistoricalShrine.svg" alt="">
                                            &nbsp;&nbsp; <span class="hover:overline">National Historical Shrines</span></label>
                                    </li>
                                    <li class="flex items-center relative group">
                                        <input id="NationalHistoricalLandmarks" type="checkbox" class="mr-2">
                                        <label onclick="showDialog('dialog4')" class="dialog-hover flex items-center text-sm p-2 rounded transition-colors transform translate duration-400 hover:scale-105 cursor-pointer select-none"><img class="w-6 h-6" src="assets/icons/NationalHistoricalLandmark.svg" alt="">
                                            &nbsp;&nbsp;<span class="hover:overline">National Historical Landmarks</span></label>
                                    </li>
                                    <li class="flex items-center relative group">
                                        <input id="NationalHistoricalMonuments" type="checkbox" class="mr-2">
                                        <label onclick="showDialog('dialog5')" class="dialog-hover flex items-center text-sm p-2 rounded transition-colors transform translate duration-400 hover:scale-105 cursor-pointer select-none"><img class="w-6 h-6" src="assets/icons/NationalHistoricalMonument.svg" alt="">
                                            &nbsp;&nbsp;<span class="hover:overline">National Historical Monuments</span></label>
                                    </li>
                                    <li class="flex items-center relative group">
                                        <input id="ClassifiedHistoricStructures" type="checkbox" class="mr-2">
                                        <label onclick="showDialog('dialog8')" class="dialog-hover flex items-center text-sm p-2 rounded transition-colors transform translate duration-400 hover:scale-105 cursor-pointer select-none"><img class="w-6 h-6" src="assets/icons/ClassifiedHistoricStructure_Fill-2.svg" alt="">
                                            &nbsp;&nbsp;<span class="hover:overline">Classified Historic Structures</span></label>
                                    </li>
                                    <li class="flex items-center relative group">
                                        <input id="ImportantCulturalProperties" type="checkbox" class="mr-2">
                                        <label onclick="showDialog('dialog2')" class="dialog-hover flex items-center text-sm p-2 rounded transition-colors transform translate duration-400 hover:scale-105 cursor-pointer select-none"><img class="w-6 h-6" src="assets/icons/ImportantCulturalProperty.svg" alt="">
                                            &nbsp;&nbsp; <span class="hover:overline">Important Cultural Properties</span></label>
                                    </li>
                                    <li class="flex items-center relative group">
                                        <input id="PresumedImportantCulturalProperties" type="checkbox" class="mr-2">
                                        <label onclick="showDialog('dialog8')" class="dialog-hover flex items-center text-sm p-2 rounded transition-colors transform translate duration-400 hover:scale-105 cursor-pointer select-none"><img class="w-6 h-6" src="assets/icons/PresumedImportantCulturalProperty_b-3.svg" alt="">
                                            &nbsp;&nbsp;<span class="hover:overline">Presumed Important Cultural Properties</span></label>
                                    </li>
                                  
                                    <li class="flex items-center relative group">
                                        <input id="UNESCOWorldHeritageSites" type="checkbox" class="mr-2">
                                        <label onclick="showDialog('dialog6')" class="dialog-hover flex items-center text-sm p-2 rounded transition-colors transform translate duration-400 hover:scale-105 cursor-pointer select-none"><img class="w-6 h-6" src="assets/icons/UNESCOWorldHeritage-01.svg" alt="">
                                            &nbsp;&nbsp;<span class="hover:overline">UNESCO World Heritage Sites</span></label>
                                    </li>

                                    <li class="flex items-center relative group">
                                        <input id="HistoricalMarker" type="checkbox" class="mr-2">
                                        <label onclick="showDialog('dialog6')" class="dialog-hover flex items-center text-sm p-2 rounded transition-colors transform translate duration-400 hover:scale-105 cursor-pointer select-none"><img class="w-6 h-6" src="assets/icons/HistoricalMarker2.png" alt="">
                                            &nbsp;&nbsp;<span class="hover:overline">Historical Marker</span></label>
                                    </li>

                                </ul>
                            </div>

                            <div class="space-y-2 relative h-full w-full bg-white pb-auto mt-2">
                                <div class="flex items-center">
                                    <input type="checkbox" id="localCulturalCheckbox" <?php echo $isLocal ? 'checked' : ''; ?> onclick="toggleLocalProperties()" class="mr-2">
                                    <label for="localCulturalCheckbox" class="flex items-center text-sm p-2 rounded transition-colors transform translate duration-400 hover:scale-105 cursor-pointer select-none">
                                        &nbsp;<span class="hover:overline">Local Cultural Properties</span></label>
                                </div>

                                <ul id="localCulturalList" class="space-y-2 p-2">
                                    <li class="flex items-center relative group">
                                        <input id="LocalCulturalProperties" type="checkbox" class="mr-2">
                                        <label onclick="showDialog('dialog7')" class="dialog-hover flex items-center text-sm  p-2 rounded transition-colors transform translate duration-400 hover:scale-105 cursor-pointer select-none"><img class="w-6 h-6" src="assets/icons/RegisteredCulturalProperties-01.svg" /></img>
                                            &nbsp;&nbsp;<span class="hover:overline">Local Cultural Properties</span></label>
                                    </li>
                                    <li class="flex items-center relative group">
                                        <input id="RegisteredProperties" type="checkbox" class="mr-2">
                                        <label onclick="showDialog('dialog9')" class="dialog-hover flex items-center text-sm  p-2 rounded transition-colors transform translate duration-400 hover:scale-105 cursor-pointer select-none"><img class="w-6 h-6" src="assets/icons/LocalCulturalProperties_b-2.svg" /></img>
                                            &nbsp;&nbsp;<span class="hover:overline">Registered Properties</span></label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        </div>

    </main>
    <?php
    $dialogs = [
        ['id' => 'dialog1', 'title' => 'National Cultural Treasures', 'content' => 'Unique cultural property found locally which has outstanding historical, cultural, artistic, and/or scientific value. It is highly significant and important to the country and is officially declared by a cultural agency like the National Museum (NM).'],
        ['id' => 'dialog2', 'title' => 'Important Cultural Properties', 'content' => 'Cultural property having exceptional cultural, artistic, and historical significance to the Philippines determined by the NM, the National Historical Commission of the Philippines (NHCP), the National Library of the Philippines (NLP), and/or the National Archives of the Philippines (NAP).'],
        ['id' => 'dialog3', 'title' => 'National Historical Shrines', 'content' => 'Cultural property which are hallowed and revered for their history or association as declared by the NHCP and/or other previous iterations of that cultural agency.'],
        ['id' => 'dialog4', 'title' => 'National Historical Landmarks', 'content' => 'Sites or structures that are associated with events or achievements significant to Philippine history as declared by the NHCP and/or other previous iterations of that cultural agency.'],
        ['id' => 'dialog5', 'title' => 'National Historical Monuments', 'content' => 'Structures that honor illustrious persons or commemorate events of historical value as declared by the NHCP and/or other previous iterations of that cultural agency.'],
        ['id' => 'dialog6', 'title' => 'UNESCO World Heritage Sites', 'content' => 'Places listed by the United Nations Educational, Scientific, and Cultural Organization (UNESCO) as having outstanding universal value.'],
        ['id' => 'dialog7', 'title' => 'Local Cultural Properties', 'content' => 'Cultural property declared by a local government unit (LGU) through a local executive order, ordinance, or resolution.'],
        ['id' => 'dialog8', 'title' => 'Presumed Important Cultural Property', 'content' => 'Cultural property which are not declared as National Cultural Treasure, UNESCO World Heritage Site, National Historical Shrine, National Historical Landmark, National Historical Monument, or Important Cultural Property but still possesses the characteristic of an Important Cultural Property.'],
        ['id' => 'dialog9', 'title' => 'Registered Properties', 'content' => 'Cultural Property Significant to Local Culture and History, Documented and Compiled by a Local Government Unit in Its Own Cultural Inventory.']
    ];

    foreach ($dialogs as $dialog) {
        echo "<dialog id='{$dialog['id']}' class='m-auto p-6 rounded-lg max-w-4xl w-1/2 items-center border-0'>
            <h3 class='text-base font-semibold mb-4'>{$dialog['title']}</h3>
            <p class='text-sm text-left mb-4'>{$dialog['content']}</p>
            <button onclick=\"closeDialog('{$dialog['id']}')\" class='bg-primary-600 text-white px-4 py-2 rounded-md hover:text-primary-500 transition-colors'>Close</button>
        </dialog>";
    }?>

    <script>
        const ncpCheckbox = document.getElementById('nationalCulturalCheckbox');
        const lcpCheckbox = document.getElementById('localCulturalCheckbox');
        const ncpDetails = document.getElementById('ncp-details');
        const lcpDetails = document.getElementById('lcp-details');
        const NationalCulturalTreasures = document.getElementById('NationalCulturalTreasures');
        const ImportantCulturalProperties = document.getElementById('ImportantCulturalProperties');
        const NationalHistoricalShrines = document.getElementById('NationalHistoricalShrines');
        const NationalHistoricalLandmarks = document.getElementById('NationalHistoricalLandmarks');
        const NationalHistoricalMonuments = document.getElementById('NationalHistoricalMonuments');
        const ClassifiedHistoricStructures = document.getElementById('ClassifiedHistoricStructures');
        const UNESCOWorldHeritageSites = document.getElementById('UNESCOWorldHeritageSites');
        const LocalCulturalProperties = document.getElementById('LocalCulturalProperties');
        const RegisteredProperties = document.getElementById('RegisteredProperties');
        const PresumedImportantCulturalProperties = document.getElementById('PresumedImportantCulturalProperties');
        const HistoricalMarker = document.getElementById('HistoricalMarker');


        function toggleNationalProperties() {
            const checkbox = document.getElementById('nationalCulturalCheckbox');
            const list = document.getElementById('nationalCulturalList');
            list.classList.toggle('hidden', !checkbox.checked);
        }

        function toggleLocalProperties() {
            const checkbox = document.getElementById('localCulturalCheckbox');
            const list = document.getElementById('localCulturalList');
            list.classList.toggle('hidden', !checkbox.checked);
        }

        function showDialog(dialogId) {
            const dialog = document.getElementById(dialogId);
            dialog.showModal();
        }

        function closeDialog(dialogId) {
            const dialog = document.getElementById(dialogId);
            dialog.close();
        }



        document.addEventListener('DOMContentLoaded', function() {
            const drawerButton = document.querySelector('[data-drawer-target="drawer"]');
            const drawer = document.getElementById('drawer');
            const closeButton = document.querySelector('[data-drawer-hide="drawer"]');


            drawerButton.addEventListener('click', function() {
                drawer.classList.toggle('-translate-x-full');
            });


            closeButton.addEventListener('click', function() {
                drawer.classList.add('-translate-x-full');
            });
        });

    </script>
    <script src="src/qgis/ncp4/js/qgis2web_expressions.js"></script>
    <script src="src/qgis/ncp4/js/leaflet.js"></script>
    <script src="src/qgis/ncp4/js/leaflet.rotatedMarker.js"></script>
    <script src="src/qgis/ncp4/js/leaflet.pattern.js"></script>
    <script src="src/qgis/ncp4/js/leaflet-hash.js"></script>
    <script src="src/qgis/ncp4/js/Autolinker.min.js"></script>
    <script src="src/qgis/ncp4/js/rbush.min.js"></script>
    <script src="src/qgis/ncp4/js/labelgun.min.js"></script>
    <script src="src/qgis/ncp4/js/labels.js"></script>
    <script src="src/qgis/ncp4/data/Water_1_0.js"></script>
    <script src="src/qgis/ncp4/data/Provinces_Selected_1.js"></script>
    <script src="src/qgis/ncp4/data/Cebu_2.js"></script>
    <script src="src/qgis/ncp4/data/HighwayTrunk_mod_3.js"></script>
    <script src="src/qgis/ncp4/data/HighwaySecondary_mod_4.js"></script>
    <script src="src/qgis/ncp4/data/HighwayPrimary_mod_5.js"></script>
    <script src="src/qgis/ncp4/data/NaturalWood_mod_6.js"></script>
    <script src="src/qgis/ncp4/data/NaturalGrassland_7.js"></script>
    <script src="src/qgis/ncp4/data/LeisurePark_mod_8.js"></script>
    <script src="src/qgis/ncp4/data/LanduseForest_9.js"></script>
    <script src="src/qgis/ncp4/data/LatLonNCP_10.js"></script>
    <script src="src/qgis/ncp4/data/LatLonLocalSignificantSites_0.js"></script>
    <script src="src/js/map.js"></script>
    <script src="src/js/index.js"></script>
    <style>
        dialog::backdrop {
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(1px);
        }
    </style>
</body>

</html>