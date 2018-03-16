<?php
require_once(__DIR__ . "/Entity.php");
require_once(__DIR__ . '/../database/DBWrapper.php');

class Account implements \JsonSerializable
{

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }

    private $id;
    private $email;
    private $password;
    private $cookie;

    function __set($name, $value)
    {
        if ($name = 'password') {
            $salt = "123456789";
            $value = crypt($value, $salt);
        }
        $this->$name = $value;
    }

    function __get($name)
    {
        return $this->$name;
    }

}
