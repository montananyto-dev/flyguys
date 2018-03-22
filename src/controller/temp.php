<?php
require_once("../model/Location.php");
require_once("../database/DAO.php");
header("Access-Control-Allow-Origin: *");



//$regionFlights = DAO::getInstance()->getAllFlightsByRegion('Europe');

//$region = DAO::getInstance()->getRegions('name'. "Stansted", true);


$regionName = DAO::getInstance()->getRegionByName('Domestic');

$flight = DAO::getInstance()->getAllFlightsByRegion($regionName);;


echo json_encode($flight);

