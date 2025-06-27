<?php
include('../includes/header.php');

?>

<div class="w-full min-h-[calc(100vh-110px)] relative " style="background-image: url('assets/img/background-images/login-bg1.jpg');background-size: cover;background-position: center;background-repeat: no-repeat;">
    <div class="absolute py-4 top-0 left-0 right-0 bottom-0  flex items-center justify-center">
        <div class="w-10/12 sm:w-4/5 md:w-7/10 lg:w-12/12 bg-white/50  text-primary-600 p-6 rounded max-w-md shadow-lg">
            <form id="loginForm" autocomplete="off" class="my-3">
                <h2 class="text-[2rem] font-bold mb-5 text-primary-600 text-center">Welcome back!</h2>

                <!-- This div is for the username -->
                <div class="text-left mb-1 pt-1" >
                    <input type="text" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-700 text-primary-600" id="username" name="username" data-placeholder="Username">
                </div>

                <!-- This div is for the username -->
                <div class="text-left mb-4 pt-2 relative">
                    <input type="password" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-700 text-primary-600" id="password" name="password" data-placeholder="Password">

                    <!-- This is for the view password -->
                    <button type="button" id="showpassword" class="absolute right-3 top-7 -translate-y-1/2 text-gray-500 hover:text-gray-700 bg-transparent">
                        <svg class="w-6 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                            <path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z" />
                        </svg>
                    </button>
                </div>

                <!-- This is for the login button -->
                <button id="loginButton" type="submit" class="w-full bg-primary-600 cursor-pointer hover:bg-primary-500 text-white p-2 mb-4 rounded transform transition duration-300 hover:scale-105"
                    name="login_loginbtn">Login</button>

                <!-- This for the forgot password and create account -->
                <div>
                    <p class="text-primary-600 text-center">New user? <a href="signup" class="text-primary-600 hover:text-primary-600 underline">Create an
                            account.</a></p>
                    <p class="p-2 text-center"><button id="forgotPassButton" class="text-primary-600 hover:text-primary-600 underline bg-transparent">Forgot password?</button></p>
                </div>
            </form>
        </div>
    </div>
    <p class="absolute text-sm text-white bottom-0 right-2">Photo by Isabel Canete Medina, Constant Motion Studio © 2025</p>
</div>
<?php include '../includes/footer.php'; ?>
<script src="src/js/login.js"></script>
<script src="src/js/forgotpassword.js"></script>