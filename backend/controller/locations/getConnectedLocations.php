<?php
require_once __DIR__ . "/../../model/Location.php";
require_once __DIR__ . "/../../model/Connection.php";
require_once "../../dao/dao.php";

header("Access-Control-Allow-Origin: *");

//$fromLocationName = $_GET['name'];
$fromLocationName = "Stansted";

$fromLocation = getLocations('name', $fromLocationName);

$allToLocations = getConnectedLocations($fromLocation[0]);

$names = array();
foreach($allToLocations as $location) {
    array_push($names, $location->__get("name"));
}

echo json_encode($names);
