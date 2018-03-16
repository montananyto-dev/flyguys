<?php
require_once(__DIR__ . "/Entity.php");
require_once(__DIR__ . '/../database/DBWrapper.php');
require_once(__DIR__ . "/Region.php");

class Location implements \JsonSerializable
{

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }

    private $id;
    private $region_id;
    private $name;
    private $code;
    private $timezone;
    private $offset;
    private $creation_date;

    function __set($name, $value)
    {
        $this->$name = $value;
    }

    function __get($name)
    {
        return $this->$name;
    }


}