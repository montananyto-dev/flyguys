<?php
require_once __DIR__ . "/../../model/Region.php";
require_once __DIR__ . "/../../model/Location.php";
header("Access-Control-Allow-Origin: *");

$regions = Region::getAll();

$locations = array();
foreach($regions as $region) {
    foreach($region->getLocations() as $location) {
        array_push($locations, $location->getName());
    }
}

echo json_encode($locations);

?>