<?php

require_once __DIR__ . "/../../database/DAO.php";
require_once __DIR__ . "/../../model/Account.php";

$data = json_decode(file_get_contents('php://input'), true);
$cookie = $_GET['cookie'];


var_dump($data);

$invalid = "The account does not exist, please sign up";
$passwordInvalid = "The password does not match the email account";


$password = $data[1]['value'];

$acc = DAO::getInstance()->checkIfAccountExist($data);

if (is_object($acc)) {

    $account = DAO::getInstance()->checkIfAccountExistWithPassword($data);

    if (is_object($account)) {

        echo json_encode($account);

    } else {

        echo json_encode($passwordInvalid);
    }

} else {

    echo json_encode($invalid);

}
