<?php


require_once("Account.php");
require_once("Booking.php");
require_once("Cookie.php");
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

// $email = "tony@gmail.com";
// $password = "tony";

$region = Region::getRegions();

// need to decrypt password


//$login = new Login();
//$account = $login->login($email,$login);

//var_dump($account);


//$temp = new Cookie();
//$cookie = $temp->returnCookie();
//
//
//
//$account = new Account($email,$password,$cookie);
//$account->save();
//
//$cookie_name = $temp->__getCookieName();
//
//
//if(count($_COOKIE) > 0) {
//    echo "Cookies are enabled.";
//} else {
//    echo "Cookies are disabled.";
//}
//
//echo $cookie_name;
//var_dump($cookie);