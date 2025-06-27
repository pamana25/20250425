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
                Join our community in maintaining our rich cultural heritage. Every contribution matters.
            </p>
            <a
                href="#actions"
                class="bg-white text-primary-600 px-8 py-3 rounded-full text-lg font-semibold hover:bg-indigo-100 transition transform hover:scale-105 inline-block">
                Get Involved
            </a>
        </div>
    </div>
    <p class="absolute text-sm bottom-0 right-2 text-white">3D Modeling and Animation by Brayan Anunciado, Constant Motion Studio © 2025</p>
</section>

<!-- Main Content -->
<main class="flex-grow mx-auto px-4 py-12">
    <div class="mx-auto px-4 sm:px-6 lg:px-28 py-4">
        <h2 class="text-3xl font-bold text-primary-600 mb-6">How You Can Help</h2>
        <p class="text-lg text-gray-700 mb-8">
            As part of the community, there are ways to help your Local Government Units maintain an updated registry of your local heritage sites. You may nominate structures such as houses, chapels, churches, or schools that are not yet enlisted as a heritage site.
        </p>
        <p class="text-lg text-gray-700 mb-12">
            You may also send photos, videos, and other types of media about existing heritage sites. Historical photos help us keep track of the damages, repairs, and other changes that have been done to the structures as time goes by, especially those that have been destroyed by typhoons, earthquakes, and fire.
        </p>

        <!-- Action Cards -->
        <div id="actions" class="grid md:grid-cols-3 space-y-4 md:space-y-0 md:space-x-6 mb-16">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition duration-300 flex flex-col">
                <div class="px-6 py-4 flex-grow">
                    <i class="fas fa-plus-circle text-5xl text-primary-500 mb-4"></i>
                    <h3 class="text-xl font-semibold text-primary-600 mb-2">Add a Property</h3>
                    <p class="text-gray-600 mb-4">Nominate a new heritage site for preservation.</p>
                </div>
                <div class="px-6 pb-4">
                    <a
                        href="<?= $isLogin ? 'upload-properties' : 'login?goto=upload-properties' ?>"
                        class="inline-block bg-primary-500 text-white px-4 py-2 rounded-full hover:bg-primary-700 transition">
                        <?= $isLogin ? 'Add properties' : 'Get Started' ?>
                    </a>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition duration-300 flex flex-col">
                <div class="px-6 py-4 flex-grow">
                    <i class="fas fa-upload text-5xl text-primary-500 mb-4"></i>
                    <h3 class="text-xl font-semibold text-primary-600 mb-2">Upload a Photo</h3>
                    <p class="text-gray-600 mb-4">Share images of heritage sites to document changes.</p>
                </div>
                <div class="px-6 pb-4">
                    <a
                        href="<?= $isLogin ? 'upload-photos' : 'login?goto=upload-photos' ?>"
                        class="inline-block bg-primary-500 text-white px-4 py-2 rounded-full hover:bg-primary-700 transition">
                        Upload Now
                    </a>
                    <?= $isLogin ?
                        '<a
                    href="view-uploaded"
                    class="iinline-block bg-primary-500 text-white px-4 py-2 rounded-full hover:bg-primary-700 transition">
                    Manage Uploads
                </a>'
                        : '' ?>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition duration-300 flex flex-col">
                <div class="px-6 py-4 flex-grow">
                    <i class="fas fa-eye text-5xl text-primary-500 mb-4"></i>
                    <h3 class="text-xl font-semibold text-primary-600 mb-2">View heritage sites</h3>
                    <p class="text-gray-600 mb-4">Explore and learn about heritage sites.</p>
                </div>
                <div class="px-6 pb-4">
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

<!-- Footer -->
<?php include '../includes/footer.php'; ?>

</body>

