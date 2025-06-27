<?php include '../includes/header.php' ?>


<div class="w-full min-h-[calc(100vh-110px)] relative" style="background-image: url('assets/img/background-images/register-bg.jpg');background-size: cover;background-position: center;background-repeat: no-repeat;">
    <div class="relative py-4 inset-0 flex items-center justify-center">
        <div class="w-10/12 sm:w-4/5 md:w-7/10 lg:w-12/12 bg-white/50 text-primary-600 p-6 rounded max-w-md shadow-lg">
            <form id="formRegister" autocomplete="off" class="">

                <h2 class="mb-4 text-2xl font-bold text-primary-600">Create an account</h2>

                <!-- FIRST NAME -->
                <input type="text" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-700 text-primary-600" id="firstname" name="firstname" data-placeholder="Firstname" autofocus>

                <!-- LAST NAME -->
                <input type="text" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-700 text-primary-600" id="lastname" name="lastname" data-placeholder="Lastname">

                <!-- EMAIL ADDRESS -->
                <input type="email" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-700 text-primary-600" id="email" name="email" data-placeholder="Email">

                <!-- USERNAME -->
                <input type="text" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-700 text-primary-600" id="username" name="username" data-placeholder="Username">

                <!-- PASSWORD -->
                <div class="pt-2 relative">
                    <input type="password" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-700 text-primary-600" id="password" name="password" data-placeholder="Password">
                    <button type="button" id="showpassword" class="absolute right-3 top-7 -translate-y-1/2 text-gray-500 hover:text-gray-700 bg-transparent">
                        <svg class="w-6 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                            <path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z" />
                        </svg>
                    </button>
                </div>

                <!-- CONFIRM PASSWORD -->
                <div class="mb-4 pt-2 relative">
                    <input type="password" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-700 text-primary-600" id="confirmpassword" name="cpassword" data-placeholder="Confirm Password">
                    <button type="button" id="cshowpassword" class="absolute right-3 top-7 -translate-y-1/2 text-gray-500 hover:text-gray-700 bg-transparent">
                        <svg class="w-6 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                            <path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z" />
                        </svg>
                    </button>
                </div>

                <div class="my-4 flex space-x-3">
                    <input type="checkbox" id="chkbox_recieve_updates" name="chkbox_recieve_updates" class="mt-1 min-w-4 min-h-4" />
                    <label for="chkbox_recieve_updates" class="flex items-start space-x-3">
                        <span class="text-sm text-gray-500">
                            I want to receive email updates, including news, offers, and other information from your website. By checking this box, I allow updates to be sent to my email address.
                        </span>
                    </label>
                </div>

                <!-- SIGN UP BUTTON -->
                <button type="submit" id="btnSubmit" class="w-full bg-primary-600 text-white p-3 rounded-md hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-700">
                    Sign up
                </button>



                <div class="flex flex-wrap justify-center mt-4">
                    <p class="text-sm text-primary-600 mr-4">
                        <a href="login" class="text-primary-600 hover:underline">Already have an account? Log in.</a>
                    </p>
                    <p class="text-sm text-primary-600">
                        <button id="forgotPassButton" class="text-primary-600 hover:text-blue-800 underline bg-transparent">Forgot password?</button>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <p class="absolute bottom-0 right-2 text-sm text-white">Photo by Ben Medina, Constant Motion Studio © 2025</p>
</div>

<!-- Footer -->
<script src="src/js/register.js"></script>
<script src="src/js/forgotpassword.js"></script>
<?php include '../includes/footer.php'; ?>

<script>
    // const showPassword = document.getElementById('showpassword');
    // const showConfirmPassword = document.getElementById('cshowpassword');
    // const password = document.getElementById('password');
    // const confirmPassword = document.getElementById('confirmpassword');
    // const eyeIcon = showPassword.querySelector('svg');
    // const ceyeIcon = showConfirmPassword.querySelector('svg');



    // showPassword.addEventListener('click', () => {
    //     if (password.type === 'password') {
    //         password.type = 'text';
    //         eyeIcon.innerHTML = '<path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/>';
    //     } else {
    //         password.type = 'password';
    //         eyeIcon.innerHTML = '<path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"/>';
    //     }
    // });


    // showConfirmPassword.addEventListener('click', () => {
    //     if (confirmPassword.type === 'password') {
    //         confirmPassword.type = 'text';
    //         ceyeIcon.innerHTML = '<path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/>';
    //     } else {
    //         confirmPassword.type = 'password';
    //         ceyeIcon.innerHTML = '<path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"/>';
    //     }
    // });
    // Select elements safely
</script>