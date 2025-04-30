<?php include('../includes/header.php'); ?>

    <div class="h-2/4 overflow-y-auto">
        <div class="w-full min-h-[calc(100vh-110px)] relative">

            <div class="absolute w-full top-1/4 left-1/2 transform -translate-x-1/2 -translate-y-1/3 rounded">

                <div class="relative w-10/12 sm:w-4/5 md:w-7/10 lg:w-4/12 bg-white bg-opacity-75 text-blue-800 p-3 text-center mx-auto rounded shadow-lg shadow-black">
                    <form id="forgotPasswordForm" autocomplete="off" class="my-3">
                        <h2 class="text-[2rem] font-bold mb-5 text-primary-600">Reset Password</h2>
                        <div class="text-left mb-1 pt-0">
                            <small id="helpId" class="text-primary-600 text-xl">Please enter your email address:</small>
                            <input type="email" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-primary-700 mt-2" id="email" name="email"
                                placeholder="Email" autofocus>
                        </div>

                        <div class="flex justify-between space-x-4 mt-5">
                            <a href="login" class="w-1/4 bg-primary-600  hover:bg-primary-500 text-white p-2 rounded transition duration-200 text-center shadow-lg shadow-black-500/50">Cancel</a>
                            <button id="forgot_submit" type="submit" class="w-1/4 bg-primary-600  hover:bg-primary-500 text-white p-2 rounded transition duration-200 shadow-lg shadow-black-500/50"
                                name="forgot_submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="src/js/forgotpassword.js"></script>

    </div>
    <?php include '../includes/footer.php'; ?>

