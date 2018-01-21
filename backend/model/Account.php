<?php 
class Account {
    $id;
    $email;
    $password;
    $cookie;
    $salt;

    function __construct() {
        print "hello";
    }
}

$obj = new Account();

?>