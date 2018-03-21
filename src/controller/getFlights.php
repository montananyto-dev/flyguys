<?php
require_once __DIR__ . "/../model/Region.php";
require_once __DIR__ . "/../model/Location.php";
require_once __DIR__ . "/../database/DAO.php";

header("Access-Control-Allow-Origin: *");

$toEncode;


if (isset($_GET['region'])) {

    $region = DAO::getInstance()->getRegionByName($_GET['region']);

    if (!isset($region)) { // if no region has been set...

        $toEncode = array(); // ... return empty array

    } else {
        $toEncode = DAO::getInstance()->getAllFlightsByRegion($region);

    }
} else {

    $toEncode = DAO::getInstance()->getAllFlights();

}

echo json_encode($toEncode);

