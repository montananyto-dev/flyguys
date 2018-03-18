<?php
require_once('../database/DBconnection.php');
require_once(__DIR__ . '/../model/Location.php');

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

function getAllLocationByRegion($region){

    global $connection;
    $statement = $connection->prepare('SELECT * FROM location WHERE region_id = ?');
    $statement->execute([$region]);
    $result = $statement->fetchAll(PDO::FETCH_CLASS,'Location');

    return $result;
}

function getAllLocationByRegionName($region){

    global $connection;
    $statement = $connection->prepare('SELECT id FROM region WHERE name = ?');
    $statement->execute([$region]);
    $result= $statement->fetchAll(PDO::FETCH_COLUMN,'region');

    $statement = $connection->prepare('SELECT * FROM location WHERE region_id = ?');
    $statement->execute([$result[0]]);
    $results = $statement->fetchAll(PDO::FETCH_CLASS,'Location');

    return $results;
}

