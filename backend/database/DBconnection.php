<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 05/03/2018
 * Time: 16:23
 */

//Tony local connection

$serverName = "localhost";
$username = "flyguys";
$password = "Kingston2017!";

try {
    $conn = new PDO("mysql:host=$serverName;dbname=flyguys", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}

//James local connection

$serverName = "localhost";
$username = "flyguysUser";
$password = "Kingston2017!";

try {
    $conn = new PDO("mysql:host=$serverName;dbname=flyguys", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}


