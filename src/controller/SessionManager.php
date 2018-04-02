<?php

header("Access-Control-Allow-Origin: *");

require_once("../model/Account.php");
require_once("../model/Cookie.php");
require_once __DIR__ . "/../database/DAO.php";

$cookie = new Cookie();

DAO::getInstance()->addAccount($cookie->cookie_name);

$toEncode = array("idCode" => $cookie->cookie_name, "expiry" => $cookie->cookie_time);


echo json_encode($toEncode);




