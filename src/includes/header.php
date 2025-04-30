<?php
session_set_cookie_params([
    'secure' => false,  // Set to true if you're using HTTPS
    'httponly' => true,
    'samesite' => '',  // Ensure SameSite isn't causing issues in older browsers
]);
// $base = basename()
// echo dirname(__FILE__);
// exit;
session_start();
$current_url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$server_name = $_SERVER['SERVER_NAME'];
$parsed_url = parse_url($current_url);
$base_url = $parsed_url['scheme'] . '://' . $parsed_url['host'] . $server_name == 'localhost' || $server_name == '127.0.0.1' ? '/' : '/pamana25/'; //change to /_/pamana/ if local base url
// echo $base_url;
// exit;
$localSignificant = [
    'title' => 'Local Cultural Properties',
    'description' => 'Cultural properties significant to local culture and history and are declared by a local government unit (LGU) through a local executive order, ordinance, or resolution, or documented and compiled in its own cultural inventory.',
    'image' => 'assets/images/lcp-image/3-1.jpg'
];

$nationalSignificant = [
    'title' => 'National Cultural Properties',
    'description' => 'Declared cultural properties by the NCCA and/or National Cultural Agencies, and properties that possess the characteristics of an Important Cultural Property.',
    'image' => 'assets/images/ncp-image/3.jpg'
];
$isLogin = isset($_SESSION['userid']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAMANA | Preserving our Heritage</title>
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <link rel="stylesheet" href="<?= $base_url ?>library/tailwindcss/output.css">
    <link rel="stylesheet" href="<?= $base_url ?>library/tailwindcss/output-fallback.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="<?= $base_url ?>library/sweetalert/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="<?= $base_url ?>library/sweetalert/sweetalert2.min.css">
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/6.26.0/babel.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-polyfills/0.1.43/polyfill.min.js?features=es6"></script>
</head>

<body class="font-sans bg-gray-100">
    <?php include('navbar.php') ?>