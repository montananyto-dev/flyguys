<?php
require_once __DIR__ . "/../../model/Region.php";
require_once __DIR__ . "/../../model/Location.php";
require_once __DIR__ . "/../../database/DAO.php";

header("Access-Control-Allow-Origin: *");



if( !(isset($_GET['fromName']) || isset($_GET['toName'])) ) {
    echo json_encode([]);
}


$fromLocation = DAO::getInstance()->getLocationByName($_GET['fromName']);
$toLocation = DAO::getInstance()->getLocationByName($_GET['toName']);

$relevantFlights = DAO::getInstance()->getUpcomingFlights($fromLocation, $toLocation);

echo json_encode($relevantFlights);