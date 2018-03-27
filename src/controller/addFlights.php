<?php

//require_once __DIR__ . "/../model/Region.php";
//require_once __DIR__ . "/../model/Location.php";
//require_once __DIR__ . "/../model/Day.php";
require_once __DIR__ . "/../database/DAO.php";


header("Access-Control-Allow-Origin: *");


    $regionNames = DAO::getInstance()->getAllRegionNames();

    echo json_encode($regionNames);



//$flightID = $_GET['flight_id'];
//
//$valid = "The flight was successfully removed from the system";
//$invalid = "The flight could not be removed from the system";
//
//echo $flightID;
//
//if (isset($flightID)){
//
//    DAO::getInstance()->deleteFlightByID($flightID);
//
//    echo json_encode($valid);
//
//
//}else{
//
//    echo json_encode($invalid);
//
//}

