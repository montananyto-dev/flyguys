<?php

header("Access-Control-Allow-Origin: *");

require_once __DIR__ . "/../../model/Flight.php";
require_once __DIR__ . "/../../database/DAO.php";

$data = json_decode(file_get_contents('php://input'), true);


$invalid = "The flight could not be added to the system";

if(isset($data)){

   $insertId =  DAO::getInstance()->addANewFlight($data);

    echo json_encode("The flight " . $insertId . " has been added to the system");

}else{

   echo json_encode($invalid);
}



