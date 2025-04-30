<div id="burgerOverlay" class="fixed inset-0 bg-black opacity-0 pointer-events-none transition-opacity duration-300 ease-in-out z-40"></div>
<!-- Transparent Navbar -->

<?php
$page = $_SERVER['REQUEST_URI'];
$active = 'bg-primary-600 text-white rounded py-1 px-4 hover:text-gray-300 transform transition duration-300 hover:scale-105';
$notActive = 'hover:text-gray-300 hover:overline nav-item';

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ./");
    exit();
}
?>

<nav class="" id="navbar">
    <div class="mx-auto px-4 sm:px-6 lg:px-28 py-4 flex justify-between items-center">
        <!-- Left side: Burger icon and logo -->
        <div class="flex items-center ">
            <button id="burgerBtn" class="hidden text-2xl">
                <i class="fas fa-bars"></i>
            </button>
            <a href="<?= $base_url ?>" class="text-2xl font-bold uppercase flex items-center"><img src="<?= $base_url ?>assets/favicons/WebLogo02b.png" class="navbar-brand-img h-14 w-14 mr-2" alt="PAMANA LOGO">
                <p>PAMANA</p>
            </a>
        </div>

        <!-- Right side: Search icon and navbar menu -->
        <div class="flex items-center space-x-4">
            <button id="searchBtn" class="text-xl hidden">
                <i class="fas fa-search"></i>
            </button>
            <!-- Desktop menu -->
            <div class="hidden lg:flex items-center space-x-6">
                <a href="<?= $base_url ?>" class="<?= $page === $base_url ? $active : $notActive ?> transform transition duration-300 hover:scale-105 hover:overline" data-active="home">Home</a>
                <a href="<?= $base_url ?>galleries" class="<?= strpos($page, 'galleries') ? $active : $notActive ?> transform transition duration-300 hover:scale-105 hover:overline" data-active="galleries">Site List</a>
                <a href="<?= $base_url ?>map" value="map" id="navToMap" class="<?= strpos($page, 'map') ? $active : $notActive ?> transform transition duration-300 hover:scale-105 hover:overline" data-active="map">Map</a>
                <a href="<?= $base_url ?>community" class="<?= strpos($page, 'community') ? $active : $notActive ?> transform transition duration-300 hover:scale-105 hover:overline" data-active="community">Community</a>

                <?php if ($isLogin) { ?>
                    <div class="relative group">
                        <a class="<?= strpos($page, 'settings') ? $active : $notActive ?> group-hover:text-gray-300 pb-3 hover:overline ">Account</a>
                        <div class="absolute hidden bg-gray-100 text-gray-800 shadow-lg group-hover:block  -group-hover:bg-primary-500 left-1 rounded z-[10000] mt-3">
                            <a href="settings" class="<?= strpos($page, 'settings') ? $active : $notActive ?> w-auto whitespace-nowrap text-sm block px-4 py-2 hover:bg-gray-200 flex items-center hover:overline hover:rounded nav-item"><svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z" />
                                </svg>Settings</a>
                            <!-- <button id="logout" class="w-auto whitespace-nowrap text-sm block px-4 py-2 hover:bg-gray-200 flex items-center hover:overline hover:rounded"><svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M320 32c0-9.9-4.5-19.2-12.3-25.2S289.8-1.4 280.2 1l-179.9 45C79 51.3 64 70.5 64 92.5L64 448l-32 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l64 0 192 0 32 0 0-32 0-448zM256 256c0 17.7-10.7 32-24 32s-24-14.3-24-32s10.7-32 24-32s24 14.3 24 32zm96-128l96 0 0 352c0 17.7 14.3 32 32 32l64 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-32 0 0-320c0-35.3-28.7-64-64-64l-96 0 0 64z"/></svg>Logout</button>                    -->

                            <form method="POST" class="m-0">
                                <button type="submit" name="logout" class="w-auto whitespace-nowrap text-sm block px-4 py-2 hover:bg-gray-200 flex items-center hover:overline hover:rounded">
                                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path d="M320 32c0-9.9-4.5-19.2-12.3-25.2S289.8-1.4 280.2 1l-179.9 45C79 51.3 64 70.5 64 92.5L64 448l-32 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l64 0 192 0 32 0 0-32 0-448zM256 256c0 17.7-10.7 32-24 32s-24-14.3-24-32s10.7-32 24-32s24 14.3 24 32zm96-128l96 0 0 352c0 17.7 14.3 32 32 32l64 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-32 0 0-320c0-35.3-28.7-64-64-64l-96 0 0 64z" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                <?php } else { ?>
                    <a href="login" class="<?= strpos($page, 'login') ? $active : $notActive ?> rounded py-1 hover:text-gray-300 hover:overline transform transition duration-300 hover:scale-105">Sign in</a>
                <?php } ?>

            </div>
            <!-- Mobile menu button -->
            <button id="ellipsesMenuBtn" class="lg:hidden text-2xl bg-transparent">
                <i class="fas fa-ellipsis-v"></i>
            </button>
        </div>
    </div>
    <!-- Burger Menu (Left Drawer) -->
    <div id="burgerMenu" class=" hidden fixed top-0  left-0 w-9/12 md:w-2/5 h-full bg-white text-black shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out overflow-y-scroll z-[10000]">
        <div class="p-4">
            <h2 class="text-2xl font-bold mb-4 text-primary-600">Explore by Municipalities and Cities</h2>
            <ul id="dynamicMenuItems" class="space-y-2 text-xs sm:text-md">
                <!-- Dynamic menu items will be inserted here -->
            </ul>
        </div>
    </div>

    <!-- Mobile Menu (Right Drawer) -->
    <div id="mobileMenu" class="hidden fixed top-12 right-8 w-56 h-fit rounded-lg bg-primary-600 text-white shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out z-[10000]">
        <div id="mobileMenuContent" class="p-4">
            <h2 class="text-2xl font-bold mb-4 flex justify-center align-center">Menu</h2>
            <ul class="space-y-2">
                <div class="flex flex-col items-center justify-center border-t border-white mt-4 pt-4">
                    <li><a href="./" class="block py-2 px-4 text-white hover:text-gray-200 hover:overline nav-item" data-active="home">Home</a></li>
                    <li><a href="galleries" class="block py-2 px-4 text-white hover:text-gray-200 hover:overline nav-item" data-active="galleries">Site Lists</a></li>
                    <li><a href="map" id="navToMap" value="map" class="block py-2 px-4 text-white hover:text-gray-200 hover:overline nav-item" data-active="map">Map</a></li>
                    <li><a href="community" class="<?= strpos($page, 'community') ? $active : $notActive ?> flex flex-col items-center  py-2 px-4 hover:text-gray-300 hover:overline nav-item" data-active="community">Community</a></li>
                    <li><?php if ($isLogin) { ?>

                            <div class="relative group  flex flex-col items-center  py-2 px-4 flex justify-center">
                                <a id="accountMobileMenu" href="#" class="pb-4 hover:overline">Account</a>
                                <div id="accountDropdownMobileMenu" class="hidden bg-gray-100 text-gray-800 shadow-lg -group-hover:bg-primary-500 right-0 rounded z-[10000] mt-1">
                                    <a id="settingsMobileMenu" href="settings" class="w-auto whitespace-nowrap text-sm block px-4 py-2 hover:bg-gray-200 flex items-center hover:overline hover:rounded    nav-item"><svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z" />
                                        </svg>Settings</a>
                                    <!-- <button id="logoutMobileMenu" class="w-auto whitespace-nowrap text-sm block px-4 py-2 hover:bg-gray-200 flex items-center hover:overline hover:rounded"><svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M320 32c0-9.9-4.5-19.2-12.3-25.2S289.8-1.4 280.2 1l-179.9 45C79 51.3 64 70.5 64 92.5L64 448l-32 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l64 0 192 0 32 0 0-32 0-448zM256 256c0 17.7-10.7 32-24 32s-24-14.3-24-32s10.7-32 24-32s24 14.3 24 32zm96-128l96 0 0 352c0 17.7 14.3 32 32 32l64 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-32 0 0-320c0-35.3-28.7-64-64-64l-96 0 0 64z"/></svg>Logout</button>                    -->
                                    <form method="POST" class="m-0">
                                        <button type="submit" name="logout" class="w-auto whitespace-nowrap text-sm block px-4 py-2 hover:bg-gray-200 flex items-center hover:overline hover:rounded">
                                            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                <path d="M320 32c0-9.9-4.5-19.2-12.3-25.2S289.8-1.4 280.2 1l-179.9 45C79 51.3 64 70.5 64 92.5L64 448l-32 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l64 0 192 0 32 0 0-32 0-448zM256 256c0 17.7-10.7 32-24 32s-24-14.3-24-32s10.7-32 24-32s24 14.3 24 32zm96-128l96 0 0 352c0 17.7 14.3 32 32 32l64 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-32 0 0-320c0-35.3-28.7-64-64-64l-96 0 0 64z" />
                                            </svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php } else { ?>
                            <a href="login" class="flex items-center bg-primary-600 text-white rounded py-2 px-4 hover:text-gray-300 transform transition duration-300 hover:scale-105 hover:overline">Sign in</a>
                        <?php } ?>
                    </li>
                </div>

            </ul>
        </div>
    </div>
