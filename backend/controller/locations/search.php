<?php
require_once __DIR__ . "/../../model/Region.php";
require_once __DIR__ . "/../../model/Location.php";
header("Access-Control-Allow-Origin: *");


$fromLocation = Location::getByName($_GET['fromName']);
$toLocation = Location::getByName($_GET['toName']);


$flight_connection = Connection::getConnection($fromLocation,$toLocation);

$flights = $flight_connection->getFlights();

echo json_encode($flights);
?>