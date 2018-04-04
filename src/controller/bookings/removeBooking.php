<?php


require_once __DIR__ . "/../../database/DAO.php";
require_once __DIR__ . "/../../model/Account.php";
require_once __DIR__ . "/../../model/Booking.php";

$cookie = $_GET['cookie'];
$flightId = $_GET['flightId'];

$valid = "The booking has been successfully removed";


$acc = DAO::getInstance()->getAccountByCookie($cookie);

$pendingBooking = DAO::getInstance()->getPendingBookings($acc);

if (is_object($pendingBooking)) {

    $result = DAO::getInstance()->deleteFlightFromBooking($flightId);

    if($result){

        echo $valid;
    }

} else {


}