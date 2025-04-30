<?php
include('../includes/header.php');
include('../../backend/model/userModel.php');
$user = new User();
if (!isset($_GET["verify"]) && empty($_GET["verify"])) {
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
?>
<?php if ($user->isTokenExists($_GET['verify'])): ?>
    <?php
    $user->verifyEmail($_GET['verify']);
    $user->verifyAccount($_GET['verify']);
    ?>
    <div class="relative bg-info bg-opacity-70 h-[calc(100vh-80px)]">
        <div class="card mx-auto text-center w-11/12 sm:w-3/4 md:w-1/3 bg-white relative top-1/2 transform -translate-y-1/2 rounded shadow-md ">
            <div class="card-body h-56 flex flex-col justify-center space-y-2 items-center">
                <h3 class="text-lg font-semibold text-gray-700">Thank you for confirming!</h3>
                <h1>
                    <i class="bi bi-envelope-exclamation " style="font-size: 80px;"></i>
                </h1>
                <h5 class="card-title text-gray-500">Email address verified</h5>
                <p class="card-text text-gray-500">Welcome to the community!</p>
                <a href="login"
                    class="btn bg-primary-500 hover:bg-primary-700 text-white py-2 px-4 rounded">
                    Login to Continue
                </a>
            </div>
        </div>
    </div>


<?php else: ?>

    <div class="relative bg-info bg-opacity-70 h-[calc(100vh-80px)]">
        <div class="card mx-auto text-center w-11/12 sm:w-3/4 md:w-1/3 bg-white relative top-1/2 transform -translate-y-1/2 shadow-lg rounded">
            <div class="card-body h-56 space-y-2 flex flex-col justify-center items-center">
                <h3 class="text-2xl font-semibold text-gray-700">
                    Error
                </h3>
                <i class="bi bi-envelope-exclamation text-blue-700" style="font-size: 80px;"></i>
                <span class="card-title text-lg text-gray-500">Something went wrong!</span>
                <p class="card-text text-gray-600">Invalid token.</p>
                <a
                    href="#"
                    class="btn bg-primary-500 mt-2 hover:bg-blue-600 text-white py-2 px-4 rounded">
                    Resend confirmation
                </a>
            </div>
        </div>
    </div>

<?php endif; ?>
<?php include '../includes/footer.php'; ?>