<?php
require_once __DIR__ . "/../../database/DAO.php";
require_once __DIR__ . "/../../model/Account.php";
require_once __DIR__ . "/../../model/Booking.php";

//comment out below
$_GET['cookie']="SFveD";

$cookie = $_GET['cookie'];


$acc = DAO::getInstance()->getAccountByCookie($cookie);

$pendingBooking = DAO::getInstance()->getPendingBookings($acc);

if(!isset($pendingBooking)) {
    $pendingBooking = DAO::getInstance()->createPendingBooking($acc);
}

//Add flight id
DAO::getInstance()->addFlightToBooking($pendingBooking, $_GET['flightId']);