<?php
require_once __DIR__ . "/../../model/Location.php";
require_once __DIR__ . "/../../model/Connection.php";
require_once "../../database/DAO.php";

header("Access-Control-Allow-Origin: *");

$toEncode = array();


if(isset($_GET["name"])) {
    $location = DAO::getInstance()->getLocations("name", $_GET["name"], true);

    if(isset($location)) {
        $toLocations = DAO::getInstance()->getConnectedLocations($location);

        foreach($toLocations as $location) {
            array_push($toEncode, $location->name);
        }
    }
}

echo json_encode($toEncode);