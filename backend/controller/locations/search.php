<?php
require_once __DIR__ . "/../../model/Region.php";
require_once __DIR__ . "/../../model/Location.php";
require_once __DIR__ . "/../../database/DAO.php";

header("Access-Control-Allow-Origin: *");



if( !(isset($_GET['fromName']) || isset($_GET['toName'])) ) {
    echo json_encode([]);
}


$fromLocation = DAO::getInstance()->getLocations("name", $_GET['fromName'], true);
$toLocation = DAO::getInstance()->getLocations("name", $_GET['toName'], true);

// get flights //