<?php
require_once("../model/Account.php");
require_once("../model/Cookie.php");
header("Access-Control-Allow-Origin: *");

$account = new Account('fdgdfg','dfgdfgd','ssdfdsfdf');
$cookie = new Cookie();

//var_dump($cookie)
echo json_encode($cookie);


?>