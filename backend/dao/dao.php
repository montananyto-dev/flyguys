<?php
require_once('../database/DBconnection.php');
require_once(__DIR__ . '/../model/Location.php');
require_once(__DIR__ . '/../model/Flight.php');

function setPropertyIterator($array, $identifier, $property, $)


function getAllAccounts()
{
    global $connection;
    $statement = $connection->prepare('SELECT id, email, password, cookie, salt FROM account');
    $statement->execute();

    $result = $statement->fetchAll(PDO::FETCH_CLASS, 'Account');
    return $result;

}

function getAllRegions()
{
    global $connection;
    $statement = $connection->prepare('SELECT id, name FROM region');
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_CLASS, 'Region');

    setPropertyIterator($result, 'id', '')

    return $result;
}

function getAllLocations()
{
    global $connection;
    $statement = $connection->prepare('SELECT * FROM location');
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_CLASS, 'Location');

    return $result;
}

function getAllLocationByRegionId($regionID){

    global $connection;
    $statement = $connection->prepare('SELECT * FROM location WHERE region_id = ?');
    $statement->execute([$regionID]);
    $result = $statement->fetchAll(PDO::FETCH_CLASS,'Location');

    return $result;
}

function getAllLocationByRegionName($regionName){

    global $connection;
    $statement = $connection->prepare('SELECT id FROM region WHERE name = ?');
    $statement->execute([$regionName]);
    $result= $statement->fetchAll(PDO::FETCH_COLUMN,'region');

    $statement = $connection->prepare('SELECT * FROM location WHERE region_id = ?');
    $statement->execute([$result[0]]);
    $results = $statement->fetchAll(PDO::FETCH_CLASS,'Location');

    return $results;
}

function getAllFlights() {
    global $connection;

    $statement = $connection->prepare('SELECT * FROM flight');
    $statement->execute();
    $result= $statement->fetchAll(PDO::FETCH_CLASS,'flight');

    return $result;
}

