<?php
require_once __DIR__ . "/../../database/DAO.php";
require_once __DIR__ . "/../../model/Account.php";
require_once __DIR__ . "/../../model/Booking.php";

//comment out below
$_POST['cookie']="SFveD";

$cookie = $_POST['cookie'];


$acc = DAO::getInstance()->getAccounts('cookie', $cookie, true);

$booking = DAO::getInstance()->getPendingBookings($acc->id, true);

if(!isset($booking)) {
    $newId = DAO::getInstance()->addBooking($acc->id);
    $booking = DAO::getInstance()->getBookings('id', $newId);
}

echo json_encode($booking);

