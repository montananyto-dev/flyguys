<?php 
require_once("Entity.php");

class Account extends Entity {

    private static $count;

    private $acc_id;
    private $email;
    private $password;
    private $cookie;
    private $salt;
    function __construct($email,$password,$cookie) {
        $this->email=$email;
        $this->password=$password;
        $this->cookie=$cookie;
    }

    public static function get($number) {
        $toReturn = new Account("something","yay","boo");
        $toReturn->setId($number);
        return $toReturn;
    }

    private function setId($number) {
        $this->acc_id=$number;
    }

    function setEmail($email) {
        $this->email=$email;
    }


    function save() {
        if(isset($this->acc_id)) {
            echo "Updating existing account\n";
        } else {
            echo "Inserting new account\n";
        }
    }

}

?>