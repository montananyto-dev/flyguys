<?php
require_once('DBconnection.php');
require_once( __DIR__ . '/../model/Location.php');

function getAllAccounts() {
    global $connection;
    $statement = $connection->prepare('SELECT id, email, password, cookie, salt FROM account');
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_CLASS, 'Account');
    return $result;

}

function getAllRegions() {
    global $connection;
    $statement = $connection->prepare('SELECT id, name FROM region');
    $statement->execute();

    $result = $statement->fetchAll(PDO::FETCH_CLASS, 'Region');

    return $result;
}

function getAllLocations() {
    global $connection;

    $statement = $connection->prepare('SELECT * FROM location');
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_CLASS, 'Location');
}

// function setAttributeOnArray($array, $attribute, $value) {
//     foreach($array as $item) {
//         $item->$attribute = $value;
//     }
// }

?>