<?php
require_once("../../model/Location.php");
require_once("../../database/DAO.php");
header("Access-Control-Allow-Origin: *");

$allLocations = DAO::getInstance()->getLocations();

$names = array();
foreach($allLocations as $location) {
    array_push($names, $location->__get("name"));
}

echo json_encode($names);

