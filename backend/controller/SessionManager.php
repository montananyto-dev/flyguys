<?php
require_once("../model/Account.php");
require_once("../model/Cookie.php");
header("Access-Control-Allow-Origin: *");


$cookie = new Cookie();

// Insert new account into DB

//echo json_encode($cookie);

$toEncode = array("idCode" => $cookie->cookie_name, "expiry" => $cookie->cookie_time);


echo json_encode($toEncode);




