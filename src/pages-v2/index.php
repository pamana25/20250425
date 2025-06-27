       <?php include('../includes/header.php'); ?>
       <style>
           #carouselItemsContainer img {
               width: 100%;
               height: 100%;
               /* Set to a specific height if needed */
               object-fit: cover;
               /* or 'contain' based on your design */
           }
       </style>
       <!-- Full-view Carousel -->
       <div id="carousel" class="relative h-[calc(100vh-110px)] overflow-hidden">
           <div class="absolute inset-0 w-full h-full flex transition-transform duration-500 ease-in-out" id="carouselItemsContainer">
               <!-- Carousel items will be injected here by JavaScript -->
           </div>
           <button id="prevBtn" class="h-full bg-transparent absolute top-1/2 left-4 transform -translate-y-1/2 text-white text-4xl z-10"><i class="fas fa-chevron-left"></i></button>
           <button id="nextBtn" class="h-full bg-transparent absolute top-1/2 right-4 transform -translate-y-1/2 text-white text-4xl z-10"><i class="fas fa-chevron-right"></i></button>
           <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2" id="dotsContainer">
               <!-- Dots will be injected here by JavaScript -->
           </div>
       </div>

       <!-- Sample text section  -->
       <!-- <div class="mx-auto px-4 sm:px-6 lg:px-28 py-20">
        <p class="text-center">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde sequi aperiam iure sed officia asperiores dignissimos aliquid? Deserunt nobis minima suscipit aliquam, illo vero necessitatibus dignissimos sint eum. Deleniti eaque numquam voluptas vel fugit similique adipisci, esse maiores ab, quia explicabo iste libero sequi rerum ullam deserunt molestiae natus hic.
        </p>
    </div> -->

       <section id="about-us" class="bg-gray-100 text-black px-4 sm:px-6 lg:px-28 py-12">
           <div class="container mx-auto">
               <h2 class="text-3xl font-bold text-primary-600 mb-4">About Us</h2>
               <p class="text-gray-700 mb-4">The Pamana website was developed alongside an envisioned partnership between Constant Motion Studio and UAP – Special Council on Architectural Heritage Conservation, who launched a series of seminar-workshops in 2019 called "Built Heritage Mapping and Inventory".</p>
               <p class="text-gray-700 mb-4">Although the partnership did not materialize, our Team will continue to build this platform to assist local government units with the inventory of cultural properties. The current objective of this website is to enable the public to easily access information about cultural properties, and to gather information about these sites through crowdsourcing. In the future, we hope to allow communities to nominate sites for inclusion in the Philippine Registry of Cultural Properties (PRECUP).</p>
               <p class="text-gray-700 mb-4">Constant Motion Studio is a digital media laboratory for planning and design. For more information, please contact us at <span class="underline" type="email">community@pamana.org</span></p>
           </div>
       </section>

       <!-- Local and National Significant Sections -->
       <div id="maps" class="bg-white mx-auto px-4 sm:px-6 lg:px-28 py-12">
           <div class="flex flex-col lg:flex-row -mx-4 space-y-8 lg:space-y-0 lg:space-x-4">
               <!-- National Significant Section -->
               <button class="w-full bg-white lg:w-1/2 px-4 flex flex-col transform transition duration-300  hover:scale-105" value="ncp" id="toMap">
                   <div class="bg-white rounded-lg shadow-lg overflow-hidden flex-1">
                       <img src="<?php echo $nationalSignificant['image']; ?>" alt="Local Cultural Properties" class="w-full h-[300px] sm:h-[400px] object-cover">
                       <div class="p-4 flex-1 flex flex-col">
                           <h2 class="text-2xl font-bold mb-2 text-primary-600"><?php echo $nationalSignificant['title']; ?></h2>
                           <p class="text-gray-500 flex-1 text-gray-700"><?php echo $nationalSignificant['description']; ?></p>
                       </div>
                   </div>
               </button>
               <!-- Local Significant Section -->
               <button class="w-full bg-white lg:w-1/2 px-4 flex flex-col transform transition duration-300 hover:scale-105" value="lcp" id="toMap">
                   <div class="bg-white rounded-lg shadow-lg overflow-hidden flex-1">
                       <img src="<?php echo $localSignificant['image']; ?>" alt="National Cultural Properties" class="w-full h-[300px] sm:h-[400px] object-cover">
                       <div class="p-4 flex-1 flex flex-col">
                           <h2 class="text-2xl font-bold mb-2 text-primary-600"><?php echo $localSignificant['title']; ?></h2>
                           <p class="text-gray-500 flex-1 text-gray-700"><?php echo $localSignificant['description']; ?></p>
                       </div>
                   </div>
               </button>
           </div>
       </div>

       <!-- Main Content -->
       <main class="w-full">

           <section class="mb-12 flex flex-col lg:flex-row items-center space-y-8 lg:space-y-0 lg:space-x-4 px-4 sm:px-6 lg:px-28 py-12" id="join-community">
               <div class="space-y-4 w-full lg:w-1/2 px-4">
                   <h2 class="text-3xl font-bold mb-4 text-primary-600">Join the Community</h2>
                   <p class="text-gray-700">As part of the community, there are ways to help your Local Government Units maintain an updated registry of your local heritage sites. You may nominate structures such as houses, chapels, churches, or schools that are not yet enlisted as a heritage site.
                   </p>
                   <p class="text-gray-700">
                       You may also send photos, videos, and other types of media about existing heritage sites. Old photos help us keep track of the damages, repairs, and other changes that have been done to the structures as time goes by, especially those that have been destroyed by typhoons, earthquakes, and fire.
                   </p>
                   <?php
                    if (isset($_SESSION['userid'])) {
                        echo '<div class="flex items-center space-x-5">
                                <a href="community" class="bg-primary-600 text-white px-3 py-1.5 rounded hover:bg-primary-500 transform transition duration-300 hover:scale-105">
                                Learn More
                                </a>
                            </div>';
                    } else {
                        echo '<div class="flex space-x-5">
                                <a href="signup" class="bg-primary-600 text-white px-3 py-1.5 rounded hover:bg-primary-500 transform transition duration-300 hover:scale-105">Create an account</a>
                                <a href="login" class="bg-gray-200 text-primary-600 px-3 py-1.5 rounded hover:bg-gray-300 transform transition duration-300 hover:scale-105">Sign in</a>
                            </div>';
                    }
                    ?>
               </div>
               <div class="w-full lg:w-1/2 px-4">
                   <figure class="w-full h-[300px] sm:h-[350px] mx-auto ">
                       <img src="assets/images/community-image/community.jpg" class="w-full h-full object-cover rounded-lg shadow-lg" alt="">
                   </figure>
               </div>
           </section>

       </main>
       <button id="to-top-button" onclick="goToTop()" title="Go To Top"
           class="animate-bounce hidden fixed z-50 bottom-10 right-10 p-4 border-0 w-14 h-14 rounded-full shadow-md bg-primary-600 hover:bg-primary-700 text-white text-lg font-semibold transition-colors duration-300 flex items-center justify-center">
           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class=" w-6 h-6">
               <path d="M12 4l8 8h-6v8h-4v-8H4l8-8z" />
           </svg>
           <span class="sr-only">Go to top</span>
       </button>
       <!-- Footer -->


       <div class="" id="back-to-top"></div>
       <?php include '../includes/footer.php'; ?>
       <script>
           document.addEventListener('click', (e) => {
               const closestElement = e.target.closest('#toMap');
               if (closestElement) {
                   localStorage.setItem("type", closestElement.value);
                   window.location.href = "map";
               }
           });
       </script>