<?php
require_once("../model/Account.php");
require_once("../model/Cookie.php");
header("Access-Control-Allow-Origin: *");

$cookie = new Cookie();

//var_dump($cookie)
echo json_encode($cookie);


?>