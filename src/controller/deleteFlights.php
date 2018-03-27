<?php

require_once __DIR__ . "/../database/DAO.php";
require_once __DIR__ . "/../model/Region.php";
require_once __DIR__ . "/../model/Location.php";
require_once __DIR__ . "/../model/Flight.php";

header("Access-Control-Allow-Origin: *");

$flightID = $_GET['flight_id'];

$valid = "The flight was successfully removed from the system";
$invalid = "The flight could not be removed from the system";


    if (isset($flightID)){

        DAO::getInstance()->deleteFlightByID($flightID);

        echo json_encode($valid);


    }else{

        echo json_encode($invalid);

    }