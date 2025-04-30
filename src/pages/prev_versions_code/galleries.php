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
</style>

<nav class="location-nav bg-white border-b border-gray-300 py-3 px-28">
    <div class="mx-auto ">
        <ul class="location-pills flex flex-wrap gap-2 list-none " id="ul-areas">
            <!-- list of area already in js -->
        </ul>
    </div>
</nav>

<section class="px-28 mx-auto properties-section py-8 min-h-[600px] relative" id="properties-section">
    <div class="properties-container max-w-7xl mx-auto ">
        <h2 class="properties-title text-2xl font-semibold text-gray-800 mb-6 pb-3 border-b-2 border-gray-200">List of Properties</h2>
    </div>
    <div class="container properties-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="list-properties-div">

    </div>
    
    <div id="list-properties-loading" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></div>

   

    <div id="properties-details">

    </div>
</section>




<script src="src/js/galleries.js"></script>
<?php include '../includes/footer.php'; ?>