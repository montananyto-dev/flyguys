<?php
require_once __DIR__ . "/../model/Region.php";
require_once __DIR__ . "/../model/Location.php";
header("Access-Control-Allow-Origin: *");

$desiredRegionName = $_GET['region'];

$desiredRegions = array();

if(isset($desiredRegionName)) {
    // Gets specific Region
    foreach(Region::getAll() as $temp) {
        if($temp->getName() == $desiredRegionName) {
            array_push($desiredRegions, $temp);
        }
    }
} else {
    $desiredRegions = Region::getAll();
}

if(count($desiredRegions)==0) {
    header('HTTP/1.1 500 Internal Server Error');
    die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
}

$flights = array();

foreach($desiredRegions as $region) {
    foreach($region->getLocations() as $location) {
        foreach($location->getConnections() as $flightConnections) {
            foreach($flightConnections->getFlights() as $flight) {
                array_push($flights, $flight);
            }
        }
    } 
}


echo json_encode($flights);


