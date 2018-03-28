<?php

require_once __DIR__ . "/../database/DAO.php";

header("Access-Control-Allow-Origin: *");

$locationFrom= $_GET['locationFrom'];
$locationTo = $_GET['locationTo'];

$invalid = "The cost and flight duration could not be retrieved";


if ((isset($locationFrom))&&(isset($locationTo))){

    $result = DAO::getInstance()->getCostAndFlightDurationForConnection($locationFrom,$locationTo);

    echo json_encode($result);


}else{

    echo json_encode($invalid);

}