<?php include '../includes/header.php';
?>
<!-- <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> -->
<!-- Hero Section with Video Background -->
<section class="relative h-[70vh] overflow-hidden">
    <video
        autoplay
        loop
        muted
        class="absolute w-full h-full object-cover">
        <source src="./assets/videos/bagacay_video_render_baa.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="absolute left-0 right-0 top-0 bottom-0 bg-black-50 flex items-center justify-center">
        <div class="text-center text-white  px-4">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Preserve Our Heritage</h1>
            <p class="text-xl md:text-2xl mb-8">
                Join our community in maintaining the rich cultural legacy of Cebu. Every contribution matters.
            </p>
            <a
                href="#actions"
                class="bg-white text-primary-600 px-8 py-3 rounded-full text-lg font-semibold hover:bg-indigo-100 transition transform hover:scale-105 inline-block">
                Get Involved
            </a>
        </div>
    </div>
</section>

<!-- Main Content -->
<main class="flex-grow mx-auto px-4 py-12">
    <div class="mx-auto px-4 sm:px-6 lg:px-28 py-4">
        <h2 class="text-3xl font-bold text-primary-600 mb-6">How You Can Help</h2>
        <p class="text-lg text-gray-700 mb-8">
            As part of the community, there are ways to help your Local Government Units maintain an updated registry of your local heritage sites. You may nominate structures such as houses, chapels, churches, or schools that are not yet enlisted as a heritage site.
        </p>
        <p class="text-lg text-gray-700 mb-12">
            You may also send photos, videos, and other types of media about existing heritage sites. Old photos help us keep track of the damages, repairs, and other changes that have been done to the structures as time goes by, especially those that have been destroyed by typhoons, earthquakes, and fire.
        </p>

        <!-- Action Cards -->
        <div id="actions" class="grid md:grid-cols-3 space-y-4 md:space-y-0 md:space-x-6 mb-16">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition duration-300">
                <div class="p-6">
                    <i class="fas fa-plus-circle text-5xl text-primary-500 mb-4"></i>
                    <h3 class="text-xl font-semibold text-primary-600 mb-2">Add a property</h3>
                    <p class="text-gray-600 mb-4">You can contribute to expanding our database by submitting a registered cultural property.</p>
                    <a
                        href="<?= $isLogin ? 'upload-properties' : 'login?goto=upload-properties' ?>"
                        class="inline-block bg-primary-500 text-white px-4 py-2 rounded-full hover:bg-primary-700 transition">
                        <?= $isLogin ? 'Add properties' : 'Get Started' ?>
                    </a>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition duration-300">
                <div class="p-6">
                    <i class="fas fa-upload text-5xl text-primary-500 mb-4"></i>
                    <h3 class="text-xl font-semibold text-primary-600 mb-2">Upload a photo</h3>
                    <p class="text-gray-600 mb-4">Share images of heritage sites to document changes.</p>
                    <a
                        href="<?= $isLogin ? 'upload-photos' : 'login?goto=upload-photos' ?>"
                        class="inline-block bg-primary-500 text-white px-4 py-2 rounded-full hover:bg-primary-700 transition">
                        Upload Now
                    </a>
                    <?= $isLogin ?
                        '<a
                            href="view-uploaded"
                            class="inline-block bg-primary-500 text-white px-4 py-2 rounded-full hover:bg-primary-700 transition lg:mt-4 md:mt-2">
                            Manage Uploads
                        </a>'
                        : '' ?>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition duration-300">
                <div class="p-6">
                    <i class="fas fa-eye text-5xl text-primary-500 mb-4"></i>
                    <h3 class="text-xl font-semibold text-primary-600 mb-2">View heritage sites</h3>
                    <p class="text-gray-600 mb-4">Learn more about our built heritage by visiting our cultural property database.</p>

                    <a
                        href="galleries"
                        class="inline-block bg-primary-500 text-white px-4 py-2 rounded-full hover:bg-primary-700 transition">
                        Explore
                    </a>
                </div>
            </div>
        </div>
        <!-- Featured Heritage Site -->
        <h2 class="text-3xl font-bold text-primary-700 mb-6">Featured Heritage Site</h2>
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-12" id="featured-heritage-div">
            <!-- the content is in js below -->
        </div>
    </div>
</main>
<button id="to-top-button" onclick="goToTop()" title="Go To Top"
    class="animate-bounce hidden fixed z-50 bottom-10 right-10 p-4 border-0 w-14 h-14 rounded-full shadow-md bg-primary-600 hover:bg-primary-700 text-white text-lg font-semibold transition-colors duration-300 flex items-center justify-center">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class=" w-6 h-6">
        <path d="M12 4l8 8h-6v8h-4v-8H4l8-8z" />
    </svg>
    <span class="sr-only">Go to top</span>
