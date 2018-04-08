<?php

require_once __DIR__ . "/../../database/DAO.php";
require_once __DIR__ . "/../../model/Account.php";
require_once __DIR__ . "/../../model/Booking.php";
require_once __DIR__ . "/../../model/Flight.php";


$toEncode = [];

$cookie = $_GET['cookie'];
$amount = $_GET['amount'];


$acc = DAO::getInstance()->getAccountByCookie($cookie);

$pendingBooking = DAO::getInstance()->getPendingBookings($acc);

if (is_object($pendingBooking)) {
    $flights = DAO::getInstance()->getFlightsByBooking($pendingBooking);

    $totalAmount = 0;
    foreach($flights as $flight) {
        $totalAmount += $flight->connection->cost;
    }

    $toEncode = array("total" => $totalAmount * $amount);
}

echo json_encode($toEncode);

