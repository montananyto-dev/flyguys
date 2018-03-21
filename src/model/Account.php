<?php

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
    private $salt;

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
