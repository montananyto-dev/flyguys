<?php

header("Access-Control-Allow-Origin: *");

require_once __DIR__ . "/../model/Flight.php";
require_once __DIR__ . "/../database/DAO.php";




$data = json_decode(file_get_contents('php://input'), true);

echo json_encode($data);

