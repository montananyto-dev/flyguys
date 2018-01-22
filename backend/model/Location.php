<?php

class Location
{
    private $id;
    private $region_id;
    private $name;
    private $code;
    private $timezone;
    private $offset;
    private $creation_date;

    function __construct($id, $region_id, $name, $code, $timezone, $offset, $creation_date)
    {

        $this->id = $id;
        $this->region_id = $region_id;
        $this->name = $name;
        $this->code = $code;
        $this->timezone = $timezone;
        $this->offset = $offset;
        $this->creation_date = $creation_date;
    }

    function __set($attribute, $value)
    {
        $this->$attribute = $value;
    }

    function __get($attribute)
    {
        return $this->$attribute;
    }
}