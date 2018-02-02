<?php

require_once("Account.php");
require_once("Booking.php");

$acc = new Account("e@mail.com", "this", "that");
$acc->save();



