<?php
require_once("../model/Location.php");
require_once("../database/DAO.php");
header("Access-Control-Allow-Origin: *");

DAO::getInstance()->getAllFlightsByRegion('Domestic');

