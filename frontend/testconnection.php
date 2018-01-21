<?php



require_once('dbconnection.php');
require_once('configdb.php');


$database = new DBConnection($dbconfig);  




// --------------------------------------------------------------------------------------------------
// working live
// --------------------------------------------------------------------------------------------------
// try{
//     $dbh = new pdo( 'mysql:host=108.179.213.60;dbname=kingsub3_flyguys','kingsub3_tony','Kingston2017!',
//                     array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
//     die(json_encode(array('outcome' => true)));
// }
// catch(PDOException $ex){
//     die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
// }
// --------------------------------------------------------------------------------------------------
// working locally
// --------------------------------------------------------------------------------------------------
// try{
//     $dbh = new pdo( 'mysql:host=localhost;dbname=flyguys',
//                     'root',
//                     '',
//                     array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
//     die(json_encode(array('outcome' => true)));
// }
// catch(PDOException $ex){
//     die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
// }
// --------------------------------------------------------------------------------------------------
// working live 
// --------------------------------------------------------------------------------------------------
// $servername = "108.179.213.60";
// $database = "kingsub3_flyguys";
// $username = "kingsub3_tony";
// $password = "Kingston2017!";

// // Create connection

// $conn = mysqli_connect($servername, $username, $password, $database);

// // Check connection

// if (!$conn) {

//     die("Connection failed: " . mysqli_connect_error());

// }
// echo "Connected successfully";
// //mysqli_close($conn);
// --------------------------------------------------------------------------------------------------
?>


