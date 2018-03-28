<?php
require_once("../model/Location.php");
require_once("../database/DAO.php");
header("Access-Control-Allow-Origin: *");



//$regionFlights = DAO::getInstance()->getAllFlightsByRegion('Europe');

//$region = DAO::getInstance()->getRegions('name'. "Stansted", true);


//$regionName = DAO::getInstance()->getRegionByName('Domestic');
//
//$flight = DAO::getInstance()->getAllFlightsByRegion($regionName);;


$location1 = 'Stansted';
$location2 = 'Paris';

$result = DAO::getInstance()->getConnectionFromTwoLocations($location1,$location2);

echo json_encode($result);

