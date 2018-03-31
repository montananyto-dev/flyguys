<?php
require_once __DIR__ . "/../../database/DAO.php";
require_once __DIR__ . "/../../model/Account.php";
require_once __DIR__ . "/../../model/Booking.php";

$toEncode = [];

$cookie = $_GET['cookie'];

$acc = DAO::getInstance()->getAccountByCookie($cookie);

$pendingBooking = DAO::getInstance()->getPendingBookings($acc);

if(isset($pendingBooking)) {
    $toEncode = DAO::getInstance()->getFlightsByBooking($pendingBooking);
}

echo json_encode($toEncode);