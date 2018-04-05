<?php

require_once __DIR__ . "/../../database/DAO.php";
require_once __DIR__ . "/../../model/Account.php";

$cookie = $_GET['cookie'];

$acc = DAO::getInstance()->getAccountByCookie($cookie);

echo json_encode($acc);