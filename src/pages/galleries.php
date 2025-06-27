<?php
include('../includes/header.php');
?>

<style>
    /* Custom scrollbar styles for Tailwind */
    .details-content::-webkit-scrollbar {
        width: 6px;
    }

    .details-content::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .details-content::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }

    .details-content::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .thumbnail-container::-webkit-scrollbar {
        height: 6px;
    }

    .thumbnail-container::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .thumbnail-container::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }

    .pagination button {
        transition: all 0.2s;
    }

    .pagination button:disabled {
        cursor: not-allowed;
        opacity: 0.5;
    }

    .tooltip-box {
        position: absolute;
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 6px 12px;
        font-size: 14px;
        border-radius: 4px;
        white-space: nowrap;
        z-index: 1000;
        pointer-events: none;
    }
</style>

<nav class="location-nav bg-white border-b border-gray-300 py-3 px-6 md:px-6 lg:px-28">
    <div class="mx-auto ">
        <ul class="location-pills flex flex-wrap gap-2 list-none " id="ul-areas">
            <!-- list of area already in js -->
        </ul>
    </div>
</nav>

<section class="px-6 mx-auto properties-section py-8 min-h-[600px] relative md:px-6 lg:px-28" id="properties-section">
    <div class="properties-title w-full properties-container flex md:flex justify-between mb-2 items-center px-3">
        <h2 class="title-text text-2xl font-semibold text-gray-800 border-gray-200">
            List of Properties
        </h2>
        <div class="flex my-2 input-search-div">
            <input type="text" id="inputSearch" class=" rounded-lg w-full md:w-[250px] lg:w-[250px] text-base font-light p-2 border hidden md:block lg:block" placeholder="Search for properties">
            <button type="button" id="btnSearch" class="block md:hidden lg:hidden cursor-pointer">
                <svg class="h-6 w-6 text-gray-500 svgSearch" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" />
                    <circle cx="10" cy="10" r="7" />
                    <line x1="21" y1="21" x2="15" y2="15" />
                </svg>
                <svg class="h-6 w-6 text-gray-500 svgClose hidden md:hidden lg:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>

            </button>
        </div>

        <!-- <hr> -->
    </div>
    <hr>
    <div class="container mt-6 properties-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3" id="list-properties-div">

    </div>


    <div id="list-properties-loading" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></div>

    <div id="pagination" class="pagination mt-6 text-[#164c70] flex justify-center items-center space-x-2"></div>
    <!-- <button id="load-more-btn" class="hidden rounded py-2 px-4 bg-[#164c70] text-white ">Load More</button> -->





    <div id="properties-details">

    </div>


</section>

<script src="src/js/galleries.js"></script>
<?php include '../includes/footer.php'; ?>