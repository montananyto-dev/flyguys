<?php

require_once("Account.php");
require_once("Booking.php");
require_once("../database/testconnection.php");

$acc = Account::get(1);
$acc->setEmail("new@email.com");

$book = new Booking($acc, "2018-02-11");
$book->save();


