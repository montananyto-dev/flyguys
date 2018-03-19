<?php

class Connection implements \JsonSerializable
{

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }

    private $id;
    private $fromLocation;
    private $toLocation;
    private $flight_duration;
    private $cost;

    function __set($attribute, $value)
    {
        $this->$attribute = $value;
    }

    function __get($attribute)
    {
        return $this->$attribute;
    }
}