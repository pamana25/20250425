<?php include '../includes/header.php' ?>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<body>
    <main class="relative">
        <div id="map" class="w-full h-[calc(100vh-64.8px)]"></div>
        <div id="load" class="absolute top-0 inset-0 bg-white h-full w-full z-[9999] flex flex-col justify-center items-center">
            <div id="loader" class="w-10 h-10 border-2 border-t-transparent border-blue-500 border-solid rounded-full animate-spin spinner"></div>
            <label>Loading...</label>
        </div>
        <div id="sidebar" class="absolute mt-20 inset-0 bg-white text-primary-600 p-4 rounded-md shadow-lg max-w-xs z-[9999] w-full h-fit">
            <div>
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path d="M233.4 105.4c12.5-12.5 32.8-12.5 45.3 0l192 192c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L256 173.3 86.6 342.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l192-192z" />
                    </svg>
                    <button id="ncp-button" class="text-lg font-semibold">National Cultural Properties</button>
                </div>

                <div id="ncp-details" class="hidden">
                    <ul class="property-list space-y-2 p-2 bg-white rounded">
                        <li onclick="showDialog('dialog1')" class="text-sm hover:bg-primary-500 hover:text-white p-2 rounded transition-colors duration-200 cursor-pointer select-none btn btn-primary py-2 transform transition hover:scale-105">National Cultural Treasures</li>
                        <li onclick="showDialog('dialog2')" class="text-sm hover:bg-primary-500 hover:text-white p-2 rounded transition-colors duration-200 cursor-pointer select-none btn btn-primary py-2 transform transition hover:scale-105">Important Cultural Properties</li>
                        <li onclick="showDialog('dialog3')" class="text-sm hover:bg-primary-500 hover:text-white p-2 rounded transition-colors duration-200 cursor-pointer select-none btn btn-primary py-2 transform transition hover:scale-105">National Historical Shrines</li>
                        <li onclick="showDialog('dialog4')" class="text-sm hover:bg-primary-500 hover:text-white p-2 rounded transition-colors duration-200 cursor-pointer select-none btn btn-primary py-2 transform transition hover:scale-105">National Historical Landmark</li>
                        <li onclick="showDialog('dialog5')" class="text-sm hover:bg-primary-500 hover:text-white p-2 rounded transition-colors duration-200 cursor-pointer select-none btn btn-primary py-2 transform transition hover:scale-105">National Historical Monuments</li>
                        <li onclick="showDialog('dialog6')" class="text-sm hover:bg-primary-500 hover:text-white p-2 rounded transition-colors duration-200 cursor-pointer select-none btn btn-primary py-2 transform transition hover:scale-105">UNESCO World Heritage Sites</li>
                        <li onclick="showDialog('dialog8')" class="text-sm hover:bg-primary-500 hover:text-white p-2 rounded transition-colors duration-200 cursor-pointer select-none btn btn-primary py-2 transform transition hover:scale-105">Presumed Important Cultural Property</li>
                    </ul>
                </div>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path d="M233.4 105.4c12.5-12.5 32.8-12.5 45.3 0l192 192c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L256 173.3 86.6 342.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l192-192z" />
                    </svg>
                    <button id="lcp-button" class="text-lg font-semibold">Local Cultural Properties</button>

                </div>
                <div id="lcp-details" class="hidden">
                    <ul class="space-y-2 p-2 bg-white rounded">
                        <li onclick="showDialog('dialog7')">Local Cultural Properties</li>
                        <li onclick="showDialog('dialog9')">Registered Properties</li>
                    </ul>
                </div>
            </div>

            <!-- <div class="space-y-2 relative h-full w-full bg-white pb-auto">
                <div id="nationalProperties" class="absolute inset-0 h-full w-full rounded">


                </div>

                <div id="localProperties" class="property-list absolute inset-0 bg-white h-full w-full rounded">
                    <ul class="space-y-2 p-2 bg-white rounded">
                        <li onclick="showDialog('dialog7')">Local Cultural Properties</li>
                        <li onclick="showDialog('dialog9')">Registered Properties</li>
                    </ul>
                </div>
            </div> -->


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
        echo "<dialog id='{$dialog['id']}'>
            <h3 class='text-xl font-semibold mb-4'>{$dialog['title']}</h3>
            <p class='text-base text-center mb-4'>{$dialog['content']}</p>
            <button onclick=\"closeDialog('{$dialog['id']}')\" class='bg-primary-600 text-white px-4 py-2 rounded-md hover:text-primary-500 transition-colors'>Close</button>
        </dialog>";
    }
    ?>

    <script>
        // document.getElementById('propertyType').addEventListener('change', function() {
        //     var selectedValue = this.value;
        //     document.getElementById('nationalProperties').classList.toggle('hidden', selectedValue === 'local');
        //     document.getElementById('localProperties').classList.toggle('hidden', selectedValue === 'national');
        // });
        const ncpBtn = document.getElementById('ncp-button');
        const lcpBtn = document.getElementById('lcp-button');
        const ncpDetails = document.getElementById('ncp-details');
        const lcpDetails = document.getElementById('lcp-details');


        // ncpBtn.addEventListener('click', () => {
        //     ncpDetails.classList.toggle('hidden');
        // });
        // lcpBtn.addEventListener('click', () => {
        //     lcpDetails.classList.toggle('hidden');
        // });

        // Dialog functions
        function showDialog(dialogId) {
            document.getElementById(dialogId).showModal();
        }

        function closeDialog(dialogId) {
            document.getElementById(dialogId).close();
        }
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