<?php
require_once __DIR__ . "/../model/Region.php";
require_once __DIR__ . "/../model/Location.php";
require_once __DIR__ . "/../dao/dao.php";

header("Access-Control-Allow-Origin: *");

if(isset($_GET['region'])) {
    //$region = getFlights($_GET['region']);
} else {
    echo json_encode(getAllFlights());
}


