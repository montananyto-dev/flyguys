<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 05/03/2018
 * Time: 16:23
 */

$serverName = "localhost";
$username = "flyguys";
$password = "Kingston2017!";

try {
    $connection = new PDO("mysql:host=$serverName;dbname=flyguys", $username, $password);
    // set the PDO error mode to exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}

