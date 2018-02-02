<?php
require_once("Entity.php");
require_once('../database/Test.php');

class Account extends Entity
{

    private static $count;

    private $acc_id;
    private $email;
    private $password;
    private $cookie;

    function __construct($email, $password, $cookie)
    {
        parent::__construct();
        $this->email = $email;
        $this->password = $password;
        $this->cookie = $cookie;
    }

    function save()
    {
        if (isset($this->acc_id)) {
            echo "Updating existing account\n";
        } else {
            Test::insert("Select * from state");
        }
    }

}

?>