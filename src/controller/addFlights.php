<?php

require_once __DIR__ . "/../database/DAO.php";


header("Access-Control-Allow-Origin: *");



$data = json_decode(file_get_contents('php://input'), true);

$invalid = "The flight could not be added to the system";

if(isset($data)){

    DAO::getInstance()->addANewFlight($data);

}else{

   echo json_encode($invalid);
}



