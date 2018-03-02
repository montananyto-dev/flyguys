<?php
require_once __DIR__ . "/../../model/Region.php";
require_once __DIR__ . "/../../model/Location.php";
header("Access-Control-Allow-Origin: *");

$regions = Region::getAll();

$locationNames = array();
foreach($regions as $region) {
    foreach($region->getLocations() as $location) {
        array_push($locationNames, $location->getName()); // Fill the $locations array with JUST the name per location
    }
}

echo json_encode($locationNames);

?>