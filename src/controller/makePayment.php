<?php

$data = json_decode(file_get_contents('php://input'), true);
$cookie = $_GET['cookie'];

var_dump($data);
var_dump($cookie);