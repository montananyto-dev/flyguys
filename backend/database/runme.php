<?php

require_once('DBconnection.php');
require_once ('Test.php');

$test = new Test();

$result = $test->getAllFlight();

var_dump($result);