<?php
require_once __DIR__ . "/../../model/Region.php";
require_once __DIR__ . "/../../model/Location.php";
require_once __DIR__ . "/../../model/Day.php";
require_once __DIR__ . "/../../database/DAO.php";

header("Access-Control-Allow-Origin: *");

$toEncode;


if( !(isset($_GET['fromName']) || isset($_GET['toName'])) ) {
    $toEncode = [];
}

$fromLocation = DAO::getInstance()->getLocationByName($_GET['fromName']);
$toLocation = DAO::getInstance()->getLocationByName($_GET['toName']);

if(isset($_GET['date'])) {
    $toEncode = DAO::getInstance()->getFlightsBetweenByDate($fromLocation, $toLocation, $_GET['date']);
} else if(isset($_GET['day'])) {
    $day = new Day($_GET['day']);
    $toEncode = DAO::getInstance()->getFlightsBetweenByDay($fromLocation, $toLocation, $day);
} else {
    $toEncode = DAO::getInstance()->getFlightsBetween($fromLocation, $toLocation);
}


echo json_encode($toEncode);