<?php

require_once("login.php");

require_once("Account.php");
require_once("Booking.php");
//$acc = new Account('dsfsdf','myPass','rtgfggdf');
//$acc->save();

//require_once ("Cookie.php");
//require_once ("../database/Dbconnection.php");
//
//$cookie_sample = "rtgfggdf";
//$cookie = new Cookie();
//
//$response = $cookie->checkIfCookieExist($cookie_sample);
//
//var_dump($response);

$email = "tony@gmail.com";
$password = "tony";

// need to decrypt password


//$login = new Login();
//$account = $login->login($email,$login);

//var_dump($account);

$account = new Account($email,$password,$cookie);
$account->save();