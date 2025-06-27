<?php
include '../includes/header.php';
include '../../backend/model/userModel.php';
//  include '../../backend/api/user.php';

$userid = $_SESSION["userid"];

$User = new User();
$getUserEmail = $User->getUserInfoByUserid($userid);

$getUserFirstName = $User->getUserInfoByUserid($userid);
$getUserLastName = $User->getUserInfoByUserid($userid);

?>


<div class="w-full min-h-[calc(100vh-110px)] relative bg-blue-50">
    <div class="relative py-2 inset-0 flex items-center justify-center">
        <div class="w-10/12 sm:w-4/5 md:w-7/10 lg:w-12/12 bg-white bg-opacity-75 text-primary-600 p-6 rounded max-w-md x shadow-md">
            <form id="changeInfoForm" autocomplete="off" class="">

                <h2 class="mb-4 text-2xl font-bold text-primary-600">Account Settings</h2>

                <div class="mb-2 flex justify-center align-center">
                    <span class="text-primary-600  text-base">Hi <span class=""><?= $getUserFirstName['alias'] ? $getUserFirstName['alias'] : $getUserFirstName['firstname'] ?>!</span> </span>
                </div>

                <hr class="mb-2">
                <!-- Toggle Bar -->
                <!-- Toggle Bar -->
                <div class="flex items-center justify-between mb-6">
                    <label for="accountToggle" class="text-primary-600 italic text-sm">Receive email updates
                    </label>
                    <label for="accountToggle" class="relative inline-block cursor-pointer">
                        <input
                            type="checkbox"
                            id="accountToggle"
                            class="hidden z-50 peer" />
                        <div
                            class="w-12 h-6 bg-gray-300 rounded-full peer-checked:bg-primary-600 transition duration-300 ease-in-out"></div>
                        <div
                            class="absolute top-1/2 left-1 w-5 h-5 bg-white rounded-full shadow transform -translate-y-1/2 peer-checked:translate-x-6 transition duration-300 ease-in-out"></div>
                    </label>
                </div>


                <div class="relative group mb-4">
                    <!-- Input Field -->
                     <input type="text" id="userid" class="hidden" value="<?= $userid ?>">
                    <input
                        type="text"
                        class="w-full p-2 mb-1 border border-gray-300 rounded-md text-primary-600 italic focus:outline-none"
                        id="firstname"
                        name="firstname"
                        value="<?= $getUserFirstName['firstname'] ?>"
                        readonly />

                    <!-- Button -->
                    <button
                        type="button"
                        class="transition-all absolute right-2 bg-transparent top-1/3 -translate-y-1/4 text-gray-500 hover:text-gray-700">
                        <!-- Icon -->
                        <svg
                            class="flex-shrink-0 w-4 h-4"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                    </button>

                    <!-- Popover -->
                    <div
                        class="absolute hidden group-hover:block transition-all duration-300 ease-in-out top-1/2 left-full ml-2 -translate-y-1/2 z-10 w-max p-4 bg-white border border-gray-300 rounded-lg shadow-lg text-sm text-primary-600">
                        First Name cannot be changed.
                    </div>
                </div>



                <div class="relative group mb-4">
                    <!-- Input Field -->
                    <input
                        type="text"
                        class="w-full p-2 mb-1 border border-gray-300 rounded-md text-primary-600 italic focus:outline-none"
                        id="lastname"
                        name="lastname"
                        value="<?= $getUserLastName['lastname'] ?>"
                        readonly />

                    <!-- Button -->
                    <button
                        type="button"
                        class="transition-all absolute right-2 bg-transparent top-1/3 -translate-y-1/4 text-gray-500 hover:text-gray-700">
                        <!-- Icon -->
                        <svg
                            class="flex-shrink-0 w-4 h-4"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                    </button>

                    <!-- Popover -->
                    <div
                        class="absolute hidden group-hover:block transition-all duration-300 ease-in-out top-1/2 left-full ml-2 -translate-y-1/2 z-10 w-max p-4 bg-white border border-gray-300 rounded-lg shadow-lg text-sm text-primary-600">
                        Last Name cannot be changed.
                    </div>
                </div>




                <!-- EMAIL ADDRESS -->

                <div class="relative group mb-4">
                    <!-- Input Field -->
                    <input
                        type="email"
                        class="w-full p-2 mb-1 border border-gray-300 rounded-md text-primary-600 italic focus:outline-none"
                        id="email"
                        name="email"
                        value="<?= $getUserEmail['email'] ?>"
                        readonly />

                    <!-- Button -->
                    <button
                        type="button"
                        class="transition-all absolute right-2 bg-transparent top-1/3 -translate-y-1/4 text-gray-500 hover:text-gray-700">
                        <!-- Icon -->
                        <svg
                            class="flex-shrink-0 w-4 h-4"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                    </button>

                    <!-- Popover -->
                    <div
                        class="absolute hidden group-hover:block transition-all duration-300 ease-in-out top-1/2 left-full ml-2 -translate-y-1/2 z-10 w-max p-4 bg-white border border-gray-300 rounded-lg shadow-lg text-sm text-primary-600">
                        Email cannot be changed.
                    </div>
                </div>

                <!-- NickName -->
                <div class="relative group mb-4">
                    <input type="text" class="w-full p-2 mb-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-700 text-primary-600" id="alias" name="alias" placeholder="Nickname" data-placeholder="Nickname">
                </div>
                <!-- Confirm Password -->

                <div class="relative mb-4">
                    <input type="password" id="password" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-700 text-primary-600" name="cpassword" placeholder="Confirm with Password" data-placeholder="Confirm with Password" required>
                    <button type="button" id="showpassword" class="absolute bg-transparent right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5 fill-current " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                            <path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z" />
                        </svg>
                    </button>
                </div>

                <!-- This is for the change password -->
                <button id="changePassButton" type="button" class="mt-3 w-full bg-primary-600 text-white p-3 rounded-md hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-700  transform transition duration-300 hover:scale-105">
                    <span>Change Password?</span>
                </button>


                <!-- This is for the back and save button -->
                <div class="flex justify-between">
                    <a href="./" type="button" class="flex items-center outline-none px-4 py-2  rounded-md text-sm font-medium transition ease-in-out mt-6 bg-primary-600 text-white p-3  hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-700  transform  duration-300 hover:scale-105">
                        <i class="fas fa-chevron-left"></i>&nbsp; Back
                    </a>

                    <button type="submit" class="mt-6 w-20 bg-primary-600 text-white p-3 rounded-md hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-700  transform transition duration-300 hover:scale-105">
                        Save
                    </button>
                </div>


        </div>
        </form>
    </div>

</div>

<!-- Footer -->
<script src="src/js/settings.js"></script>
<script src="src/js/changepassword.js"></script>
<?php include '../includes/footer.php'; ?>
