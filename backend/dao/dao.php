<?php
require_once(__DIR__ . '/../database/DBconnection.php');
require_once(__DIR__ . '/../model/Location.php');
require_once(__DIR__ . '/../model/Flight.php');
require_once(__DIR__ . '/../model/Connection.php');
require_once(__DIR__ . '/../model/Region.php');

function getAllAccounts()
{
    global $conn;
    $statement = $conn->prepare('SELECT id, email, password, cookie, salt FROM account');
    $statement->execute();

    $result = $statement->fetchAll(PDO::FETCH_CLASS, 'Account');
    return $result;

}

function getRegions($property = 1, $value = 1)
{
    global $conn;
    $sql = "SELECT id, name FROM region WHERE $property = '$value'";

    $statement = $conn->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_CLASS, 'Region');


    return $result;
}

function getLocations($property = 1, $value = 1)
{
    global $conn;

    $sql = "SELECT * FROM location where $property = '$value'";

    $statement = $conn->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_CLASS, 'Location');

    foreach($result as $row) {
        $region = getRegions('id', $row->__get('region_id'));
        $row->__set('region',$region);
    }

    return $result;
}


function getConnections($property = 1, $value = 1)
{
    global $conn;

    $sql = "SELECT * FROM connection where $property = '$value'";

    $statement = $conn->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_CLASS, 'Connection');

    foreach($result as $row) {
        $fromLocation = getLocations('id', $row->location_id1);
        $toLocation = getLocations('id', $row->location_id2);

        $row->__set('fromLocation', $fromLocation);
        $row->__set('toLocation', $toLocation);
    }

    return $result;
}

function getConnectionById($id) {
    return getConnections('id', $id)[0];
}

function getAllConnections() {
    return getConnections();
}

function getAllLocationByRegionName($regionName){

    $region = getRegions('name', $regionName)[0];

    $locations = getLocations('region_id', $region->__get('id'));

    return $locations;
}

function getAllFlights() {
    global $conn;

    $statement = $conn->prepare('SELECT * FROM flight');
    $statement->execute();
    $result= $statement->fetchAll(PDO::FETCH_CLASS,'flight');

    foreach($result as $row) {
        $row->__set('connection',getConnections('connection_id',$row->__get('connection_id')));
    }

    return $result;
}

function getConnectedLocations($location) {
    $connections = getConnections('location_id1', $location->__get('id'));

    $toLocations = array();
    foreach($connections as $connection) {
        array_push($toLocations, $connection->__get('toLocation'));
    }

    return $toLocations;
}




//function setPerItem($array, $identifier, $property, $anonFunction) {
//    foreach($array as $item) {
//        $item->$property = $anonFunction($identifier);
//    }
//}