</html>
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const featureHeritageDiv = document.getElementById("featured-heritage-div");

        function getCurrentMonth() {
            const now = new Date();
            return now.getMonth(); // 0-based (0 = January, 11 = December)
        }

        const featuredHeritage = async () => {
            try {
                const response = await fetch('backend/api/featured-heritage.php', {
                    method: "GET"
                });
                const data = await response.json();
                return data.sort(() => Math.random() - 0.5).sort((a, b) => a.title.localeCompare(b.title));
            } catch (error) {
                console.error("Error fetching heritage data:", error.message);
                return [];
            }
        };

        let currentImageIndex = 0;
        let allProperties = [];
        let currentIndex = 0;

        const getFileSize = async (imageUrl) => {
            try {
                const response = await fetch(imageUrl, {
                    method: "HEAD"
                });
                const size = response.headers.get("Content-Length");
                return size ? parseInt(size, 10) : 0;
            } catch (error) {
                console.error("Error fetching file size:", error);
                return 0;
            }
        };

        const getImagesWithSizes = async (images, type) => {
            return await Promise.all(
                images.map(async (img) => {
                    const filePath = type === "ncp" ? `useruploads/ncp/${img.file}` : `useruploads/lss/${img.file}`;
                    const size = await getFileSize(filePath);
                    return {
                        ...img,
                        filePath,
                        size
                    };
                })
            );
        };

        const findValidHeritage = async () => {
            let attempts = 0;
            let maxAttempts = allProperties.length;

            while (attempts < maxAttempts) {
                const featuredProperty = allProperties[currentIndex];
                let images = await getImagesWithSizes(featuredProperty.image || [], featuredProperty.type);

                if (images.length) {
                    images.sort((a, b) => b.size - a.size);
                    const largestImage = images[0];

                    // If at least one image is greater than 500KB, use this property
                    if (largestImage.size > 800 * 1024) {
                        return featuredProperty;
                    }
                }

                // Move to the next property if no image is above 500KB
                currentIndex = (currentIndex + 1) % allProperties.length;
                attempts++;
            }

            // If no valid heritage is found, return the first one as a fallback
            return allProperties.length ? allProperties[0] : null;
        };

        const renderHeritage = async () => {
            if (!allProperties.length) return;

            const featuredProperty = await findValidHeritage();
            console.log("Featured Property:", featuredProperty);
            if (!featuredProperty) {
                featureHeritageDiv.innerHTML = `<p>No valid featured heritage available.</p>`;
                return;
            }

            let images = await getImagesWithSizes(featuredProperty.image || [], featuredProperty.type);

            if (!images.length) {
                featureHeritageDiv.innerHTML = `<p>No images available.</p>`;
                return;
            }

            images.sort((a, b) => b.size - a.size);
            currentImageIndex = currentImageIndex % images.length;
            const currentImage = images[currentImageIndex];

            featureHeritageDiv.innerHTML = `
            <a href="galleries?area=${featuredProperty.town.toLowerCase()}&areaid=${featuredProperty.areaid}&id=${featuredProperty.id}&type=${featuredProperty.type === "ncp" ? "ncpid" : "lcpid"}" class="cursor-pointer">
                <div class="relative h-[400px]">
                    <img src="${currentImage.filePath}" alt="${featuredProperty.title}" class="w-full h-full object-cover">
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

            document.getElementById("prev-img-btn").addEventListener("click", () => {
                currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
                renderHeritage();
            });

            document.getElementById("next-img-btn").addEventListener("click", () => {
                currentImageIndex = (currentImageIndex + 1) % images.length;
                renderHeritage();
            });
        };

        (async () => {
            try {
                allProperties = await featuredHeritage();
                if (allProperties.length) {
                    currentIndex = getCurrentMonth() % allProperties.length;
                    await renderHeritage();
                } else {
                    featureHeritageDiv.innerHTML = `<p>No featured heritage available.</p>`;
                }
            } catch (error) {
                console.error("Error initializing carousel:", error.message);
                featureHeritageDiv.innerHTML = `<p>Failed to load featured heritage.</p>`;
            }
        })();
    });
</script>