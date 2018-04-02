<?php

header("Access-Control-Allow-Origin: *");

require_once __DIR__ . "/../database/DAO.php";

$flightID = $_GET['flight_id'];

$valid = "The flight " . $flightID . " was successfully removed from the system";
$invalid = "The flight " . $flightID . " could not be removed from the system";


if (isset($flightID)) {

    DAO::getInstance()->deleteFlightByID($flightID);

    echo json_encode($valid);

} else {

    echo json_encode($invalid);

}