<?php include '../includes/header.php' ?>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<body>
    <main class="relative">
        <div id="map" class="w-full h-[calc(100vh-64.8px)]"></div>
        <div id="load" class="absolute top-0 inset-0 bg-white h-full w-full z-[9999] flex flex-col justify-center items-center">
            <div id="loader" class="w-10 h-10 border-2 border-t-transparent border-blue-500 border-solid rounded-full animate-spin spinner"></div>
            <label>Loading...</label>
        </div>
       

        <div class="bg-white border rounded-lg shadow-sm">
            <div class="text-center">
                <button class="flex items-center justify-center w-auto whitespace-nowrap text-sm 2 mb-5 absolute top-2 left-4 z-10 bg-primary-600 text-white px-3 py-2 rounded-md shadow-md hover:bg-primary-white transition-colors duration-200 text-sm z-[9999] transform transition hover:scale-105" type="button" data-drawer-target="drawer" data-drawer-show="drawer" aria-controls="drawer">
                <svg class="w-4 h-4 mr-2 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M352 256c0 22.2-1.2 43.6-3.3 64l-185.3 0c-2.2-20.4-3.3-41.8-3.3-64s1.2-43.6 3.3-64l185.3 0c2.2 20.4 3.3 41.8 3.3 64zm28.8-64l123.1 0c5.3 20.5 8.1 41.9 8.1 64s-2.8 43.5-8.1 64l-123.1 0c2.1-20.6 3.2-42 3.2-64s-1.1-43.4-3.2-64zm112.6-32l-116.7 0c-10-63.9-29.8-117.4-55.3-151.6c78.3 20.7 142 77.5 171.9 151.6zm-149.1 0l-176.6 0c6.1-36.4 15.5-68.6 27-94.7c10.5-23.6 22.2-40.7 33.5-51.5C239.4 3.2 248.7 0 256 0s16.6 3.2 27.8 13.8c11.3 10.8 23 27.9 33.5 51.5c11.6 26 20.9 58.2 27 94.7zm-209 0L18.6 160C48.6 85.9 112.2 29.1 190.6 8.4C165.1 42.6 145.3 96.1 135.3 160zM8.1 192l123.1 0c-2.1 20.6-3.2 42-3.2 64s1.1 43.4 3.2 64L8.1 320C2.8 299.5 0 278.1 0 256s2.8-43.5 8.1-64zM194.7 446.6c-11.6-26-20.9-58.2-27-94.6l176.6 0c-6.1 36.4-15.5 68.6-27 94.6c-10.5 23.6-22.2 40.7-33.5 51.5C272.6 508.8 263.3 512 256 512s-16.6-3.2-27.8-13.8c-11.3-10.8-23-27.9-33.5-51.5zM135.3 352c10 63.9 29.8 117.4 55.3 151.6C112.2 482.9 48.6 426.1 18.6 352l116.7 0zm358.1 0c-30 74.1-93.6 130.9-171.9 151.6c25.5-34.2 45.2-87.7 55.3-151.6l116.7 0z"/></svg>
                Legends 
                </button>
            </div>

            <div id="drawer" class="fixed top-16 left-0 z-40 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white w-96 z-[9999]" tabindex="-1" aria-labelledby="drawer-label">
                <h5 id="drawer-label" class="inline-flex items-center text-base font-semibold text-gray-500 dark:text-gray-400 ">
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M352 256c0 22.2-1.2 43.6-3.3 64l-185.3 0c-2.2-20.4-3.3-41.8-3.3-64s1.2-43.6 3.3-64l185.3 0c2.2 20.4 3.3 41.8 3.3 64zm28.8-64l123.1 0c5.3 20.5 8.1 41.9 8.1 64s-2.8 43.5-8.1 64l-123.1 0c2.1-20.6 3.2-42 3.2-64s-1.1-43.4-3.2-64zm112.6-32l-116.7 0c-10-63.9-29.8-117.4-55.3-151.6c78.3 20.7 142 77.5 171.9 151.6zm-149.1 0l-176.6 0c6.1-36.4 15.5-68.6 27-94.7c10.5-23.6 22.2-40.7 33.5-51.5C239.4 3.2 248.7 0 256 0s16.6 3.2 27.8 13.8c11.3 10.8 23 27.9 33.5 51.5c11.6 26 20.9 58.2 27 94.7zm-209 0L18.6 160C48.6 85.9 112.2 29.1 190.6 8.4C165.1 42.6 145.3 96.1 135.3 160zM8.1 192l123.1 0c-2.1 20.6-3.2 42-3.2 64s1.1 43.4 3.2 64L8.1 320C2.8 299.5 0 278.1 0 256s2.8-43.5 8.1-64zM194.7 446.6c-11.6-26-20.9-58.2-27-94.6l176.6 0c-6.1 36.4-15.5 68.6-27 94.6c-10.5 23.6-22.2 40.7-33.5 51.5C272.6 508.8 263.3 512 256 512s-16.6-3.2-27.8-13.8c-11.3-10.8-23-27.9-33.5-51.5zM135.3 352c10 63.9 29.8 117.4 55.3 151.6C112.2 482.9 48.6 426.1 18.6 352l116.7 0zm358.1 0c-30 74.1-93.6 130.9-171.9 151.6c25.5-34.2 45.2-87.7 55.3-151.6l116.7 0z"/></svg>
                Legends </h5>
                <button type="button" data-drawer-hide="drawer" aria-controls="drawer" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2 end-2.5 flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white" >
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close menu</span>
                </button>
                
                <p class="mb-6 text-sm text-gray-500 dark:text-gray-400"></p>
                <div class="grid grid-cols-2 gap-4">


                <div id="sidebar" class="absolute z-[9999] flex">
                    <div class="flex flex-col justify-between">
                        <div class="space-y-2 relative h-full w-full bg-white pb-auto mb-2">
                            <div class="flex items-center">
                                <input type="checkbox" id="nationalCulturalCheckbox" onclick="toggleNationalProperties()" class="mr-2">
                                <label for="nationalCulturalCheckbox" class="flex items-center text-sm p-2 rounded transition-colors transform translate duration-400 hover:scale-105 cursor-pointer select-none"><svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M64 32C64 14.3 49.7 0 32 0S0 14.3 0 32L0 64 0 368 0 480c0 17.7 14.3 32 32 32s32-14.3 32-32l0-128 64.3-16.1c41.1-10.3 84.6-5.5 122.5 13.4c44.2 22.1 95.5 24.8 141.7 7.4l34.7-13c12.5-4.7 20.8-16.6 20.8-30l0-247.7c0-23-24.2-38-44.8-27.7l-9.6 4.8c-46.3 23.2-100.8 23.2-147.1 0c-35.1-17.6-75.4-22-113.5-12.5L64 48l0-16z"/></svg>
                                    &nbsp;&nbsp; <span class="hover:overline">National Cultural Properties</span></label>
                            </div>
                            
                            <ul id="nationalCulturalList" class="hidden space-y-2 p-2 w-auto">
                                <li class="w-full flex items-center relative group">
                                    <input type="checkbox" class="mr-2">
                                    <label onclick="showDialog('dialog1')" class="flex items-center text-sm p-2 rounded transition-colors transform translate duration-400 hover:scale-105 cursor-pointer select-none"><svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M116.7 33.8c4.5-6.1 11.7-9.8 19.3-9.8l240 0c7.6 0 14.8 3.6 19.3 9.8l112 152c6.8 9.2 6.1 21.9-1.5 30.4l-232 256c-4.5 5-11 7.9-17.8 7.9s-13.2-2.9-17.8-7.9l-232-256c-7.7-8.5-8.3-21.2-1.5-30.4l112-152zm38.5 39.8c-3.3 2.5-4.2 7-2.1 10.5l57.4 95.6L63.3 192c-4.1 .3-7.3 3.8-7.3 8s3.2 7.6 7.3 8l192 16c.4 0 .9 0 1.3 0l192-16c4.1-.3 7.3-3.8 7.3-8s-3.2-7.6-7.3-8L301.5 179.8l57.4-95.6c2.1-3.5 1.2-8.1-2.1-10.5s-7.9-2-10.7 1L256 172.2 165.9 74.6c-2.8-3-7.4-3.4-10.7-1z"/></svg>
                                    &nbsp;&nbsp;<span class="hover:overline">National Cultural Treasures</span></label>
                                    <svg class="dialog-hover transform translate duration-400 hover:scale-105  w-4 h-4 me-0 transition-all absolute end-0 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                    </svg>
                                    <div class="fixed hidden bg-gray-100 text-gray-800 shadow-lg group-hover:block -group-hover:bg-primary-500 left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded z-[10000] mt-3 p-8">
                                
                                        <div class="mb-4">
                                            <h3 class="text-xl font-semibold mb-4">National Cultural Treasures</h3>
                                        </div>
                                        <div class="mb-4">
                                            <p class="text-base text-center mb-4">Unique cultural property found locally which has outstanding historical, cultural, artistic, and/or scientific value. It is highly significant and important to the country and is officially declared by a cultural agency like the National Museum (NM).</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="flex items-center relative group">
                                    <input type="checkbox" class="mr-2">
                                    <label onclick="showDialog('dialog2')" class="dialog-hover flex items-center text-sm p-2 rounded transition-colors transform translate duration-400 hover:scale-105 cursor-pointer select-none"><img class="w-6 h-6" src="images/ImportantCulturalProperty.svg" alt="">
                                    &nbsp;&nbsp; <span class="hover:overline">Important Cultural Properties</span></label>
                                    <svg class="dialog-hover transform translate duration-400 hover:scale-105  w-4 h-4 me-0 transition-all absolute end-0 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                    </svg>
                                    <div class="fixed hidden bg-gray-100 text-gray-800 shadow-lg group-hover:block -group-hover:bg-primary-500 left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded z-[10000] mt-3 p-8">
                                        <div class="mb-4">
                                            <h3 class="text-xl font-semibold">Important Cultural Properties</h3>
                                        </div>
                                        <div class="mb-4">
                                            <p class="text-base text-center">Cultural property having exceptional cultural, artistic, and historical significance to the Philippines determined by the NM, the National Historical Commission of the Philippines (NHCP), the National Library of the Philippines (NLP), and/or the National Archives of the Philippines (NAP).</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="flex items-center relative group">
                                    <input type="checkbox" class="mr-2">
                                    <label onclick="showDialog('dialog3')" class="dialog-hover flex items-center text-sm p-2 rounded transition-colorstransform translate duration-400 hover:scale-105 cursor-pointer select-none"><img class="w-6 h-6" src="images/NationalHistoricalShrine.svg" alt="">
                                    &nbsp;&nbsp; <span class="hover:overline">National Historical Shrines</span></label>
                                    <svg class="dialog-hover transform translate duration-400 hover:scale-105  w-4 h-4 me-0 transition-all absolute end-0 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                    </svg>
                                    <div class="fixed hidden bg-gray-100 text-gray-800 shadow-lg group-hover:block -group-hover:bg-primary-500 left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded z-[10000] mt-3 p-8">
                                        <div class="w-full mb-4">
                                            <h3 class="text-xl font-semibold">National Historical Shrines</h3>
                                        </div>
                                        <div class="w-full mb-4">
                                            <p class="text-base text-center">Cultural property which are hallowed and revered for their history or association as declared by the NHCP and/or other previous iterations of that cultural agency.</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="flex items-center relative group">
                                    <input type="checkbox" class="mr-2">
                                    <label onclick="showDialog('dialog4')" class="dialog-hover flex items-center text-sm p-2 rounded transition-colors transform translate duration-400 hover:scale-105 cursor-pointer select-none"><img class="w-6 h-6" src="images/NationalHistoricalLandmark.svg" alt="">
                                    &nbsp;&nbsp;<span class="hover:overline">National Historical Landmark</span></label>
                                    <svg class="dialog-hover transform translate duration-400 hover:scale-105  w-4 h-4 me-0 transition-all absolute end-0 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                    </svg>
                                    <div class="fixed hidden bg-gray-100 text-gray-800 shadow-lg group-hover:block -group-hover:bg-primary-500 left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded z-[10000] mt-3 p-8">
                                        <div class="w-full mb-4">
                                            <h3 class="text-xl font-semibold">National Historical Landmarks</h3>
                                        </div>
                                        <div class="w-full mb-4">
                                            <p class="text-base text-center">Sites or structures that are associated with events or achievements significant to Philippine history as declared by the NHCP and/or other previous iterations of that cultural agency.</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="flex items-center relative group">
                                    <input type="checkbox" class="mr-2">
                                    <label onclick="showDialog('dialog5')" class="dialog-hover flex items-center text-sm p-2 rounded transition-colors transform translate duration-400 hover:scale-105 cursor-pointer select-none"><img class="w-5 h-5" src="images/NationalHistoricalMonument.svg" alt="">
                                    &nbsp;&nbsp;<span class="hover:overline">National Historical Monuments</span></label>
                                    <svg class="dialog-hover transform translate duration-400 hover:scale-105  w-4 h-4 me-0 transition-all absolute end-0 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                    </svg>
                                    <div class="fixed hidden bg-gray-100 text-gray-800 shadow-lg group-hover:block -group-hover:bg-primary-500 left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded z-[10000] mt-3 p-8">
                                        <div class="w-full mb-4">
                                            <h3 class="text-xl font-semibold">National Historical Monuments</h3>
                                        </div>
                                        <div class="w-full mb-4">
                                            <p class="text-base text-center">Structures that honor illustrious persons or commemorate events of historical value as declared by the NHCP and/or other previous iterations of that cultural agency.</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="flex items-center relative group">
                                    <input type="checkbox" class="mr-2">
                                    <label onclick="showDialog('dialog6')" class="dialog-hover flex items-center text-sm p-2 rounded transition-colors transform translate duration-400 hover:scale-105 cursor-pointer select-none"><svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M240.1 4.2c9.8-5.6 21.9-5.6 31.8 0l171.8 98.1L448 104l0 .9 47.9 27.4c12.6 7.2 18.8 22 15.1 36s-16.4 23.8-30.9 23.8L32 192c-14.5 0-27.2-9.8-30.9-23.8s2.5-28.8 15.1-36L64 104.9l0-.9 4.4-1.6L240.1 4.2zM64 224l64 0 0 192 40 0 0-192 64 0 0 192 48 0 0-192 64 0 0 192 40 0 0-192 64 0 0 196.3c.6 .3 1.2 .7 1.8 1.1l48 32c11.7 7.8 17 22.4 12.9 35.9S494.1 512 480 512L32 512c-14.1 0-26.5-9.2-30.6-22.7s1.1-28.1 12.9-35.9l48-32c.6-.4 1.2-.7 1.8-1.1L64 224z"/></svg>
                                    &nbsp;&nbsp;<span class="hover:overline">UNESCO World Heritage Sites</span></label>
                                    <svg class="dialog-hover transform translate duration-400 hover:scale-105  w-4 h-4 me-0 transition-all absolute end-0 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                    </svg>
                                    <div class="fixed hidden bg-gray-100 text-gray-800 shadow-lg group-hover:block -group-hover:bg-primary-500 left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded z-[10000] mt-3 p-8">
                                        <div class="w-full mb-4">
                                            <h3 class="text-xl font-semibold">UNESCO World Heritage Sites</h3>
                                        </div>
                                        <div class="w-full mb-4">
                                            <p class="text-base text-center">Places listed by the United Nations Educational, Scientific, and Cultural Organization (UNESCO) as having outstanding universal value.</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="flex items-center relative group">
                                    <input type="checkbox" class="mr-2">
                                    <label onclick="showDialog('dialog8')" class="dialog-hover flex items-center text-sm p-2 rounded transition-colors transform translate duration-400 hover:scale-105 cursor-pointer select-none"><img  class="w-6 h-6" src="images/PresumedImportantCulturalProperty.svg" alt="">
                                    &nbsp;&nbsp;<span class="hover:overline pr-5">Presumed Important Cultural Property</span></label>
                                    <svg class="dialog-hover transform translate duration-400 hover:scale-105  w-4 h-4 me-0 transition-all absolute end-0 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                    </svg>
                                    <div class="fixed hidden bg-gray-100 text-gray-800 shadow-lg group-hover:block -group-hover:bg-primary-500 left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded z-[10000] mt-3 p-8">
                                        <div class="w-full mb-4">
                                            <h3 class="text-xl font-semibold">Presumed Important Cultural Property</h3>
                                        </div>
                                        <div class="w-full mb-4">
                                            <p class="text-base text-center">Cultural property which are not declared as National Cultural Treasure, UNESCO World Heritage Site, National Historical Shrine, National Historical Landmark, National Historical Monument, or Important Cultural Property but still possesses the characteristic of an Important Cultural Property.</p>
                                        </div>
                                    </div>
                                </li>

                                <li class="flex items-center relative group">
                                        <input type="checkbox" class="mr-2">
                                        <label onclick="showDialog('dialog8')" class="dialog-hover flex items-center text-sm p-2 rounded transition-colors transform translate duration-400 hover:scale-105 cursor-pointer select-none"><img class="w-6 h-6" src="images/ClassifiedHistoricStructure.svg" alt="">
                                        &nbsp;&nbsp;<span class="hover:overline">Classified Historic Structure</span></label>
                                        <svg class="dialog-hover transform translate duration-400 hover:scale-105  w-4 h-4 me-0 transition-all absolute end-0 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                        </svg>
                                        <div class="fixed hidden bg-gray-100 text-gray-800 shadow-lg group-hover:block -group-hover:bg-primary-500 left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded z-[10000] mt-3 p-8">
                                            <div class="w-full mb-4">
                                                <h3 class="text-xl font-semibold">Classified Historic Structure</h3>
                                            </div>
                                            <div class="w-full mb-4">
                                                <p class="text-base text-center">No available description</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                        <div class="space-y-2 relative h-full w-full bg-white pb-auto mt-2">
                            <div class="flex items-center">
                                <input type="checkbox" id="localCulturalCheckbox" onclick="toggleLocalProperties()" class="mr-2">
                                <label for="localCulturalCheckbox" class="flex items-center text-sm p-2 rounded transition-colors transform translate duration-400 hover:scale-105 cursor-pointer select-none"><svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M336 0c-26.5 0-48 21.5-48 48l0 92.1 71.4 118.4c2.5-1.6 5.4-2.5 8.6-2.5l32 0c8.8 0 16 7.2 16 16l0 32c0 8.8-7.2 16-16 16l-3.5 0 73.8 122.4c12.4 20.6 12.9 46.3 1.2 67.3c-.4 .8-.9 1.6-1.4 2.3L592 512c26.5 0 48-21.5 48-48l0-224c0-26.5-21.5-48-48-48l-24 0 0-72c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 72-40 0 0-144c0-26.5-21.5-48-48-48L336 0zm32 64l32 0c8.8 0 16 7.2 16 16l0 32c0 8.8-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16l0-32c0-8.8 7.2-16 16-16zM352 176c0-8.8 7.2-16 16-16l32 0c8.8 0 16 7.2 16 16l0 32c0 8.8-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16l0-32zm160 96c0-8.8 7.2-16 16-16l32 0c8.8 0 16 7.2 16 16l0 32c0 8.8-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16l0-32zm16 80l32 0c8.8 0 16 7.2 16 16l0 32c0 8.8-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16l0-32c0-8.8 7.2-16 16-16zM224 188.9L283.8 288 223 288l-48 64-24.6-41.2L224 188.9zm29.4-44.2C247.1 134.3 236 128 224 128s-23.1 6.3-29.4 16.7L5.1 458.9c-6.5 10.8-6.7 24.3-.7 35.3S22 512 34.5 512l379.1 0c12.5 0 24-6.8 30.1-17.8s5.8-24.5-.7-35.3L253.4 144.7z"/></svg>
                                    &nbsp;&nbsp;<span class="hover:overline">Local Cultural Properties</span></label>
                            </div>
                           
                            <ul id="localCulturalList" class="hidden space-y-2 p-2">
                                <li class="flex items-center relative group">
                                    <input type="checkbox" class="mr-2">
                                    <label onclick="showDialog('dialog7')" class="dilaog-hover flex items-center text-sm p-2 rounded transition-colors transform translate duration-400 hover:scale-105 cursor-pointer select-none"><img class="w-6 h-6" src="images/LocalCulturalProperties.svg"/></img>
                                        &nbsp;&nbsp;<span class="hover:overline mr-20">Local Cultural Properties</span></label>
                                    <svg class="dialog-hover transform translate duration-400 hover:scale-105  w-4 h-4 me-0 transition-all absolute end-0 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                    </svg>
                                    <div class="fixed hidden bg-gray-100 text-gray-800 shadow-lg group-hover:block -group-hover:bg-primary-500 left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded z-[10000] mt-3 p-8">
                                        <h3 class="text-xl font-semibold mb-4">Local Cultural Properties</h3>
                                        <p class="text-base text-center mb-4">Cultural property declared by a local government unit (LGU) through a local executive order, ordinance, or resolution.</p>
                                    </div>    
                                </li>
                                <li class="flex items-center relative group">
                                    <input type="checkbox" class="mr-2">
                                    <label onclick="showDialog('dialog9')" class="dialog-hover flex items-center text-sm  p-2 rounded transition-colors transform translate duration-400 hover:scale-105 cursor-pointer select-none"><img class="w-6 h-6" src="images/RegisteredCulturalProperties.svg"/></img>
                                        &nbsp;&nbsp;<span class="hover:overline">Registered Properties</span></label>
                                    <svg class="dialog-hover transform translate duration-400 hover:scale-105  w-4 h-4 me-0 transition-all absolute end-0 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                    </svg>
                                    <div class="fixed hidden bg-gray-100 text-gray-800 shadow-lg group-hover:block -group-hover:bg-primary-500 left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded z-[10000] mt-3 p-8">
                                        <h3 class="text-xl font-semibold mb-4">Registered Properties</h3>
                                        <p class="text-base text-center mb-4">Cultural Property Significant to Local Culture and History, Documented and Compiled by a Local Government Unit in Its Own Cultural Inventory.</p>
                                    </div> 
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                </div>
        
                </div>
            </div> 

        </div>
    </main>
    <dialog id="dialog1" class="m-auto p-6 rounded-lg max-w-4xl w-full  items-center border-0">
        <div class="w-full flex flex-col items-center">
            <div class="w-full mb-4">
                <h3 class="text-xl font-semibold mb-4">National Cultural Treasures</h3>
            </div>
            <div class="w-full mb-4">
                <p class="text-base text-center mb-4">Unique cultural property found locally which has outstanding historical, cultural, artistic, and/or scientific value. It is highly significant and important to the country and is officially declared by a cultural agency like the National Museum (NM).</p>
            </div>
            <div class="w-full flex justify-end">
                <button onclick="closeDialog('dialog1')" class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-500 transition-colors">
                    Close
                </button>
            </div>
        </div>
    </dialog>

    <dialog id="dialog2" class="m-auto p-6 rounded-lg max-w-4xl w-full  items-center border-0">
        <div class="w-full flex flex-col items-center">
            <div class="w-full mb-4">
                <h3 class="text-xl font-semibold">Important Cultural Properties</h3>
            </div>
            <div class="w-full mb-4">
                <p class="text-base text-center">Cultural property having exceptional cultural, artistic, and historical significance to the Philippines determined by the NM, the National Historical Commission of the Philippines (NHCP), the National Library of the Philippines (NLP), and/or the National Archives of the Philippines (NAP).</p>
            </div>
            <div class="w-full flex justify-end">
                <button onclick="closeDialog('dialog2')" class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-500 transition-colors">
                    Close
                </button>
            </div>
        </div>
    </dialog>

    <dialog id="dialog3" class="m-auto p-6 rounded-lg max-w-4xl w-full  items-center border-0">
        <div class="w-full flex flex-col items-center">
            <div class="w-full mb-4">
                <h3 class="text-xl font-semibold">National Historical Shrines</h3>
            </div>
            <div class="w-full mb-4">
                <p class="text-base text-center">Cultural property which are hallowed and revered for their history or association as declared by the NHCP and/or other previous iterations of that cultural agency.</p>
            </div>
            <div class="w-full flex justify-end">
                <button onclick="closeDialog('dialog3')" class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-500 transition-colors">
                    Close
                </button>
            </div>
        </div>
    </dialog>

    <dialog id="dialog4" class="m-auto p-6 rounded-lg max-w-4xl w-full  items-center border-0">
        <div class="w-full flex flex-col items-center">
            <div class="w-full mb-4">
                <h3 class="text-xl font-semibold">National Historical Landmarks</h3>
            </div>
            <div class="w-full mb-4">
                <p class="text-base text-center">Sites or structures that are associated with events or achievements significant to Philippine history as declared by the NHCP and/or other previous iterations of that cultural agency.</p>
            </div>
            <div class="w-full flex justify-end">
                <button onclick="closeDialog('dialog4')" class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-500 transition-colors">
                    Close
                </button>
            </div>
        </div>
    </dialog>

    <dialog id="dialog5" class="m-auto p-6 rounded-lg max-w-4xl w-full  items-center border-0">
        <div class="w-full flex flex-col items-center">
            <div class="w-full mb-4">
                <h3 class="text-xl font-semibold">National Historical Monuments</h3>
            </div>
            <div class="w-full mb-4">
                <p class="text-base text-center">Structures that honor illustrious persons or commemorate events of historical value as declared by the NHCP and/or other previous iterations of that cultural agency.</p>
            </div>
            <div class="w-full flex justify-end">
                <button onclick="closeDialog('dialog5')" class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-500 transition-colors">
                    Close
                </button>
            </div>
        </div>
    </dialog>

    <dialog id="dialog6" class="m-auto p-6 rounded-lg max-w-4xl w-full  items-center border-0">
        <div class="w-full flex flex-col">
            <div class="w-full mb-4">
                <h3 class="text-xl font-semibold">UNESCO World Heritage Sites</h3>
            </div>
            <div class="w-full mb-4">
                <p class="text-base text-center">Places listed by the United Nations Educational, Scientific, and Cultural Organization (UNESCO) as having outstanding universal value.</p>
            </div>
            <div class="w-full flex justify-end">
                <button onclick="closeDialog('dialog6')" class="bg-primary-600 text-white px-4 py-2 rounded-md hover:text-primary-500 transition-colors">
                    Close
                </button>
            </div>
        </div>
    </dialog>
    <dialog id="dialog8" class="m-auto p-6 rounded-lg max-w-4xl w-full  items-center border-0">
        <div class="w-full flex flex-col">
            <div class="w-full mb-4">
                <h3 class="text-xl font-semibold">Presumed Important Cultural Property</h3>
            </div>
            <div class="w-full mb-4">
                <p class="text-base text-center">Cultural property which are not declared as National Cultural Treasure, UNESCO World Heritage Site, National Historical Shrine, National Historical Landmark, National Historical Monument, or Important Cultural Property but still possesses the characteristic of an Important Cultural Property.</p>
            </div>
            <div class="w-full flex justify-end">
                <button onclick="closeDialog('dialog8')" class="bg-primary-600 text-white px-4 py-2 rounded-md hover:text-primary-500 transition-colors">
                    Close
                </button>
            </div>
        </div>
    </dialog>
    <dialog id="dialog7" class="m-auto p-4 rounded-lg max-w-lg w-full  items-center border-0">
        <h3 class="text-xl font-semibold mb-4">Local Cultural Properties</h3>
        <p class="text-base text-center mb-4">Cultural property declared by a local government unit (LGU) through a local executive order, ordinance, or resolution.</p>

        <div class="w-full flex justify-end">
            <button onclick="closeDialog('dialog7')" class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-500 transition-colors">
                Close
            </button>
        </div>
    </dialog>
    <dialog id="dialog9" class="m-auto p-4 rounded-lg max-w-lg w-full  items-center border-0">
        <h3 class="text-xl font-semibold mb-4">Registered Properties</h3>
        <p class="text-base text-center mb-4">Cultural Property Significant to Local Culture and History, Documented and Compiled by a Local Government Unit in Its Own Cultural Inventory.</p>

        <div class="w-full flex justify-end">
            <button onclick="closeDialog('dialog9')" class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-500 transition-colors">Close</button>
        </div>
    </dialog>


    <script>
        // const button1 = document.getElementById('popup1');
        // const dialog1 = document.getElementById('dialog1');


        // button1.addEventListener('click', () => {
        //     dialog1.showModal();
        // });


        
        // document.getElementById('propertyType').addEventListener('change', function() {
        //     var selectedValue = this.value;


           
        //     if (selectedValue === 'local') {
        //         document.getElementById('nationalProperties').classList.add('hidden');
        //         document.getElementById('localProperties').classList.remove('hidden');
        //     } else {
        //         document.getElementById('nationalProperties').classList.remove('hidden');
        //         document.getElementById('localProperties').classList.add('hidden');
        //     }
        // });


        function toggleNationalProperties() {
    const checkbox = document.getElementById('nationalCulturalCheckbox');
    const list = document.getElementById('nationalCulturalList');
    list.classList.toggle('hidden', !checkbox.checked);
}

function toggleLocalProperties() {
    const checkbox = document.getElementById('localCulturalCheckbox');
    const list = document.getElementById('localCulturalList');
    list.classList.toggle('hidden', !checkbox.checked);
}


        function showDialog(dialogId) {
            const dialog = document.getElementById(dialogId);
            dialog.showModal();
        }

        function closeDialog(dialogId) {
            const dialog = document.getElementById(dialogId);
            dialog.close();
        }



        document.addEventListener('DOMContentLoaded', function() {
      const drawerButton = document.querySelector('[data-drawer-target="drawer"]');
      const drawer = document.getElementById('drawer');
      const closeButton = document.querySelector('[data-drawer-hide="drawer"]');


      drawerButton.addEventListener('click', function() {
         drawer.classList.toggle('-translate-x-full');
      });


      closeButton.addEventListener('click', function() {
         drawer.classList.add('-translate-x-full');
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