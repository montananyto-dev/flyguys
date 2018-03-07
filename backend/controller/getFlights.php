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
    echo '"response":"failure","reason":"region does not exist"';
    return;
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


