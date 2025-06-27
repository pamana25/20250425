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

       <section id="about-us" class="bg-gray-100 text-black px-4 sm:px-6 lg:px-28 py-12">
           <div class="container mx-auto">
               <h2 class="text-3xl font-bold text-primary-600 mb-4">About Us</h2>
               <p class="text-gray-700 mb-4">The Pamana website was developed through an envisioned partnership between Constant Motion Studio and the United Architects of the Philippines (UAP) – Special Council on Architectural Heritage Conservation.The Special Council launched a series of seminar-workshops in 2019, entitled "Built Heritage Mapping and Inventory." However, the Special Council was subsequently dissolved.</p>
               <p class="text-gray-700 mb-4">Although the partnership did not materialize, Constant Motion Studio continued to build this online repository platform to assist local government units with the mapping and inventory of cultural properties. The current objective of this website is to enable the public to easily access information about cultural properties, and to gather information about these sites through crowdsourcing. In the future, we hope to enable communities to nominate sites for inclusion in the Philippine Registry of Cultural Properties (PRECUP).</p>

               <p class="text-gray-700 mb-4">This pilot website is currently focused on the island of Cebu and it’s natural and cultural heritage sites. The plan is to expand the repository to all regions of the Philippines. If you are interested in joining our project of creating an inventory of natural and cultural heritage assets, please join our community by creating an account. We also look forward to partnering with various organizations and local government units to collect data and grow our online repository.</p>

               <p class="text-gray-700 mb-4">For more information about Pamana.org, please contact us at <span class="underline" type="email">community@pamana.org</span>.</p>
               <p class="text-gray-700 mb-4">Constant Motion Studio is a digital media laboratory for planning and design. You can visit their website at <a href="https://www.constantmotionstudio.com" target="_blank" class="text-blue-500">www.constantmotionstudio.com</a>.</p>
           </div>
       </section>

       <!-- Local and National Significant Sections -->

       <div id="maps" class="bg-white mx-auto px-4 sm:px-6 lg:px-28 py-12">
           <h2 class="text-3xl font-bold text-primary-600 mb-4">Maps of Heritage Sites</h2>
           <div class="flex flex-col lg:flex-row -mx-4 space-y-8 lg:space-y-0 lg:space-x-4">

               <!-- National Significant Section -->
               <button class="w-full bg-white lg:w-1/2 px-4 flex flex-col transform transition duration-300  hover:scale-105" value="ncp" id="toMap">
                   <div class="bg-white rounded-lg shadow-lg overflow-hidden flex-1">
                       <div class="relative w-full h-[300px] sm:h-[400px]">
                           <img src="<?php echo $nationalSignificant['image']; ?>" alt="Local Cultural Properties" class="w-full h-full object-cover">
                           <!-- <p class="absolute text-xs bottom-0 text-white right-2">Ben Medina, Constant Motion Studio, © 2025</p> -->
                       </div>


                       <div class="p-4 flex-1 flex flex-col">
                           <h2 class="text-2xl font-bold mb-2 text-primary-600"><?php echo $nationalSignificant['title']; ?></h2>
                           <p class="text-gray-500 flex-1 text-gray-700"><?php echo $nationalSignificant['description']; ?></p>
                       </div>
                   </div>
               </button>
               <!-- Local Significant Section -->
               <button class="w-full bg-white lg:w-1/2 px-4 flex flex-col transform transition duration-300 hover:scale-105" value="lcp" id="toMap">
                   <div class="bg-white rounded-lg shadow-lg overflow-hidden flex-1">
                       <div class="relative w-full h-[300px] sm:h-[400px] ">
                           <img src="<?php echo $localSignificant['image']; ?>" alt="National Cultural Properties" class="w-full h-full object-cover">
                           <!-- <p class="absolute text-xs bottom-0 text-white right-2">Ben Medina, Constant Motion Studio, © 2025</p> -->
                       </div>
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
                   <p class="text-gray-700">As part of the community, there are ways to help your Local Government Units maintain an updated registry of your local heritage sites. You may nominate structures such as houses, chapels, churches, or schools that are not yet established as heritage sites.
                   </p>
                   <p class="text-gray-700">
                       You may also send photos, videos, and other types of media about existing heritage sites. Historical photos help us keep track of the damages, repairs, and other changes that have been made to the structures as time goes by, especially those that have been destroyed by typhoons, earthquakes, and fire.
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
                   <figure class="relative w-full h-[300px] sm:h-[350px] mx-auto ">
                       <img src="assets/images/community-image/community.jpg" class="w-full h-full object-cover rounded-lg shadow-lg" alt="">
                       <!-- <p class="absolute text-xs bottom-0 text-white right-1">Marian Bas, Constant Motion Studio, © 2025</p> -->
                   </figure>
               </div>
           </section>

       </main>

       <!-- <div class="" id="back-to-top"></div> -->
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