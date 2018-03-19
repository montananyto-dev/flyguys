<?php
require_once __DIR__ . "/../../model/Location.php";
require_once __DIR__ . "/../../model/Connection.php";
require_once "../../database/DAO.php";

header("Access-Control-Allow-Origin: *");

$toEncode = array();

$l = "Stansted";

//if(isset($_GET["name"])) {
if(isset($l)) {
    //$location = DAO::getInstance()->getLocations("name", $_GET["name"], true);
    $location = DAO::getInstance()->getLocations("name", $l, true);

    if(isset($location)) {
        $toLocations = DAO::getInstance()->getConnectedLocations($location);

        foreach($toLocations as $location) {
            array_push($toEncode, $location->name);
        }
    }
}

echo json_encode($toEncode);