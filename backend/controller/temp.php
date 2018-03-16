<?php
require_once("../model/Location.php");
require_once("../database/dao.php");
header("Access-Control-Allow-Origin: *");

$allLocations = getAllLocations();

$names = array();
foreach($allLocations as $location) {
    array_push($names, $location->__get("name"));
}

//echo json_encode($names);

$locations = getAllLocationByRegion(6);
//var_dump($locations);

$location = getAllLocationByRegionName("Europe");
var_dump($location);

