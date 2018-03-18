<?php
require_once("../../model/Location.php");
require_once("../../dao/dao.php");
header("Access-Control-Allow-Origin: *");

$allLocations = getLocations();

$names = array();
foreach($allLocations as $location) {
    array_push($names, $location->__get("name"));
}

echo json_encode($names);

