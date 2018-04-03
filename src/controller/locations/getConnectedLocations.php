<?php

header("Access-Control-Allow-Origin: *");

require_once __DIR__ . "/../../model/Location.php";
require_once __DIR__ . "/../../model/Connection.php";
require_once "../../database/DAO.php";

$toEncode = array();


if(isset($_GET["name"])) {

    $location = DAO::getInstance()->getLocationByName($_GET["name"]);

    if(isset($location)) {
        $toLocations = DAO::getInstance()->getLocationsConnectedTo($location);

        foreach($toLocations as $location) {
            array_push($toEncode, $location->name);
        }
    }


}else{

    $toEncode = [];
}

echo json_encode($toEncode);