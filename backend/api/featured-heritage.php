<?php
session_start();
include('../model/featuredHeritageModel.php');

$FeaturedHeritage = new FeaturedHeritage();

$method = $_SERVER['REQUEST_METHOD'];

switch($method){
    case 'GET':
        $getFeaturedHeritage = $FeaturedHeritage->getProperty();
        echo json_encode($getFeaturedHeritage);
        break;
}