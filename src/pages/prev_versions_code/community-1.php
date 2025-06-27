<?php include '../includes/header.php' ?>
<div class="relative flex-grow mb-12 py-12">
    <!-- <img src="assets/img/background-images/bg-login.jpg" alt="Background Image" class="fixed inset-0 w-full h-full object-cover -z-10"> -->
    <div class="position-relative justify-content-center">
        <div class="text-primary-600 italic max-h-[350px] overflow-auto flex-shrink-0 mx-12 py-12">
            <p>
                As part of the community, there are ways to help your Local Government Units maintain an updated registry of
                your local heritage sites. You may nominate structures such as houses, chapels, churches, or schools that are
                not yet enlisted as a heritage site.
            </p>
            <p>
                You may also send photos, videos, and other types of media about existing heritage sites. Old photos help us
                keep track of the damages, repairs, and other changes that have been done to the structures as time goes by,
                especially those that have been destroyed by typhoons, earthquakes, and fire.
            </p>
        </div>


        <div class="relative flex-grow flex items-center justify-center p-6 ">
            <div class="w-10/12 sm:w-4/5 md:w-7/10 lg:w-12/12 text-[#164c70] p-6 rounded w-full max-w-md x">
                <div class="flex flex-col space-y-4 items-center">
                    <a href="upload-properties" class="py-3 px-8 text-base bg-[#164c70] rounded text-white">Add a Property</a>

                    <a href="upload-photos" class="py-3 px-8 text-base bg-[#164c70] rounded text-white">Upload a Photo</a>

                    <a href="view-uploaded" class="py-3 px-8 text-base bg-[#164c70] rounded text-white">View Uploaded</a>

                    <!-- <button class="w-64 bg-[#164c70] text-white p-3 rounded-md hover:bg-[#0d2c41] focus:outline-none focus:ring-2 focus:ring-[#164c70]" type="submit" name="community_uploadfilesbtn">
                        <h3 class="text-sm font-semibold">Upload a Photo</h3>
                    </button>
                    <button class="w-64 bg-[#164c70] text-white p-3 rounded-md hover:bg-[#0d2c41] focus:outline-none focus:ring-2 focus:ring-[#164c70]" type="submit" name="community_managefilesbtn">
                        <h3 class="text-sm font-semibold">View Uploaded Files</h3>
                    </button> -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>