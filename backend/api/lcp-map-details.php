<?php
header('Content-Type: application/json');
require_once '../model/lcpModel.php';

// Create an instance of the Lcp controller
$lcp = new Lcp();

// Get the map details
$mapDetails = $lcp->getLcpMapDetails();

// Initialize the response array
$response = [
    "type" => "FeatureCollection",
    "name" => "LatLonNCP_10",
    "crs" => [
        "type" => "name",
        "properties" => [
            "name" => "urn:ogc:def:crs:OGC:1.3:CRS84"
        ]
    ],
    "features" => [],
];

// Check if map details were retrieved
if ($mapDetails) {
    foreach ($mapDetails as $row) {
        // Create a feature for each property
        $feature = [
            "type" => "Feature",
            "properties" => [
                "ID" => $row['lssid'],
                "Property Name" => $row['lssname'],
                "Latitude" => $row['latitude'],
                "Longitude" => $row['longitude'],
                "classification" => $row['map_classification']
            ],
            "geometry" => [
                "type" => "Point",
                "coordinates" => [
                    (float)$row['longitude'],
                    (float)$row['latitude']
                ]
            ]
        ];
        $response['features'][] = $feature;
    }
}

// Output the JSON response
echo json_encode($response);