</button>
<!-- Footer -->
<?php include '../includes/footer.php'; ?>

</body>

</html>
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const featureHeritageDiv = document.getElementById("featured-heritage-div");

        // Function to calculate the current week of the year
        function getCurrentWeek() {
            const now = new Date();
            const startOfYear = new Date(now.getFullYear(), 0, 1);
            const days = Math.floor((now - startOfYear) / (24 * 60 * 60 * 1000)); // Total days elapsed since start of the year
            return Math.ceil((days + startOfYear.getDay() + 1) / 7); // Calculate the week number
        }

        // Function to fetch heritage data
        const featuredHeritage = async () => {
            try {
                const response = await fetch('backend/api/featured-heritage.php', {
                    method: "GET"
                });
                const data = await response.json();
                const shuffled = data.sort(() => Math.random() - 0.5);
                const sorted = shuffled.sort((a, b) => a.title.localeCompare(b.title));
                console.log(sorted)
                return sorted;
            } catch (error) {
                console.error("Error fetching heritage data:", error.message);
            }
        };

        // State
        let currentImageIndex = 0; // Index of the current image within the selected heritage
        let allProperties = []; // All fetched heritage properties
        let currentIndex = 0; // Index of the currently featured heritage based on the week

        // Function to render the featured heritage and its images
        const renderHeritage = () => {
            if (!allProperties || allProperties.length === 0) return;

            const featuredProperty = allProperties[currentIndex]; // Current heritage property
            const images = featuredProperty.image; // Images of the current heritage
            const totalImages = images.length > 3 ? 3 : images.length; // set to 3 images only to display
            // Get the current image
            const currentImage = images[currentImageIndex] || {
                file: 'assets/img/galleryimgs/default.jpg',
            };

            // Determine the image source
            const imageSrc =
                featuredProperty.type === "ncp" ?
                `useruploads/ncp/${currentImage.file}` :
                `useruploads/lss/${currentImage.file}`;

            // Render the heritage and navigation UI
            featureHeritageDiv.innerHTML = `
        <a href="galleries?area=${featuredProperty.town.toLowerCase()}&areaid=${featuredProperty.areaid}&id=${featuredProperty.id}&type=${featuredProperty.type === "ncp" ? "ncpid" : "lcpid"}" class="cursor-pointer">
            <div class="relative h-[400px]">
                <img src="${imageSrc}" alt="${featuredProperty.title}" class="w-full h-full object-cover">
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-6">
                    <h3 class="text-2xl font-bold text-white">${featuredProperty.title}</h3>
                    <span class="text-white">${featuredProperty.town}</span>
                </div>
            </div>
        </a>
        <div class="flex justify-between p-4">
            <button id="prev-img-btn" class="text-primary-600 hover:text-primary-500 bg-transparent transition">Previous Image</button>
            <button id="next-img-btn" class="text-primary-600 hover:text-primary-500 bg-transparent transition">Next Image</button>
        </div>
    `;

            // Attach event listeners for navigating images within this heritage
            document.getElementById("prev-img-btn").addEventListener("click", () => {
                currentImageIndex = (currentImageIndex - 1 + totalImages) % totalImages; // Circular image navigation
                renderHeritage();
            });

            document.getElementById("next-img-btn").addEventListener("click", () => {
                currentImageIndex = (currentImageIndex + 1) % totalImages; // Circular image navigation
                renderHeritage();
            });
        };

        // Initialize the carousel
        (async () => {
            try {
                allProperties = await featuredHeritage();
                if (allProperties && allProperties.length > 0) {
                    const currentWeek = getCurrentWeek(); // Get the current week number
                    const totalEntries = allProperties.length; // Total heritage properties
                    currentIndex = currentWeek % totalEntries; // Determine the featured property for this week

                    renderHeritage(); // Render the first heritage for the current week
                } else {
                    featureHeritageDiv.innerHTML = `<p>No featured heritage available.</p>`;
                }
            } catch (error) {
                console.error("Error initializing carousel:", error.message);
                featureHeritageDiv.innerHTML = `<p>Failed to load featured heritage.</p>`;
            }
        })();









        // Get the 'to top' button element by ID
        var toTopButton = document.getElementById("to-top-button");

        // Check if the button exists
        if (toTopButton) {

            // On scroll event, toggle button visibility based on scroll position
            window.onscroll = function() {
                if (document.body.scrollTop > 500 || document.documentElement.scrollTop > 500) {
                    toTopButton.classList.remove("hidden");
                } else {
                    toTopButton.classList.add("hidden");
                }
            };

            // Function to scroll to the top of the page smoothly
            window.goToTop = function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            };
            // Center the 'To Top' button
            toTopButton.style.left = "50%";
            toTopButton.style.transform = "translateX(-50%)";
        }

    })
</script>