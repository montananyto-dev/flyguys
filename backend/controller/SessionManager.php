<?php
require_once("../model/Account.php");
header("Access-Control-Allow-Origin: *");

$account = new Account('fdgdfg','dfgdfgd','ssdfdsfdf');

echo json_encode($account);


?>