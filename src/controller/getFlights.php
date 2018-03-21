<?php
require_once __DIR__ . "/../model/Region.php";
require_once __DIR__ . "/../model/Location.php";
require_once __DIR__ . "/../database/DAO.php";

header("Access-Control-Allow-Origin: *");

$toEncode;

//$_GET['region'] = "Europe";

if (isset($_GET['region'])) {

    $region = DAO::getInstance()->getRegions("name", $_GET['region'], true);

    if (!isset($region)) { // if no region has been set...

        $toEncode = array(); // ... return empty array

    } else {
        $toEncode = DAO::getInstance()->getAllFlightsByRegion($region->name);

    }
} else {

    $toEncode = DAO::getInstance()->getFlights();

}

echo json_encode($toEncode);

