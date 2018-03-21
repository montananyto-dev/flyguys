<?php
require_once("../model/Location.php");
require_once("../database/DAO.php");
header("Access-Control-Allow-Origin: *");

$region = DAO::getInstance()->getRegions('name'. "Stansted", true);



echo json_encode($all);

