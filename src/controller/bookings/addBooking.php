<?php

require_once __DIR__ . "/../../database/DAO.php";
require_once __DIR__ . "/../../model/Account.php";
require_once __DIR__ . "/../../model/Booking.php";

$cookie = $_GET['cookie'];


$acc = DAO::getInstance()->getAccountByCookie($cookie);

$pendingBooking = DAO::getInstance()->getPendingBookings($acc);

if (is_object($pendingBooking)) {

    $result = DAO::getInstance()->addFlightToBooking($pendingBooking, $_GET['flightId']);

} else {

    $pendingBooking = DAO::getInstance()->createPendingBooking($acc);

    $result = DAO::getInstance()->addFlightToBooking($pendingBooking, $_GET['flightId']);

}