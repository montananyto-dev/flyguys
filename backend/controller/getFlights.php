<?php
require_once __DIR__ . "/../model/Region.php";
require_once __DIR__ . "/../model/Location.php";
header("Access-Control-Allow-Origin: *");

$desiredRegionName = $_GET['region'];

$allFlights = array();
foreach(Region::getAll() as $region) {
    foreach($region->getLocations() as $location) {
        foreach($location->getConnections() as $flightConnection) {
            foreach($flightConnection->getFlights() as $flight) {
                array_push($allFlights, $flight);
            }
        }
    }
}

if(isset($desiredRegionName)) {
    $relevantFlights = array();
    foreach($allFlights as $flight) {
        $regionName = $flight->getConnection()->getToLocation()->getRegion()->getName();
        if($regionName == $desiredRegionName) {
            array_push($relevantFlights, $flight);
        }
    }
    echo json_encode($relevantFlights);
} else {
    echo json_encode($allFlights);
}





// if(count($relevantFlights)==0) {
//     header('HTTP/1.1 500 Internal Server Error');
//     die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
// }



