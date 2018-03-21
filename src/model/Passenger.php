<?php

class Passenger implements \JsonSerializable
{

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }

    private $id;
    private $passportNum;
    private $identityCard;
    private $countryCode;
    private $fname;
    private $mname;
    private $lname;
    private $dob;


    function __set($attribute, $value)
    {
        $this->$attribute = $value;

    }

    function __get($attribute)
    {
        return $this->$attribute;
    }


}