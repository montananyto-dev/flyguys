<?php
require_once __DIR__ . "/../model/Region.php";
require_once __DIR__ . "/../model/Location.php";
require_once __DIR__ . "/../database/DAO.php";

header("Access-Control-Allow-Origin: *");



$toEncode;

if(isset($_GET['region'])) {
    $region = DAO::getInstance()->getRegions("name", $_GET['region'], true);

    if(!isset($region)) { // if no region has been set...
        $toEncode = array(); // ... return empty array
    } else {
        $locations = DAO::getInstance()->getLocations("id", $region->__get("id"));

        //todo get flights related to $region


    }
} else {
    $toEncode = DAO::getInstance()->getFlights();
}

echo json_encode($toEncode);

