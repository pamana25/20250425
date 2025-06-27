
<footer class="bg-primary-800 text-white px-4 sm:px-6 lg:px-20 py-8">
    <div class="container mx-auto">
        <div class="grid grid-cols-1-footer md:grid-cols-4">
            <div class="flex px-2 mb-4 justify-start items-start md:justify-center md:items-center">
                <img src="<?= $base_url ?>/assets/favicons/WebLogo02b.png" class="h-32" alt="" style="filter:brightness(0) invert(1)">
            </div>
            <div class="px-2 mb-4 justify-start items-start md:justify-center md:items-center">
                <h4 class="text-lg font-semibold mb-2">Follow Us</h4>
                <ul class="space-y-1">
                    <li><a href="" target="_blank" class="text-gray-400 hover:text-white" onclick="event.preventDefault()"><i class="fab fa-facebook-f"></i> Facebook</a></li>
                    <li><a href="" target="_blank" class="text-gray-400 hover:text-white" onclick="event.preventDefault()"><i class="fab fa-instagram"></i> Instagram</a></li>
                    <li><a href="" target="_blank" class="text-gray-400 hover:text-white" onclick="event.preventDefault()"><i class="fab fa-pinterest"></i> Pinterest</a></li>
                    <li><a href="" target="_blank" class="text-gray-400 hover:text-white" onclick="event.preventDefault()"><i class="fab fa-linkedin"></i> LinkedIn</a></li>
                </ul>
            </div>
            <div class="px-2 mb-4 justify-start items-start md:justify-center md:items-center">
                <h4 class="text-lg font-semibold mb-2">Quick Links</h4>
                <ul class="space-y-1">
                    <li><a href="./" class="text-gray-400 hover:text-white">Home</a></li>
                    <li><a href="./map" class="text-gray-400 hover:text-white">Maps</a></li>
                    <li><a href="./community" class="text-gray-400 hover:text-white">Community</a></li>
                    <li><a href="./#about-us" class="text-gray-400 hover:text-white">About Us</a></li>
                    <li><a href="" class="text-gray-400 hover:text-white" onclick="event.preventDefault()">Terms and Conditions</a></li>
                    <li><a href="" class="text-gray-400 hover:text-white" onclick="event.preventDefault()">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="px-2 mb-4 justify-start items-start md:justify-center md:items-center">
                <h4 class="text-lg font-semibold mb-2">Contact Us</h4>
                <p class="text-gray-400 mb-1 font-semibold">Pamana.org is a not-for-profit corporation registered in Illinois, USA</p>
                <div class="text-gray-400 my-4">
                    <p>Pamana.org</p>
                    <!-- <p>1035 Wesley Ave., #1N</p>
                    <p>Evanston, IL 60202</p> -->
                    <p>Email: community@pamana.org</p>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-4 pt-4 text-center">
            <p class="text-gray-400 text-sm">&copy; <?= date("Y"); ?> Constant Motion Studio. All rights reserved.</p>
        </div>
    </div>
</footer>


<!-- <script type="text/babel" data-presets="es2015" src="src/js/index.js"></script> -->
<script src="src/js/index.js"></script>
<script src="src/js/loadingIndicator.js"></script>
</body>

</html>
