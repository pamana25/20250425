<?php
include('../includes/header.php');
?>

<main class="flex-grow mx-auto px-4 sm:px-6 lg:px-28 py-10 flex justify-center align-center">
    <div class="container max-w-7xl">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-primary-600">Manage Files</h1>
            <a href="community" class="flex items-center gap-2 px-4 py-2 border border-gray-300 text-white bg-primary-600 rounded-md text-sm font-medium hover:bg-primary-500 transition duration-150 ease-in-out transform transition duration-300 hover:scale-105">
                <i class="fas fa-chevron-left"></i>
                Back
            </a>
        </div>

        <div class="bg-white border rounded-lg shadow-sm min-h-[600px]">
            <div class="border-b">
                <div class="flex">
                    <button id="national-tab" class="flex-1 px-4 py-2 text-base font-bold text-primary-600 border-b-2 border-blue-600">
                        National Cultural Properties
                    </button>
                    <button id="local-tab" class="flex-1 px-4 py-2 text-base font-bold text-primary-600 border-b-2 border-blue-600">
                        Local Cultural Properties
                    </button>
                    <!-- <button id="national-tab" class="flex-1 px-4 py-2 text-sm font-medium text-blue-600 border-b-2 border-blue-600" onclick="switchTab('national')">
                        National Cultural Properties
                    </button>
                    <button id="local-tab" class="flex-1 px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700" onclick="switchTab('local')">
                        Local Cultural Properties
                    </button> -->
                </div>
            </div>

            <div id="national-content" class=" flex flex-col justify-between" data-id="<?= $_SESSION['userid'] ?>">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <th class="px-6 py-3">Date & Time Uploaded</th>
                                <th class="px-6 py-3">Cultural Property Name</th>
                                <th class="px-6 py-3">Description</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody id="table-body" class="bg-white divide-y divide-gray-200">
                           <!-- Dynamic content will be injected here -->
                        </tbody>
                    </table>
                </div>

                <!-- <div id="pagination-controls" class="flex items-center justify-between px-6 py-4 border-t overflow-x-scroll">
                    <p class="text-sm text-gray-500">
                        Showing 1 to 5 of 7 entries
                    </p>
                    <div class="flex items-center gap-2">
                        <button class="px-3 py-1 border rounded text-sm text-gray-500 bg-gray-100" disabled>Previous</button>
                        <button class="px-3 py-1 border rounded text-sm text-white bg-blue-600">1</button>
                        <button class="px-3 py-1 border rounded text-sm text-gray-700 hover:bg-gray-50">2</button>
                        <button class="px-3 py-1 border rounded text-sm text-gray-700 hover:bg-gray-50">Next</button>
                    </div>
                </div> -->

                <div class="pagination-wrapper flex items-center justify-end mt-4 space-x-2 text-sm mb-3">
                    <span id="showing-entries" class="mr-4 text-primary-600"></span>
                    <nav>
                        <ul id="pagination-controls" class="flex items-center space-x-1 w-96 text-primary-600">
                        <!-- Pagination controls will be dynamically injected -->
                        </ul>
                    </nav>
                </div>

            </div>

            <!-- <div id="local-content" class="hidden">
                <div class="p-6 text-center text-gray-500">
                    No local cultural properties found
                </div>
            </div> -->
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
<script src="src/js/view_uploaded.js"></script>
<script>
   
</script>