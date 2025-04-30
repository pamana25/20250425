<?php include('../includes/header.php'); 
include('../../backend/model/userModel.php');

$user = new User();
if (!isset($_GET['token']) || empty($_GET['token'])) {
   echo '
       <div class="h-2/4 overflow-y-auto relative  bg-blue-50 flex justify-center align-center">
        <div class="w-full min-h-[calc(100vh-110px)] relative">
            <div class="absolute w-full top-1/3 left-1/2 transform -translate-x-1/2 -translate-y-1/4 rounded">
                <div class="relative w-10/12 sm:w-4/5 md:w-7/10 lg:w-4/12 bg-white bg-opacity-75 text-primary-600 p-3 text-center mx-auto rounded  rounded-md shadow-md">
                    <form id="resetPassForm" autocomplete="off" class="my-3 flex flex-col justify-center align-center">
                        <div class="relative left-1/2 transform -translate-x-1/2 -translate-y-1/4 text-gray-500 hover:text-gray-700 w-36 h-36 pt-8">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#164c70" viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-384c13.3 0 24 10.7 24 24l0 112c0 13.3-10.7 24-24 24s-24-10.7-24-24l0-112c0-13.3 10.7-24 24-24zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"/></svg>
                        </div>
                        <h2 class="text-[2rem] font-bold mb-5 text-primary-600">Sorry, Page Unavailable!</h2>
                    </form>
                </div>
            </div>
        </div>
    </div>
';
   exit;
}
$token = $_GET['token']; 
?>
   <?php 

   if($user->isTokenExists($token)){
    echo'
     <div class="h-2/4 overflow-y-auto relative  bg-blue-50">
        <div class="w-full min-h-[calc(100vh-110px)] relative">

            <div class="absolute w-full top-1/4 left-1/2 transform -translate-x-1/2 -translate-y-1/3 rounded">

                <div class="relative w-10/12 sm:w-4/5 md:w-7/10 lg:w-4/12 bg-white bg-opacity-75 text-primary-600 p-3 text-center mx-auto rounded  rounded-md shadow-md">

                    <form id="resetPassForm" autocomplete="off" class="my-3">
                        <h2 class="text-[2rem] font-bold mb-5 text-primary-600">New Password</h2>
                        <!-- <div class="text-left mb-4 pt-2 relative">
                            <div class="col-sm-12">
                                <input type="text" class="form-control p-2 pamana-main-input" id="userid" name="userid" placeholder="ID" value="" required hidden>
                            </div>
                        </div> -->

                        <div class="text-left mb-4 pt-2 relative">
                            <input type="password" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-primary-700 text-primary-600" id="password" name="password"
                                data-placeholder="Enter New Password">
                            <button type="button" id="showpassword" class="absolute right-3 top-7 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                <svg class="w-6 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                    <path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z" />
                                </svg>
                            </button>
                            <div id="password-validation-message" class="text-sm mt-1"></div>
                        </div>
                        <div class="text-left mb-4 relative">
                            <input type="password" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-primary-700 text-primary-600" id="confirmPassword" name="confirmPassword"
                                data-placeholder="Confirm New Password">
                            <button type="button" id="showConfirmPassword" class="absolute right-3 top-5 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                <svg class="confirmPass w-6 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                    <path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z" />
                                </svg>
                            </button>
                            <div id="confirm-password-validation-message" class="text-sm mt-1"></div>
                        </div>
                        <button type="submit" class="w-full bg-primary-600  hover:bg-primary-500 text-white p-2 mb-4 rounded transition duration-200"
                            name="resetpassword_resetbtn">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    ';
   }else{
    echo'
     <div class="h-2/4 overflow-y-auto relative  bg-blue-50 flex justify-center align-center">
        <div class="w-full min-h-[calc(100vh-110px)] relative">

            <div class="absolute w-full top-1/3 left-1/2 transform -translate-x-1/2 -translate-y-1/4 rounded">

                <div class="relative w-10/12 sm:w-4/5 md:w-7/10 lg:w-4/12 bg-white bg-opacity-75 text-primary-600 p-3 text-center mx-auto rounded  rounded-md shadow-md">

                    <form id="resetPassForm" autocomplete="off" class="my-3 flex flex-col justify-center align-center">
                        <h2 class="text-[2rem] font-bold mb-5 text-primary-600">Something went wrong!</h2>

                        <div>
                            <div class="relative left-1/2 transform -translate-x-1/2 -translate-y-1/4 text-gray-500 hover:text-gray-700 w-40 h-36 pt-2">
                                <svg fill="#164c70" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M21,13.5a1,1,0,0,0-1,1v4a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V8.91l5.88,5.88a3,3,0,0,0,4.24,0l3.59-3.58a1,1,0,0,0-1.42-1.42l-3.58,3.59a1,1,0,0,1-1.42,0L5.41,7.5H17a1,1,0,0,0,0-2H5a3,3,0,0,0-3,3v10a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3v-4A1,1,0,0,0,21,13.5Zm0-11a1,1,0,0,0-1,1v4a1,1,0,0,0,2,0v-4A1,1,0,0,0,21,2.5Zm-.2,7a.64.64,0,0,0-.18.06.76.76,0,0,0-.18.09l-.15.12a1.05,1.05,0,0,0-.29.71,1.23,1.23,0,0,0,0,.19.6.6,0,0,0,.06.19.76.76,0,0,0,.09.18,1.58,1.58,0,0,0,.12.15,1,1,0,0,0,1.42,0l.12-.15a.76.76,0,0,0,.09-.18.6.6,0,0,0,.06-.19,1.23,1.23,0,0,0,0-.19,1,1,0,0,0-1.2-1Z"></path></g></svg>
                            </div>
                            <p class="text-primary-600">The link has expired.</p>
                            <p class="text-primary-600 pt-1">Please click <button class="text-primary-600 hover:text-primary-600 underline" id="forgotPassButton">here</button> to try again.</p>
                            <div class="relative left-1/2 transform -translate-x-1/2 text-gray-500 hover:text-gray-700 pt-5">
                                <a href="./" class="w-full bg-primary-600  hover:bg-primary-500 text-white p-2 mb-4 rounded transition duration-200">Back to Home</a>
                            </div>
                            
                        </div>
          
                    </form>
                </div>
            </div>
        </div>
    </div>

    ';
   }
   ?>
  

    <?php 
   ?>

<?php include '../includes/footer.php'; ?>
<script src="src/js/resetpassword.js"></script>
<script src="src/js/forgotpassword.js"></script>

