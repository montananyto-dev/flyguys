<?php
require_once __DIR__ . "/../../model/Location.php";
require_once __DIR__ . "/../../model/Connection.php";
header("Access-Control-Allow-Origin: *");

$fromLocationName = $_GET['name'];

$connections = Location::getByName($fromLocationName)->getConnections();

$toLocations = array();
foreach($connections as $connection) {
    array_push($toLocations, $connection->getToLocation()->getName());
}

echo json_encode($toLocations);

?>