</nav>


<script>
    //Mobile menu
    const ellipsesMenuBtn = document.getElementById('ellipsesMenuBtn');
    const ellipsesMenu = document.getElementById('mobileMenu');
    const ellipsesMenuContent = document.getElementById('mobileMenuContent');

    ellipsesMenuBtn.addEventListener('click', () => {
        if (ellipsesMenu.classList.contains('hidden')) {
            ellipsesMenu.classList.remove('hidden');
            ellipsesMenu.style.transform = 'translateX(0)';
        } else {
            ellipsesMenu.classList.add('hidden');
            ellipsesMenu.style.transform = 'translateX(100%)';
        }
    });

    document.addEventListener('click', (e) => {
        if (!ellipsesMenuBtn.contains(e.target) && !ellipsesMenu.contains(e.target)) {
            ellipsesMenu.classList.add('hidden');
            ellipsesMenu.style.transform = 'translateX(100%)';
        }
    });


    //For the Maps Menu on Mobile
    // const mapsMobileMenu = document.getElementById('mapsMobileMenu');
    // const mapsDropdownMobileMenu = document.getElementById('mapsDropdownMobileMenu');

    // mapsMobileMenu.addEventListener('click', () => {
    //     if(mapsDropdownMobileMenu.classList.contains('hidden')) {
    //         mapsDropdownMobileMenu.classList.remove('hidden');
    //         mapsDropdownMobileMenu.style.transform = 'translateX(0)';
    //     }else{
    //         mapsDropdownMobileMenu.classList.add('hidden');
    //         mapsDropdownMobileMenu.style.transform = 'translateX(100%)';
    //     }

    // document.addEventListener('click', (e) => {
    //     if (!mapsMobileMenu.contains(e.target) && !mapsDropdownMobileMenu.contains(e.target)) {
    //         mapsDropdownMobileMenu.classList.add('hidden');
    //         mapsDropdownMobileMenu.style.transform = 'translateX(100%)';
    //     }
    // })

    // });


    //For the Account Menu on Mobile
    const accountMobileMenu = document.getElementById('accountMobileMenu');
    const accountDropdownMobileMenu = document.getElementById('accountDropdownMobileMenu');

    if (accountMobileMenu) {
        accountMobileMenu.addEventListener('click', () => {
            if (accountDropdownMobileMenu.classList.contains('hidden')) {
                accountDropdownMobileMenu.classList.remove('hidden');
                accountDropdownMobileMenu.style.transform = 'translateX(0)';
            } else {
                accountDropdownMobileMenu.classList.add('hidden');
                accountDropdownMobileMenu.style.transform = 'translateX(100%)';
            }

            document.addEventListener('click', (e) => {
                if (!accountMobileMenu.contains(e.target) && !accountDropdownMobileMenu.contains(e.target)) {
                    accountDropdownMobileMenu.classList.add('hidden');
                    accountDropdownMobileMenu.style.transform = 'translateX(100%)';
                }
            })

        });
    }

    //This is for the logout
    // const logoutBtn = document.getElementById('logout');
    // const logoutMobileBtn = document.getElementById('logoutMobileMenu');
    // if(logoutBtn || logoutMobileBtn){
    //     const allLogoutBtns = [logoutBtn, logoutMobileBtn];

    //     allLogoutBtns.forEach((btn) => {
    //         btn.addEventListener('click', () => {
    //             window.location.href = './';     
    //         });
    //     });
    // }




    // const windowPathName = window.location.pathname;

    // const btns = document.querySelectorAll(".nav-item");

    // btns.forEach((btn) => {
    //     const navLinkPathName = new URL(btn.href).pathname;

    //     if (navLinkPathName === windowPathName || navLinkPathName == '/' && windowPathName == '/') {
    //         btn.classList.add("active:bg-gray-600", "active:border-gray-500");
    //     }
    // });

    // const links = document.querySelectorAll(".nav-item a");
    // const bodyId = document.querySelector("div").id;

    // for (let link of links) {
    //     if (link.dataset.active == bodyId) {
    //         link.classList.add("active:bg-gray-600", "active:border-gray-500");
    //     }
    // }
</script>