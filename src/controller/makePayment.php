<?php

header("Access-Control-Allow-Origin: *");

require_once __DIR__ . "/../model/Flight.php";
require_once __DIR__ . "/../database/DAO.php";




$data = json_decode(file_get_contents('php://input'), true);

$acc = DAO::getInstance()->getAccountByCookie($data["cookie"]);

$booking = DAO::getInstance()->getPendingBookings($acc);

foreach($data['passengers'] as $passengerInfo) {
    $passengerObj = DAO::getInstance()->createPassenger($passengerInfo);
    DAO::getInstance()->addPassengerToBooking($booking, $passengerObj);
}

DAO::getInstance()->completeBooking($booking);

echo json_encode($data);

