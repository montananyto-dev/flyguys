<?php


require_once __DIR__ . "/../../database/DAO.php";
require_once __DIR__ . "/../../model/Account.php";

$data = json_decode(file_get_contents('php://input'), true);
$cookie = $_GET['cookie'];

$invalid = "The account already exist, please login to your account";

$accounts = DAO::getInstance()->checkIfAccountExist($data);

if (is_object($accounts)) {

    echo json_encode($invalid);

} else {

    $email = DAO::getInstance()->addInformationToExistingPendingAccount($data,$cookie);

    $account = DAO::getInstance()->getAccountByEmail($email);

    var_dump($account);

    echo json_encode($account);

}

