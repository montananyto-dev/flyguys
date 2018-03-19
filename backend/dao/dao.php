<?php
require_once(__DIR__ . '/../database/DBconnection.php');
require_once(__DIR__ . '/../model/Location.php');
require_once(__DIR__ . '/../model/Flight.php');
require_once(__DIR__ . '/../model/Connection.php');
require_once(__DIR__ . '/../model/Region.php');

function query($sql, $class) {

    global $conn;

    $statement = $conn->prepare($sql);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_CLASS, $class);

    return $results;
}

function getAccounts($property = 1, $value = 1, $singleReturn = false)
{
    $result = query("SELECT id, email, password, cookie, salt FROM account WHERE $property = '$value'", "Account");

    if($singleReturn) {
        return $result[0];
    }

    return $result;

}

function getRegions($property = 1, $value = 1, $singleReturn = false)
{

    $result = query("SELECT id, name FROM region WHERE $property = '$value'", "Region");

    if($singleReturn) {
        return result[0];
    }

    return $result;
}

function getLocations($property = 1, $value = 1, $singleReturn = false)
{
    $result = query("SELECT * FROM location where $property = '$value'", "Location");

    foreach($result as $row) {
        $region = getRegions('id', $row->__get('region_id'), true);
        $row->__set('region',$region);
    }

    if($singleReturn) {
        return $result[0];
    }

    return $result;
}


function getConnections($property = 1, $value = 1, $singleReturn = false)
{
    $result = query("SELECT * FROM connection WHERE $property = '$value'", "Connection");

    foreach($result as $row) {
        $fromLocation = getLocations('id', $row->location_id1, true);
        $toLocation = getLocations('id', $row->location_id2, true);

        $row->__set('fromLocation', $fromLocation);
        $row->__set('toLocation', $toLocation);
    }

    if($singleReturn) {
        return $result[0];
    }

    return $result;
}

function getFlights($property = 1, $value = 1, $singleReturn = false) {

    $result = query("SELECT * FROM flight WHERE $property = '$value'", "Flight");

    foreach($result as $row) {
        $connection = getConnections('id',$row->__get('connection_id'), true);
        $row->__set('connection', $connection);
    }

    if($singleReturn) {
        return $result[0];
    }

    return $result;
}

function getAllLocationByRegionName($regionName){

    $region = getRegions('name', $regionName)[0];

    $locations = getLocations('region_id', $region->__get('id'));

    return $locations;
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

