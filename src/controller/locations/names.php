<?php

header("Access-Control-Allow-Origin: *");

require_once("../../model/Location.php");
require_once("../../database/DAO.php");


$allLocations = DAO::getInstance()->getAllLocations();


$names = array();
foreach($allLocations as $location) {
    array_push($names, $location->name);
}

echo json_encode($names);

