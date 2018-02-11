<?php

require_once('DBconnection.php');
require_once('DBWrapper.php');

$test = new DBWrapper();

$result = $test->getAllFlight();

var_dump($result);