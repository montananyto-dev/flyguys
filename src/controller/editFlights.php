<?php

require_once __DIR__ . "/../database/DAO.php";


header("Access-Control-Allow-Origin: *");


$flightId = $_GET['flightId'];
$departureTime = $_GET['departureTime'];
$capacity = $_GET['capacity'];

$valid = "The flight has been edited";
$invalid = "The details of the flight could not be edited";


if ((isset($flightId)) && (isset($departureTime)) && (isset($capacity))) {

     DAO::getInstance()->editFlight($flightId, $departureTime, $capacity);

    echo json_encode($valid);

} else {

    echo json_encode($invalid);

}
