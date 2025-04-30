<?php
session_start();
$current_url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$parsed_url = parse_url($current_url);
$base_url = $parsed_url['scheme'] . '://' . $parsed_url['host'] . '/'; //change to /_/pamana/ if local base url
$localSignificant = [
    'title' => 'Local Cultural Properties',
    'description' => 'Cultural properties significant to local culture and history and are declared by a local government unit (LGU) through a local executive order, ordinance, or resolution, or documented and compiled in its own cultural inventory.',
    'image' => 'assets/images/hero-image/Parish_Church_of_Santo_Nino_Santa_Fe.jpg'
];

$nationalSignificant = [
    'title' => 'National Cultural Properties',
    'description' => 'Declared cultural properties by the NCCA and/or National Cultural Agencies, and properties that possesses the characteristic of an Important Cultural Property.',
    'image' => 'assets/images/hero-image/IMG_2126.jpg'
];
$isLogin = isset($_SESSION['userid'])
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAMANA | Preserving our cultural legacy for future generations.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="<?=$base_url?>library/sweetalert/sweetalert2.all.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            800: "#1f2937", //backgorund or white
                            700: "#0f4c81", //active
                            600: "#164c70", //text
                            500: "#336699", //hover
                        },
                        secondary: {
                            800: "#B2FFFC",
                            700: "#C7B8EA",
                            600: "#6A5ACD",
                            700: "#E5E5EA",
                        },
                        accent: {

                        },
                        muted: {

                        },
                        danger: {
                            800: "#991B1B",
                            700: "#B91C1C",
                            600: "#DC2626",
                            500: "#EF4444",
                        }
                    },
                }
            },
        };
    </script>
</head>

<body class="font-sans bg-gray-100">
    <?php include('navbar.php') ?>