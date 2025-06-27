<?php include '../includes/header.php' ?>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<body>
    <main class="relative">
        <div id="map" class="w-full h-[calc(100vh-64.8px)]"></div>
        <button id="toggleButton" class="absolute bottom-4 left-4 z-10 bg-white px-3 py-2 rounded-md shadow-md hover:bg-gray-100 transition-colors duration-200 text-sm z-[9999] transform transition hover:scale-105">
            View in Dark Mode
        </button>

        <div id="sidebar" class="absolute top-24 left-4 transform -translate-y-1/2 bg-white text-primary-600 p-4 rounded-md shadow-lg max-w-xs z-[9999]">
            <h2 class="text-xl font-bold mb-4">Local Cultural Properties</h2>
            <ul class="space-y-2">
                <li onclick="showDialog('dialolg1')" class="text-sm hover:bg-primary-500 hover:text-white p-2 rounded transition-colors duration-200 cursor-pointer select-none btn btn-primary py-2 transform transition hover:scale-105">
                    Local Cultural Properties
                </li>

                <li onclick="showDialog('dialog2')" class="text-sm hover:bg-primary-500 hover:text-white p-2 rounded transition-colors duration-200 cursor-pointer select-none btn btn-primary py-2 transform transition hover:scale-105">
                    Registered Properties
                </li>
            </ul>


        </div>
    </main>
    <dialog id="dialolg1" class="m-auto p-4 rounded-lg max-w-lg w-full  items-center border-0">
        <h3 class="text-xl font-semibold mb-4">Local Cultural Properties</h3>
        <p class="text-base text-center mb-4">Cultural property declared by a local government unit (LGU) through a local executive order, ordinance, or resolution.</p>

        <div class="w-full flex justify-end">
            <button onclick="closeDialog('dialolg1')" class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-500 transition-colors">
                Close
            </button>
        </div>
    </dialog>
    <dialog id="dialog2" class="m-auto p-4 rounded-lg max-w-lg w-full  items-center border-0">
        <h3 class="text-xl font-semibold mb-4">Registered Properties</h3>
        <p class="text-base text-center mb-4">Cultural Property Significant to Local Culture and History, Documented and Compiled by a Local Government Unit in Its Own Cultural Inventory.</p>

        <div class="w-full flex justify-end">
            <button onclick="closeDialog('dialog2')" class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-500 transition-colors">Close</button>
        </div>
    </dialog>

    <script>
        function showDialog(dialogId) {
            const dialog = document.getElementById(dialogId);
            dialog.showModal();
        }

        function closeDialog(dialogId) {
            const dialog = document.getElementById(dialogId);
            dialog.close();
        }

        // Close dialog when clicking outside
        document.querySelectorAll('dialog').forEach(dialog => {
            dialog.addEventListener('click', (e) => {
                const dialogDimensions = dialog.getBoundingClientRect();
                if (
                    e.clientX < dialogDimensions.left ||
                    e.clientX > dialogDimensions.right ||
                    e.clientY < dialogDimensions.top ||
                    e.clientY > dialogDimensions.bottom
                ) {
                    dialog.close();
                }
            });
        });
    </script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
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