<?php
require_once( __DIR__ . "/Entity.php");
require_once(__DIR__ . '/../database/DBWrapper.php');

class Account implements \JsonSerializable
{

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }

    private $acc_id;
    private $email;
    private $password;
    private $cookie;

    function __set($attribute, $value) {
        if($property = 'password') {
            $salt = "123456789";
            $value = crypt($value, $salt);
        }
        $this->$attribute = $value;
    }

    function __get($attribute) {
        return $this->$attribute;
    }

}
