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
        <h2 class="properties-title text-2xl font-semibold text-gray-800 mb-2 pb-3 border-gray-200">
            List of Properties
            <input type="text" id="inputSearch" class="float-end rounded-lg w-[250px] border text-base font-light p-2 border" placeholder="Search for properties">
        </h2>
        <hr>
    </div>
    <div class="container mt-6 properties-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="list-properties-div">
    
    </div>
    
    
    <div id="list-properties-loading" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></div>

    <div class="mt-6 w-full text-center">
    <button id="load-more-btn" class="hidden rounded py-2 px-4 bg-[#164c70] text-white ">Load More</button>

    </div>
    
    

    <div id="properties-details">

    </div>
   

</section>
<button id="to-top-button" onclick="goToTop()" title="Go To Top"
    class="animate-bounce hidden fixed z-50 bottom-10 right-10 p-4 border-0 w-14 h-14 rounded-full shadow-md bg-primary-600 hover:bg-primary-700 text-white text-lg font-semibold transition-colors duration-300 flex items-center justify-center"
    >
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class=" w-6 h-6">
        <path d="M12 4l8 8h-6v8h-4v-8H4l8-8z" />
    </svg>
    <span class="sr-only">Go to top</span>
</button>


<script src="src/js/galleries.js"></script>
<?php include '../includes/footer.php'; ?>