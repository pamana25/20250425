<!DOCTYPE html>
<html lang="en">
<?php include '../../includes/header.php'; ?>

<head>
    <title>Sto. Nino Church</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
</head>
<script src="../library/cannon/build/cannon.min.js"></script>
<script type="importmap">
    {
            "imports": {
                "three": "../library/three/build/three.module.js",
                "ammo": "../library/ammojs3/builds/ammo.js"
            }
        }
    </script>
<style>
    #loader {
        border: 5px solid #f3f3f3;
        border-top: 5px solid #3d3d3d;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        animation: spin 1s linear infinite;
        margin: 0 auto;
        z-index: 2;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    #canvas {
        width: 100% !important;
        height: auto;
    }
</style>

<div class="relative h-screen" id="canvas-wrapper">
    <div id="blocker" class="absolute w-full h-full bg-gray-800 z-[11]">
        <div id="instructions" class="text-white w-full h-full flex flex-col justify-center align-items-center text-center text-xs cursor-pointer">
            <div class="bg-dark p-5 space-y-5">
                <p style="font-size:36px" class="">
                    Click to play
                </p>
                <p>
                    Move: WASD<br />
                    Jump: SPACE<br />
                    Look: MOUSE<br />
                    HOLD SHIFT: WALK
                </p>
            </div>
        </div>
        <video id="vid" class="absolute inset-0 my-auto bg-gray-800 w-full h-5/6 object-cover z-[11]" muted loop autoplay>
            <source id="mp4" src="../public/videos/BAA_CATHEDRAL_REEL.mp4" type="video/mp4">
        </video>
        <div id="loading" class="bg-dark content-center items-center flex flex-col absolute top-0 my-auto w-full h-full">
            <div id="wrapper" class="absolute bottom-0 mt-5 z-[12]">
                <div id="loader"></div>
                <p id="loading-msg" class="text-white m-1">Loading...</p>
            </div>
        </div>
    </div>
    <script src="../src/js/model/1139.js" type="module" defer></script>
</div>
</body>

</html>
<script>
    const video = document.getElementById('vid');
    const loadingMsg = document.getElementById('loading-msg').innerHTML;
    video.addEventListener('click', () => {
        video.play();
    });
    if (loadingMsg !== 'Loading...') {
        video.play();
    }
</script>