<?php
require_once("../model/Location.php");
require_once("../dao/dao.php");
header("Access-Control-Allow-Origin: *");

echo json_encode( getAllLocationByRegionName('Domestic') );

