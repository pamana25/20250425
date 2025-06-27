<?php include '../includes/header.php' ?>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<body>
    <main class="relative">
        <div id="map" class="w-full h-[calc(100vh-64.8px)]"></div>
        <button id="toggleButton" class="absolute bottom-4 left-4 z-10 bg-white px-3 py-2 rounded-md shadow-md hover:bg-gray-100 transition-colors duration-200 text-sm z-[9999] transform transition hover:scale-105">
            View in Dark Mode

        </button>

        <div id="sidebar" class="absolute top-16 left-4 transform -translate-y-1/2 bg-white text-primary-600 p-4 rounded-md shadow-lg max-w-xs z-[9999]">
            <!-- <h2 class="text-xl font-bold mb-4">National Cultural Properties</h2> -->
            <div class="mb-4">
                <select id="propertyType" class="w-full p-2 rounded-md border-gray-300">
                    <option value="national">National Cultural Properties</option>
                    <option value="local">Local Cultural Properties</option>
                </select>
            </div>

            <div class="absolute inset-0 bg-white w-full h-full mt-16 rounded">
                <div class="space-y-2 relative h-full w-full bg-white pb-auto">
                    <div id="nationalProperties" class="absolute inset-0 h-full w-full rounded">
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

                    <!-- Local Cultural Properties List (Initially hidden) -->
                    <div id="localProperties" class="property-list hidden absolute inset-0 bg-white h-full w-full rounded">
                        <ul class="space-y-2 p-2 bg-white rounded">
                            <li onclick="showDialog('dialog7')">Local Cultural Properties</li>
                            <li onclick="showDialog('dialog9')">Registered Properties</li>
                        </ul>
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
        echo "<dialog id='{$dialog['id']}'>
            <h3 class='text-xl font-semibold mb-4'>{$dialog['title']}</h3>
            <p class='text-base text-center mb-4'>{$dialog['content']}</p>
            <button onclick=\"closeDialog('{$dialog['id']}')\" class='bg-primary-600 text-white px-4 py-2 rounded-md hover:text-primary-500 transition-colors'>Close</button>
        </dialog>";
    }
    ?>

    <script>
        document.getElementById('propertyType').addEventListener('change', function() {
            var selectedValue = this.value;
            document.getElementById('nationalProperties').classList.toggle('hidden', selectedValue === 'local');
            document.getElementById('localProperties').classList.toggle('hidden', selectedValue === 'national');
        });

        // Dialog functions
        function showDialog(dialogId) {
            document.getElementById(dialogId).showModal();
        }

        function closeDialog(dialogId) {
            document.getElementById(dialogId).close();
        }
    </script>
    <script src="src/qgis/ncp4/js/Autolinker.min.js"></script>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script src="src/js/mapv1.js"></script>
    <script src="src/js/index.js"></script>
    <style>
        dialog::backdrop {
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(1px);
        }
    </style>
</body>

</html>